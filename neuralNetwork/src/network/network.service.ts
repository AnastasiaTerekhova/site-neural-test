import { Injectable } from '@nestjs/common';
import * as tf from '@tensorflow/tfjs-node';
import * as fs from 'fs';
import * as path from 'path';
import { DeleteImage } from 'src/dto/delete-img.dto';
import { NetworkCategory } from 'src/dto/network.dto';
import { Network } from './network.model';

@Injectable()
export class NetworkService {
    trainData = [];
    testData = [];
    TRAIN_DIR = 'src/dataset/tn';
    TEST_DIR = 'src/dataset/tt';
    MODEL_DIR = 'model/model.json';
    network = new Network();

    loadImages(dataDir) {
        const images = [];
        const labels = [];
        var files = fs.readdirSync(dataDir);
        for (let i = 0; i < files.length; i++) {
            var filePath = path.join(dataDir, files[i]);
            var buffer = fs.readFileSync(filePath);
            var imageTensor = tf.node
                .decodeImage(buffer)
                .resizeNearestNeighbor([96, 96])
                .toFloat()
                .div(tf.scalar(255.0))
                .expandDims();
            images.push(imageTensor);

            var hasHouse = files[i].toLowerCase().endsWith('_1.jpg');
            labels.push(hasHouse);
        }
        return [images, labels];
    }

    loadData() {
        console.log('Loading images...');
        this.trainData = this.loadImages(this.TRAIN_DIR);
        this.testData = this.loadImages(this.TEST_DIR);
        console.log('Images loaded successfully');
    }

    getTrainData() {
        return {
            images: tf.concat(this.trainData[0]),
            labels: tf
                .oneHot(tf.tensor1d(this.trainData[1], 'int32'), 2)
                .toFloat(),
        };
    }

    getTestData() {
        return {
            images: tf.concat(this.testData[0]),
            labels: tf
                .oneHot(tf.tensor1d(this.testData[1], 'int32'), 2)
                .toFloat(),
        };
    }

    async run(epochs, batchSize, modelSavePath) {
        this.loadData();

        const { images: trainImages, labels: trainLabels } =
            this.getTrainData();
        console.log('Training Images (shape): ' + trainImages.shape);
        console.log('Training Labels (shape): ' + trainLabels.shape);

        this.network.model.summary();

        const validationSplit = 0.15;
        await this.network.model.fit(trainImages, trainLabels, {
            epochs,
            batchSize,
            validationSplit,
        });

        const { images: testImages, labels: testLabels } = this.getTestData();
        const evalOutput = this.network.model.evaluate(testImages, testLabels);

        console.log(
            `\nEvalution result:\n` +
                ` Loss=${evalOutput[0].dataSync()[0].toFixed(3)}; ` +
                `Accuracy = ${evalOutput[1].dataSync()[0].toFixed(3)}; `
        );

        await this.network.model.save(`file://${modelSavePath}`);
        console.log(`Saved model to path: ${modelSavePath}`);
        return null;
    }

    async getPredict(files) {
        let mod = await tf.loadLayersModel(`file://model/model.json`);
        let tensors = [];
        files.forEach((file) => {
            let tensor = tf.node
                .decodeImage(file.buffer)
                .resizeNearestNeighbor([96, 96])
                .toFloat()
                .div(tf.scalar(255.0))
                .expandDims();
            tensors.push(tensor);
        });

        let predictions = [];
        let re = /\[/gi;
        let re1 = /]/gi;
        tensors.forEach((tensor) => {
            let prediction = mod
                .predict(tensor)
                .toString()
                .split('\n')[1]
                .replace(re, '')
                .replace(re1, '')
                .split(' ')
                .join('')
                .split(',')
                .slice(0, -1);

            let target = this.network.TARGET_CLASSES;
            let top2 = Array.from(prediction)
                .map(function (p, i) {
                    return {
                        probability: p,
                        className: target[i],
                    };
                })
                .sort(function (a: any, b: any) {
                    return b.probability - a.probability;
                })
                .slice(0, 2);
            predictions.push(top2);
        });
        var result: any = {};
        predictions.forEach((predict) => {
            console.log('////////////');
            predict.forEach((element) => {
                result[element.className] = element.probability;
                console.log(`${element.className}: ${element.probability}`);
            });
        });
        return result;
    }

    getDefaultNetwork() {
        const srcDir = path.join(__dirname, '..', '..', 'model_default');
        const destDir = path.join(__dirname, '..', '..', 'model');
        fs.copyFile(
            path.join(srcDir, 'model.json'),
            path.join(destDir, 'model.json'),
            (err) => {
                if (err) throw err;
                console.log('Файл успешно скопирован');
            }
        );
        fs.copyFile(
            path.join(srcDir, 'weights.bin'),
            path.join(destDir, 'weights.bin'),
            (err) => {
                if (err) throw err;
                console.log('Файл успешно скопирован');
            }
        );
    }

    saveTrainImage(file, category: NetworkCategory) {
        const files = fs.readdirSync(this.TRAIN_DIR);
        let fileName = '';
        let counter_0 = 0;
        let counter_1 = 0;
        let buff_0 = 1;
        let buff_1 = 1;
        files.forEach((element) => {
            let n = element.split('.')[0].split('_')[0];

            if (element.split('.')[0].split('_')[1] == '1') {
                if (Number(n) != buff_1) {
                    fileName = buff_1 + '_1.jpg';
                    fs.writeFile(
                        `${this.TRAIN_DIR}/${fileName}`,
                        file.buffer,
                        'binary',
                        function (err) {
                            if (err) {
                                throw err;
                            }
                        }
                    );
                    return fileName;
                }
                counter_1 += 1;
                buff_1 += 1;
            } else {
                if (Number(n) != buff_0) {
                    fileName = buff_0 + '_0.jpg';
                    fs.writeFile(
                        `${this.TRAIN_DIR}/${fileName}`,
                        file.buffer,
                        'binary',
                        function (err) {
                            if (err) {
                                throw err;
                            }
                        }
                    );
                    return fileName;
                }
                counter_0 += 1;
                buff_0 += 1;
            }
        });
        if (category.category == '1') {
            fileName = counter_1 + 1 + '_1.jpg';
        } else {
            fileName = counter_0 + 1 + '_0.jpg';
        }

        fs.writeFile(
            `${this.TRAIN_DIR}/${fileName}`,
            file.buffer,
            'binary',
            function (err) {
                if (err) {
                    throw err;
                }
            }
        );
        return fileName;
    }

    saveTestImage(file, category: NetworkCategory) {
        const files = fs.readdirSync(this.TEST_DIR);
        let fileName = '';
        let counter_0 = 0;
        let counter_1 = 0;
        let buff_0 = 1;
        let buff_1 = 1;
        files.forEach((element) => {
            let n = element.split('.')[0].split('_')[0];

            if (element.split('.')[0].split('_')[1] == '1') {
                if (Number(n) != buff_1) {
                    fileName = buff_1 + '_1.jpg';
                    fs.writeFile(
                        `${this.TEST_DIR}/${fileName}`,
                        file.buffer,
                        'binary',
                        function (err) {
                            if (err) {
                                throw err;
                            }
                        }
                    );
                    return fileName;
                }
                counter_1 += 1;
                buff_1 += 1;
            } else {
                if (Number(n) != buff_0) {
                    fileName = buff_0 + '_0.jpg';
                    fs.writeFile(
                        `${this.TEST_DIR}/${fileName}`,
                        file.buffer,
                        'binary',
                        function (err) {
                            if (err) {
                                throw err;
                            }
                        }
                    );
                    return fileName;
                }
                counter_0 += 1;
                buff_0 += 1;
            }
        });
        if (category.category == '1') {
            fileName = counter_1 + 1 + '_1.jpg';
        } else {
            fileName = counter_0 + 1 + '_0.jpg';
        }

        fs.writeFile(
            `${this.TEST_DIR}/${fileName}`,
            file.buffer,
            'binary',
            function (err) {
                if (err) {
                    throw err;
                }
            }
        );
        return fileName;
    }

    getAllTrainData() {
        var files = fs.readdirSync(this.TRAIN_DIR);
        return files;
    }
    getAllTestData() {
        var files = fs.readdirSync(this.TEST_DIR);
        return files;
    }

    deleteImg(delImg: DeleteImage) {
        var dir = '';
        if (delImg.train) {
            dir = this.TRAIN_DIR;
        } else {
            dir = this.TEST_DIR;
        }
        var filePath = path.join(dir, delImg.name);
        fs.unlinkSync(filePath);
    }
}
