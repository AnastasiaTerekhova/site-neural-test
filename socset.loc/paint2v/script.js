// SETTING ALL VARIABLES

var isMouseDown = false;
var canvas = document.createElement('canvas');
var body = document.getElementsByTagName('body')[0];
var ctx = canvas.getContext('2d');
var linesArray = [];
currentSize = 5;
var currentColor = 'rgb(200,20,100)';
var currentBg = 'white';

const uploadFile = document.getElementById('upload-file');
// INITIAL LAUNCH
window.onload = function () {
    document.body.classList.add('loaded_hiding');
    window.setTimeout(function () {
        document.body.classList.add('loaded');
        document.body.classList.remove('loaded_hiding');
    }, 100);
};

createCanvas();

//////////

/////////
// BUTTON EVENT HANDLERS

document.getElementById('canvasUpdate').addEventListener('click', function () {
    createCanvas();
    redraw();
});
document.getElementById('colorpicker').addEventListener('change', function () {
    currentColor = this.value;
});
document
    .getElementById('bgcolorpicker')
    .addEventListener('change', function () {
        ctx.fillStyle = this.value;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        redraw();
        currentBg = ctx.fillStyle;
    });
document.getElementById('controlSize').addEventListener('change', function () {
    currentSize = this.value;
    document.getElementById('showSize').innerHTML = this.value;
});
document.getElementById('saveToImage').addEventListener(
    'click',
    function () {
        downloadCanvas(this, 'canvas', 'masterpiece.png');
    },
    false
);
document.getElementById('eraser').addEventListener('click', eraser);
document.getElementById('clear').addEventListener('click', createCanvas);
document.getElementById('save').addEventListener('click', save);
document.getElementById('load').addEventListener('click', load);
document.getElementById('clearCache').addEventListener('click', function () {
    localStorage.removeItem('savedCanvas');
    linesArray = [];
    console.log('Cache cleared!');
});
function dataURItoBlob(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else byteString = unescape(dataURI.split(',')[1]);
    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }
    return new Blob([ia], { type: mimeString });
}
document.getElementById('predict').addEventListener('click', function () {
    var formData = new FormData();
    var _img = document.getElementById('canvas').toDataURL('image/jpeg');
    var file = dataURItoBlob(_img);
    formData.append('file', file);
    axios
        .post('http://localhost:5000/network/predict', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        })
        .then((response) => {
            var res1 = document.getElementById('res1');
            var res2 = document.getElementById('res2');
            console.log(response.data);
            res1.innerText = 'Дом с вероятностью ' + response.data.House;
            res2.innerText =
                'Что-то другое с вероятностью ' + response.data.Other;
            console.log(response.data);
        });
});

document.getElementById('trainNetwork').addEventListener('click', function () {
    var ep = document.getElementById('epochs');
    var bat = document.getElementById('batchSize');
    if (!ep.value) {
        ep.value = 100;
    }
    if (!bat.value) {
        bat.value = 32;
    }
    document.body.classList.remove('loaded');
    document.body.classList.remove('loaded_hiding');

    axios
        .post('http://localhost:5000/network/trainNetwork', {
            epochs: Number(ep.value),
            batchSize: Number(bat.value),
        })
        .then((response) => {
            document.body.classList.add('loaded');
            document.body.classList.remove('loaded_hiding');

            alert('Обучение завершено успешно!!!');
        });
});

document
    .getElementById('saveTrainImage')
    .addEventListener('click', function () {
        var formData = new FormData();
        var _img = document.getElementById('canvas').toDataURL('image/jpeg');
        var file = dataURItoBlob(_img);
        var category = '';
        if (confirm('Вы пытались нарисовать дом?')) {
            category = '1';
        } else {
            category = '0';
        }

        formData.append('file', file);
        formData.append('category', category);
        axios
            .post('http://localhost:5000/network/saveTrainImage', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
            .then((response) => {
                alert(
                    'Изображение сохранено на сервере под именем:' +
                        response.data
                );
            });
        createCanvas();
    });

document.getElementById('saveTestImage').addEventListener('click', function () {
    var formData = new FormData();
    var _img = document.getElementById('canvas').toDataURL('image/jpeg');
    var file = dataURItoBlob(_img);
    var category = '';
    if (confirm('Вы пытались нарисовать дом?')) {
        category = '1';
    } else {
        category = '0';
    }

    formData.append('file', file);
    formData.append('category', category);
    axios
        .post('http://localhost:5000/network/saveTestImage', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        })
        .then((response) => {
            alert(
                'Изображение сохранено на сервере под именем:' + response.data
            );
        });
    createCanvas();
});

document
    .getElementById('defaultSettingsNetwork')
    .addEventListener('click', function () {
        axios.get('http://localhost:5000/network/getDefaultNetwork', {});
    });

// REDRAW

function redraw() {
    for (var i = 1; i < linesArray.length; i++) {
        ctx.beginPath();
        ctx.moveTo(linesArray[i - 1].x, linesArray[i - 1].y);
        ctx.lineWidth = linesArray[i].size;
        ctx.lineCap = 'round';
        ctx.strokeStyle = linesArray[i].color;
        ctx.lineTo(linesArray[i].x, linesArray[i].y);
        ctx.stroke();
    }
}

// DRAWING EVENT HANDLERS

canvas.addEventListener('mousedown', function () {
    mousedown(canvas, event);
});
canvas.addEventListener('mousemove', function () {
    mousemove(canvas, event);
});
canvas.addEventListener('mouseup', mouseup);

// CREATE CANVAS

function createCanvas() {
    canvas.id = 'canvas';
    canvas.width = parseInt(document.getElementById('sizeX').value);
    canvas.height = parseInt(document.getElementById('sizeY').value);
    canvas.style.zIndex = 8;
    canvas.style.position = 'absolute';
    canvas.style.border = '1px solid';
    ctx.fillStyle = currentBg;
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    body.appendChild(canvas);
}

// DOWNLOAD CANVAS

function downloadCanvas(link, canvas, filename) {
    link.href = document.getElementById(canvas).toDataURL();
    link.download = filename;
}

// SAVE FUNCTION

function save() {
    localStorage.removeItem('savedCanvas');
    localStorage.setItem('savedCanvas', JSON.stringify(linesArray));
    console.log('Saved canvas!');
}

// LOAD FUNCTION

function load() {
    if (localStorage.getItem('savedCanvas') != null) {
        linesArray = JSON.parse(localStorage.savedCanvas);
        var lines = JSON.parse(localStorage.getItem('savedCanvas'));
        for (var i = 1; i < lines.length; i++) {
            ctx.beginPath();
            ctx.moveTo(linesArray[i - 1].x, linesArray[i - 1].y);
            ctx.lineWidth = linesArray[i].size;
            ctx.lineCap = 'round';
            ctx.strokeStyle = linesArray[i].color;
            ctx.lineTo(linesArray[i].x, linesArray[i].y);
            ctx.stroke();
        }
        console.log('Canvas loaded.');
    } else {
        console.log('No canvas in memory!');
    }
}

// ERASER HANDLING

function eraser() {
    currentSize = 50;
    currentColor = ctx.fillStyle;
}

// GET MOUSE POSITION

function getMousePos(canvas, evt) {
    var rect = canvas.getBoundingClientRect();
    return {
        x: evt.clientX - rect.left,
        y: evt.clientY - rect.top,
    };
}

// ON MOUSE DOWN

function mousedown(canvas, evt) {
    var mousePos = getMousePos(canvas, evt);
    isMouseDown = true;
    var currentPosition = getMousePos(canvas, evt);
    ctx.moveTo(currentPosition.x, currentPosition.y);
    ctx.beginPath();
    ctx.lineWidth = currentSize;
    ctx.lineCap = 'round';
    ctx.strokeStyle = currentColor;
}

// ON MOUSE MOVE

function mousemove(canvas, evt) {
    if (isMouseDown) {
        var currentPosition = getMousePos(canvas, evt);
        ctx.lineTo(currentPosition.x, currentPosition.y);
        ctx.stroke();
        store(currentPosition.x, currentPosition.y, currentSize, currentColor);
    }
}

// STORE DATA

function store(x, y, s, c) {
    var line = {
        x: x,
        y: y,
        size: s,
        color: c,
    };
    linesArray.push(line);
}

// ON MOUSE UP

function mouseup() {
    isMouseDown = false;
    store();
}
uploadFile.addEventListener('change', () => {
    // Get File
    const file = document.getElementById('upload-file').files[0];
    // Init FileReader API
    const reader = new FileReader();

    // Check for file
    if (file) {
        // Set file name
        fileName = file.name;
        // Read data as URL
        reader.readAsDataURL(file);
    }
    reader.addEventListener(
        'load',
        () => {
            // Create image
            img = new Image();
            // Set image src
            img.src = reader.result;
            // On image load add to canvas
            img.onload = function () {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0, img.width, img.height);
                canvas.removeAttribute('data-caman-id');
            };
        },
        false
    );
});
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('filter-btn')) {
        if (e.target.classList.contains('brightness-add')) {
            Caman('#canvas', img, function () {
                this.brightness(5).render();
            });
        } else if (e.target.classList.contains('brightness-remove')) {
            Caman('#canvas', img, function () {
                this.brightness(-5).render();
            });
        } else if (e.target.classList.contains('contrast-add')) {
            Caman('#canvas', img, function () {
                this.contrast(5).render();
            });
        } else if (e.target.classList.contains('contrast-remove')) {
            Caman('#canvas', img, function () {
                this.contrast(-5).render();
            });
        } else if (e.target.classList.contains('saturation-add')) {
            Caman('#canvas', img, function () {
                this.saturation(5).render();
            });
        } else if (e.target.classList.contains('saturation-remove')) {
            Caman('#canvas', img, function () {
                this.saturation(-5).render();
            });
        } else if (e.target.classList.contains('vibrance-add')) {
            Caman('#canvas', img, function () {
                this.vibrance(5).render();
            });
        } else if (e.target.classList.contains('vibrance-remove')) {
            Caman('#canvas', img, function () {
                this.vibrance(-5).render();
            });
        } else if (e.target.classList.contains('vintage-add')) {
            Caman('#canvas', img, function () {
                this.vintage().render();
            });
        } else if (e.target.classList.contains('lomo-add')) {
            Caman('#canvas', img, function () {
                this.lomo().render();
            });
        } else if (e.target.classList.contains('clarity-add')) {
            Caman('#canvas', img, function () {
                this.clarity().render();
            });
        } else if (e.target.classList.contains('sincity-add')) {
            Caman('#canvas', img, function () {
                this.sinCity().render();
            });
        } else if (e.target.classList.contains('crossprocess-add')) {
            Caman('#canvas', img, function () {
                this.crossProcess().render();
            });
        } else if (e.target.classList.contains('pinhole-add')) {
            Caman('#canvas', img, function () {
                this.pinhole().render();
            });
        } else if (e.target.classList.contains('nostalgia-add')) {
            Caman('#canvas', img, function () {
                this.nostalgia().render();
            });
        } else if (e.target.classList.contains('hermajesty-add')) {
            Caman('#canvas', img, function () {
                this.herMajesty().render();
            });
        }
    }
});

var radio = ['house', 'houseSize', 'nice', 'bad'];

function resetTest() {
    createCanvas();
    uncheckAllRadio(radio);
}

function testingStatus() {
    document.getElementById('startTestingBtn').style.display = 'none';
    document.getElementById('stopDrawingBtn').style.display = 'block';
    document.getElementById('stopTestingBtn').style.display = 'block';
    document.getElementById('resultTestingBtn').style.display = 'none';
    resetTest();
}

function resetTesting() {
    document.getElementById('startTestingBtn').style.display = 'block';
    document.getElementById('stopDrawingBtn').style.display = 'none';
    document.getElementById('stopTestingBtn').style.display = 'none';
    document.getElementById('resultTestingBtn').style.display = 'none';
    resetTest();
}

function endTesting() {
    document.getElementById('startTestingBtn').style.display = 'none';
    document.getElementById('stopDrawingBtn').style.display = 'none';
    document.getElementById('stopTestingBtn').style.display = 'block';
    document.getElementById('resultTestingBtn').style.display = 'block';
}

function sendData() {
    var check = checkRadioButtons(radio);
    if (check) {
        document.getElementById('startTestingBtn').style.display = 'none';
        document.getElementById('stopDrawingBtn').style.display = 'none';
        document.getElementById('stopTestingBtn').style.display = 'block';
        document.getElementById('resultTestingBtn').style.display = 'block';

        var formData = new FormData();
        var _img = document.getElementById('canvas').toDataURL('image/jpeg');
        var file = dataURItoBlob(_img);
        formData.append('file', file);
        axios
            .post('http://localhost:5000/network/predict', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
            .then((response) => {
                var res1 = document.getElementById('result1');
                var res2 = document.getElementById('result2');
                res1.innerText = 'Дом с вероятностью ' + response.data.House;
                res2.innerText =
                    'Что-то другое с вероятностью ' + response.data.Other;
            });
    } else {
        alert('Вы ответили не на все вопросы');
    }
}

function saveTesting() {
    document.getElementById('startTestingBtn').style.display = 'block';
    document.getElementById('stopDrawingBtn').style.display = 'none';
    document.getElementById('stopTestingBtn').style.display = 'none';
    document.getElementById('resultTestingBtn').style.display = 'none';
    resetTest();
}

function checkRadioButtons(category) {
    var count = 0;
    for (var j = 0; j < category.length; j++) {
        var inp = document.getElementsByName(category[j]);
        for (var i = 0; i < inp.length; i++) {
            if (inp[i].type == 'radio' && inp[i].checked) {
                count += 1;
                break;
            }
        }
    }
    if (count == category.length) {
        return true;
    } else {
        return false;
    }
}

function uncheckAllRadio(category) {
    for (var j = 0; j < category.length; j++) {
        var inp = document.getElementsByName(category[j]);
        for (var i = 0; i < inp.length; i++) {
            if (inp[i].type == 'radio' && inp[i].checked) {
                inp[i].checked = false;
                break;
            }
        }
    }
}
