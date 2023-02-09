import { Injectable } from '@nestjs/common';
import * as tf from '@tensorflow/tfjs-node';
import * as fs from 'fs';
import * as path from 'path';
import { Network } from './network.model';

@Injectable()
export class NetworkService {
    trainData = [];
    testData = [];
    TRAIN_DIR = 'src/dataset/trainData';
    TEST_DIR = 'src/dataset/testData';
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
}
