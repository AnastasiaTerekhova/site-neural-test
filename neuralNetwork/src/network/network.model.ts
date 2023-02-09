import * as tf from '@tensorflow/tfjs-node';
export class Network {
    TARGET_CLASSES = {
        0: 'Other',
        1: 'House',
    };
    kernel_size = [3, 3];
    pool_size = [2, 2];
    first_filters = 32;
    second_filters = 64;
    third_filters = 128;

    dropout_conv = 0.3;
    dropout_dense = 0.3;

    model: tf.Sequential;

    constructor() {
        this.model = tf.sequential();
        this.modelSetting();
    }
    modelSetting() {
        this.model.add(
            tf.layers.conv2d({
                inputShape: [96, 96, 3],
                filters: this.first_filters,
                kernelSize: this.kernel_size,
                activation: 'relu',
            })
        );
        this.model.add(
            tf.layers.conv2d({
                filters: this.first_filters,
                kernelSize: this.kernel_size,
                activation: 'relu',
            })
        );
        this.model.add(tf.layers.maxPooling2d({ poolSize: [2, 2] }));
        this.model.add(tf.layers.dropout({ rate: this.dropout_conv }));
        ////

        this.model.add(
            tf.layers.conv2d({
                filters: this.second_filters,
                kernelSize: this.kernel_size,
                activation: 'relu',
            })
        );
        this.model.add(
            tf.layers.conv2d({
                filters: this.second_filters,
                kernelSize: this.kernel_size,
                activation: 'relu',
            })
        );
        this.model.add(
            tf.layers.conv2d({
                filters: this.second_filters,
                kernelSize: this.kernel_size,
                activation: 'relu',
            })
        );
        this.model.add(tf.layers.maxPooling2d({ poolSize: [2, 2] }));
        this.model.add(tf.layers.dropout({ rate: this.dropout_conv }));

        ///
        this.model.add(
            tf.layers.conv2d({
                filters: this.third_filters,
                kernelSize: this.kernel_size,
                activation: 'relu',
            })
        );
        this.model.add(
            tf.layers.conv2d({
                filters: this.third_filters,
                kernelSize: this.kernel_size,
                activation: 'relu',
            })
        );
        this.model.add(
            tf.layers.conv2d({
                filters: this.third_filters,
                kernelSize: this.kernel_size,
                activation: 'relu',
            })
        );
        this.model.add(tf.layers.maxPooling2d({ poolSize: [2, 2] }));
        this.model.add(tf.layers.dropout({ rate: this.dropout_conv }));
        ////
        this.model.add(tf.layers.flatten());
        this.model.add(tf.layers.dense({ units: 256, activation: 'relu' }));
        this.model.add(tf.layers.dropout({ rate: this.dropout_dense }));
        this.model.add(tf.layers.dense({ units: 2, activation: 'softmax' }));

        const optimizer = tf.train.adam(0.0001);
        this.model.compile({
            optimizer: optimizer,
            loss: 'binaryCrossentropy',
            metrics: ['accuracy'],
        });
    }
}
