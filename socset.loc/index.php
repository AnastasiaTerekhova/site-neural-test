<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- <link rel="stylesheet" href="style-main.css"/> -->
  <!-- <link rel="stylesheet" href="style-main.css"/> -->
  <link href="style-main2.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Caveat&family=Comfortaa:wght@700&family=Reggae+One&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <title>PsyTest</title>
</head>

<body>
  <nav class="navbar">
    <ul class="navbar-list">
      <li class="navbar-item">
        <a class="navbar-link" href="mainhome.php">Главная</a>
      </li>
      <li class="navbar-item">
        <a>|</a>
      </li>
      <li class="navbar-item">
        <a class="navbar-link" href="#">О сервисе</a>
      </li>
      <li class="navbar-item">
        <a>|</a>
      </li>
      <li class="navbar-item">
        <a class="navbar-link" href="#">Связаться с нами</a>
      </li>
      </li>
    </ul>
    <div class="navbar-btn-items">
      <button class="btn-navbar-auth">
        <li class="navbar-item">
          <a class="navbar-link" href="http://socset.loc/auth.php">Вход / Регистрация</a>
        </li>
      </button>
    </div>
  </nav>

  <slider>
    <div class="slider1">
      <h1 class="slider-text-max">Наш сервис поможет вам</h1>
      <h3 class="slider-text-min">Пройдите тест и подберите специалиста по вашему запросу</h3>
      <button class="btn-slider"> <a href="#">Пройти тест</a></button>
      <img src="/img/slider26.jpg">
      
    </div>
  </slider>
  <div class="container1">
    <div class="container-line"></div>
  </div>
  <div class="container1">
    <div class="galery-text">
      <h2>О сервисе</h2>
      <p>На данном сайте представлена проективная методика исследования личности на основе теста "Дом Дерево Человек"(ДДЧ). 
        Тест ДДЧ был предложен Дж. Буком в 1948 г. Тест предназначен для обследования как взрослых, так и детей, возможно групповое обследование.</p>
      <p>Всё что требуется от Вас для прохождения теста - это нарисовать дом и ответить на несколько вопросов. Система оценит рисунок и выдаст результат. 
        По окончанию тестирования, Вам будет предложено связаться с психологом.
    </div>
    <!-- <div class="flex-galery">
  
      <img class="item-galery" src="../img/background1.jpg" alt="альтернативный текст">
      <img class="item-galery" src="../img/background1.jpg" alt="альтернативный текст">
      <img class="item-galery" src="../img/21.jpg" alt="альтернативный текст">
      <img class="item-galery" src="../img/background1.jpg" alt="альтернативный текст">
      <img class="item-galery" src="../img/background.jpg" alt="альтернативный текст">
      <img class="item-galery" src="../img/background1.jpg" alt="альтернативный текст">
    </div> -->
    <!-- <button class="btn-galery"> <a href="">Увидеть больше</a> </button> -->
  </div>
  <!-- <div class="container1">
    <div class="container-line"></div>
  </div> -->
  <div class="container">
    <div class="info-text">
      <h2>Чем поможет онлайн-консультация с психологом?</h2>
      <p>Хороший психолог способен определить ситуации, которые могут нанести вред здоровью и работе. К счастью, многие люди вовремя 
        обращаются к специалистам. Психологи помогают им справится с подобными ситуациями, чтобы не проявлялись негативные эмоции, 
        работа и семья были сохранены, а разовые сложности забыты.
      </p>
      <div class="info-texti"><h2>Когда стоит обращаться к психологу?</h2></div>
    </div>
    <div class="info-card">
      <div class="info-card-item">
        <div class="info-card-text">
          <p>Тревожное или паническое состояние</p>
        </div>
        <div class="info-card-icon">
          <img src="../img/stress-icon.png" alt="альтернативный текст">
        </div>
      </div>
      <div class="info-card-item">
        <div class="info-card-text">
          <p>Прокрастинация и отсутствие интереса в жизни</p>
        </div>
        <div class="info-card-icon">
          <img src="../img/faq-11.png" alt="альтернативный текст">
        </div>
      </div>
      <div class="info-card-item">
        <div class="info-card-text">
          <p>Напряженные отношения с близкими или партнёром</p>
        </div>
        <div class="info-card-icon">
          <img src="../img/problempeople.png" alt="альтернативный текст">
        </div>
      </div>
    </div>
  </div>
  
  <?include ("feedback.php");
?>
  <div class="container123">
    <div class="contact">
      <div class="contact-text">
        <h2>Свяжитесь с нами</h2>
        <p>Оставьте свои отзывы и предложения по улучшению продукта</p>
      </div>

      <form method="post" action="feedback.php">
        <label>Имя</label>
        <input name="name" placeholder="Введите ваше имя">

        <label>Email</label>
        <input name="email" type="email" placeholder="Введите адрес вашей почты">

        <label>Сообщение</label>
        <textarea name="message" placeholder="Введите сообщение"></textarea>
        <label>*Сколько будет 3+2? (Anti-spam)</label>
        <input name="human" placeholder="Введите ответ">

        <input id="submit" name="submit" type="submit" value="Отправить">
        
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-light text-center text-lg-start ">
    <!-- Grid container -->
    <div class="container p-4">
      <!--Grid row-->
      <div class="row">
        <!--Grid column-->
        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
          <h5 class="text-uppercase">Psytest</h5>
          <p>
            Недооценивай важность ментального здоровья!
          </p>
          <p> Чтобы оценить уровень психического здоровья, пройдите простой психологический тест. Он даст оценку вашему здоровью. Чтобы правильно понять его результат или необходима помощь, здесь есть возможность обратится к специалисту и провести онлайн-консультацию.</p>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Ресурсы</h5>

          <ul class="list-unstyled mb-0">
            <li>
              <a href="#!" class="text-dark">Psytest</a>
            </li>
            <li>
              <a href="#!" class="text-dark">Поддержка</a>
            </li>
            <li>
              <a href="#!" class="text-dark">Цитаты</a>
            </li>

          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-0">Компания</h5>

          <ul class="list-unstyled">
            <li>
              <a href="#!" class="text-dark">О нас</a>
            </li>
            <li>
              <a href="#!" class="text-dark">Политика конфиденциальности</a>
            </li>
            <li>
              <a href="#!" class="text-dark">Пользовательское соглашение</a>
            </li>
            <li>
              <a href="#!" class="text-dark">Свяжитесь с нами</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: #cfe1eb;">
      © 2022 Terekhova:
      <a class="text-dark" href="#">psytest</a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>