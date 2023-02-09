<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link
            href="https://fonts.googleapis.com/css?family=Roboto"
            rel="stylesheet"
        />
        <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
            integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
            crossorigin="anonymous"
        />
        <!-- <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous"
        /> -->
        <link rel="stylesheet" href="style.css" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css"
        />

        <link rel="stylesheet" href="bootstrap.min.css" />
        <link rel="stylesheet" href="paint2v/stylep.css" />
        <link rel="stylesheet" href="paint2v/modal.css" />

        <title>PsyTest</title>
    </head>

    <body>
        <div id="sidebar">
        <div class="extra">
                <h3>Проективный рисуночный тест «Дом»</h3>   
            </div>
            <div id="myMainContainer">
                <a
                    id="startTestingBtn"
                    href="#"
                    data-tm-modal="testModal"
                    class="tm-trigger btn default "
                    >Начать тестирование</a
                >
                <a
                    style="display: none"
                    id="stopDrawingBtn"
                    href="#"
                    data-tm-modal="questionsModal"
                    class="tm-trigger btn default"
                    >Завершить рисование</a
                >
                <a
                    style="display: none"
                    id="resultTestingBtn"
                    href="#"
                    class="tm-trigger btn default"
                    data-tm-modal="resultModal"
                    >Узнать результат тестирования</a
                >
                <a
                    style="display: none"
                    href="#"
                    id="stopTestingBtn"
                    class="tm-trigger btn default"
                    onclick="resetTesting()"
                    >Сбросить результат тестирования</a
                >
            </div>
            <!-- <button onclick="Addtext()">Add Text</button> -->
            <div class="colorButtons">
                <h3>Цвет кисти</h3>
                <input
                    type="color"
                    id="colorpicker"
                    value="#c81464"
                    class="colorpicker"
                />
            </div>
            <div class="colorButtons">
                <h3>Цвет холста</h3>
                <input
                    type="color"
                    value="#ffffff"
                    id="bgcolorpicker"
                    class="colorpicker"
                />
            </div>

            <div class="toolsButtons">
                <h3>Инструменты</h3>
                <button id="eraser" class="btn btn-default">
                    <span
                        class="glyphicon glyphicon-erase"
                        aria-hidden="true"
                    ></span>
                </button>
                <button id="clear" class="btn btn-danger">
                    <span
                        class="glyphicon glyphicon-repeat"
                        aria-hidden="true"
                    ></span>
                </button>
            </div>

            <div class="buttonSize">
                <h3>Размер пера (<span id="showSize">5</span>)</h3>
                <input
                    type="range"
                    min="1"
                    max="50"
                    value="5"
                    step="1"
                    id="controlSize"
                />
            </div>

            <div class="canvasSize">
                <h3>Размер холста</h3>
                <div class="input-group">
                    <span class="input-group-addon">X</span>
                    <input
                        type="number"
                        id="sizeX"
                        class="form-control"
                        placeholder="sizeX"
                        value="800"
                        class="size"
                    />
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Y</span>
                    <input
                        type="number"
                        id="sizeY"
                        class="form-control"
                        placeholder="sizeY"
                        value="600"
                        class="size"
                    />
                </div>
                <input
                    type="button"
                    class="updateSize btn btn-success"
                    value="Обновить"
                    id="canvasUpdate"
                />
            </div>
            <div class="custom-file mb-2">
                <input
                    type="file"
                    class="custom-file-input"
                    id="upload-file"
                    value="file"
                />

                <!-- <input type="button" class="updateSize btn btn-success" value="Обновить" id="canvasUpdate"> -->
                <label for="upload-file" class="custom-file-label"
                    >Загрузить картинку</label
                >
            </div>
            <div class="Storage">
                <h3>Сохранить изображение</h3>
                <input
                    type="button"
                    value="Сохранить"
                    class="btn btn-warning"
                    id="save"
                />
                <input
                    type="button"
                    value="Загрузить"
                    class="btn btn-warning"
                    id="load"
                />
                <input
                    type="button"
                    value="Стереть"
                    class="btn btn-warning"
                    id="clearCache"
                />
            </div>
            <div class="extra">
                <h3>Сохранить изображение</h3>
                <a id="saveToImage" class="btn btn-warning">Сохранить</a>
            </div>
           
                <h3>Обучение сети</h3>
                <a id="predict" class="btn btn-warning">Предсказать</a>
            <h4 id="res1"></h4>
            <h4 id="res2"></h4>
                <a id="saveTrainImage" class="btn btn-warning"
                    >Сохранить картинку для обучения сети</a
                >
                <a id="saveTestImage" class="btn btn-warning"
                    >Сохранить картинку для тестирования сети</a
                >
                <a
                    id="getTrainData"
                    class="btn btn-warning"
                    href="trainImage.html"
                    >Получить обучающие данные</a
                >
                <a
                    id="getTestData"
                    class="btn btn-warning"
                    href="testImage.html"
                    >Получить тестовые данные</a
                >
                <div>
                    <h4>Введите количестов эпох обучения(100 по умолчанию)</h4>
                    <input value="100" id="epochs"/>
                </div>
                <div>
                    <h4>Введите размер пакета обучения(32 по умолчанию)</h4>
                    <input value="32" id="batchSize"/>
                </div>
                <a id="trainNetwork" class="btn btn-warning">Обучить сеть</a>
                <a id="defaultSettingsNetwork" class="btn btn-warning"
                    >Востановить сеть к базовым настройкам</a
                >
            </div>
        </div>
        <div class="preloader">
            <svg class="preloader__image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <path fill="currentColor"
                d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
              </path>
            </svg>
          </div>
        <!-- <div
            data-tm-title="tomloprodModal 0"
            data-tm-content="My background color is the default :-)"
            class="tm-modal tm-effect"
            id="testModal0"
        > -->
        <div class="tm-modal tm-effect" id="testModal">
            <div class="tm-wrapper">
                <div class="tm-title">
                    <span class="tm-XButton tm-closeButton"></span>
                    <h3 class="tm-title-text">Проективный рисуночный тест «Дом»</h3>
                </div>
                <div class="tm-content">
                    <p>
                        Для прохождения теста, вам будет необходимо представить
                        и изобразить дом
                    </p>
                    <div>
                        <button onclick="testingStatus(), closeModal()" class="btnmodal1" style="font-size : 15px;">
                            Начать
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tm-modal tm-effect" id="questionsModal">
            <div class="tm-wrapper">
                <div class="tm-title">
                    <span class="tm-XButton tm-closeButton"></span>
                    <h3 class="tm-title-text">Ответьте на вопросы</h3>
                </div>
                <div class="tm-content">
                    <form id="mainForm" onsubmit="return false;">
                        <p>Где находится этот дом?</p>
                        <div>
                            <input
                                type="radio"
                                id="houseChoice1"
                                name="house"
                                value="forest"
                            />
                            <label for="houseChoice1">В лесу</label>

                            <input
                                type="radio"
                                id="houseChoice2"
                                name="house"
                                value="city"
                            />
                            <label for="houseChoice2">В городе</label>

                            <input
                                type="radio"
                                id="houseChoice3"
                                name="house"
                                value="village"
                            />

                            <label for="houseChoice4">В деревне</label>
                            <input
                                type="radio"
                                id="houseChoice4"
                                name="house"
                                value="other"
                            />
                            <label for="houseChoice4">Другой вариант</label>
                        </div>

                        <p>Сколько комнат в доме?</p>
                        <div>
                            <input
                                type="radio"
                                id="houseSizeChoice1"
                                name="houseSize"
                                value="1"
                            />
                            <label for="houseSizeChoice1">Одна</label>

                            <input
                                type="radio"
                                id="houseSizeChoice2"
                                name="houseSize"
                                value="2-5"
                            />
                            <label for="houseSizeChoice2">От 2 до 5</label>

                            <input
                                type="radio"
                                id="houseSizeChoice3"
                                name="houseSize"
                                value=">5"
                            />

                            <label for="houseSizeChoice3">Больше 5</label>
                            <input
                                type="radio"
                                id="houseSizeChoice4"
                                name="houseSize"
                                value="other"
                            />
                            <label for="houseSizeChoice4">Не знаю</label>
                        </div>

                        <p>Какое место в доме вы считаете уютным?</p>
                        <div>
                            <input
                                type="radio"
                                id="niceChoice1"
                                name="nice"
                                value="1"
                            />
                            <label for="niceChoice1">Гостиная</label>

                            <input
                                type="radio"
                                id="niceChoice2"
                                name="nice"
                                value="2"
                            />
                            <label for="niceChoice2">Личная комната</label>

                            <input
                                type="radio"
                                id="niceChoice3"
                                name="nice"
                                value="3"
                            />

                            <label for="niceChoice3">Терраса</label>
                            <input
                                type="radio"
                                id="niceChoice4"
                                name="nice"
                                value="4"
                            />
                            <label for="niceChoice4">Кухня</label>
                        </div>

                        <p>Какое место в доме вам кажется самым неуютным?</p>
                        <div>
                            <input
                                type="radio"
                                id="badChoice1"
                                name="bad"
                                value="1"
                            />
                            <label for="badChoice1">Кухня</label>

                            <input
                                type="radio"
                                id="badChoice2"
                                name="bad"
                                value="2"
                            />
                            <label for="badChoice2">Подвал</label>

                            <input
                                type="radio"
                                id="badChoice3"
                                name="bad"
                                value="3"
                            />

                            <label for="badChoice3">Чердак</label>
                            <input
                                type="radio"
                                id="badChoice4"
                                name="bad"
                                value="4"
                            />
                            <label for="badChoice4">Коридор</label>

                            <input
                                type="radio"
                                id="badChoice5"
                                name="bad"
                                value="5"
                            />
                            <label for="badChoice5">Кладовка</label>

                            <input
                                type="radio"
                                id="badChoice6"
                                name="bad"
                                value="6"
                            />
                            <label for="badChoice6">Спальня</label>
                        </div>

                        <div>
                            <button onclick="sendData(), closeModal()">
                                Отправить тестирование
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tm-modal tm-effect" id="resultModal">
            <div class="tm-wrapper">
                <div class="tm-title">
                    <span class="tm-XButton tm-closeButton"></span>
                    <h3 class="tm-title-text">Результат теста</h3>
                </div>
                <div class="tm-content">
                    <p>
                        В ходе тестирования были получены следующие результаты:
                    </p>
                    <div id="result1"></div>
                    <div id="result2"></div>
                    <p>
                    
                    </p>
                    <p>Количество комнат говорит об уровне самооценки и притязаний. Одна комната – заниженная самооценка. В среднем если комнат до 5 – это норма. Если комнат больше – у человека возможны проблемы с реальностью: хочется объять необъятное, побывать во всех местах, человек не сопоставляет свои мечты с реальностью.</p>
                    <p>Где в доме находится самое уютное место? Терраса – это граница дома и внешнего мира. Означает, что дома не комфортно, человек пытается расширить зону своего влияния, стремится раздвинуть границы. </p>
                    <p>Где в доме находится неуютное место? Когда спальня неуютная – это часто означает разборки в семье или личной жизни.</p>
                    <p>
                        Рекомендуем обратиться к нашим психологам, для лучшего
                        трактования теста
                    </p>
                    <div>
                        <button onclick="saveTesting(),closeModal()">
                            Сохранить результаты и завершить
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"
        ></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.4.0/fabric.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/camanjs/4.1.2/caman.full.min.js"
            integrity="sha512-JjFeUD2H//RHt+DjVf1BTuy1X5ZPtMl0svQ3RopX641DWoSilJ89LsFGq4Sw/6BSBfULqUW/CfnVopV5CfvRXA=="
            crossorigin="anonymous"
        ></script>

        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="paint2v/script.js"></script>
        <script src="paint2v/modal.js"></script>

        <!-- <script src="scripttext.js"></script> -->
    </body>
</html>
