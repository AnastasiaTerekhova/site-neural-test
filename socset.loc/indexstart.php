<?php include("include/config.php");

if (isset($_GET['exit'])) {
    unset($_SESSION['user']);
}


if (!isset($_SESSION['user'])) {
    header('Location: /auth.php');
    die;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PsyTest</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>

<body>

    <?php if (isset($_GET['exit'])) {
        unset($_SESSION['user']);
    }
    $check =  mysqli_query($connections, "SELECT * FROM `pushes` WHERE (`userid`={$_SESSION['user']['id']})");
    if (mysqli_num_rows($check) != 0) {
    ?>
        <style>
            #pushb {
                box-shadow: 0px 0px 13px red;
                background: unset;
            }

            .left-menu img {
                fill: darkgreen;

            }
        </style>
    <?php
    }

    ?>
    <div class="m-container">
        <div class="left-menu" style="width: 50px;">
            <div style="margin-top:5vw" title="Главная"><a href="?home="><img style="width:30px;height:30px;" src="webicons\home.png" alt=""></a> </div>
            <div title="Тестирование"><a href="?painter="><img style="width:55px;height:55px;" src="webicons\paint1.png" alt=""></a></div>
            <div title="Наши специалисты"><a href="?psycho="><img style="width:30px;height:30px;" src="webicons\friends.png" alt=""></a> </div>
            <!-- <div title="Уведомления"><a href="?pushs="><img style="width:35px;height:35px;" id="pushb" src="webicons\pushs.png" alt=""></a></div>
            <div title="Друзья"><a href="?friends="><img style="width:35px;height:35px;" src="webicons\friends.png" alt=""></a></div> -->
            <!-- <div><a href=""><img src="icons\group.svg" alt=""></a>  </div> -->
            <div title="Выйти"><a href="/?exit="><img style="width:30px;height:30px;" src="webicons\turn-off.png" alt=""></a> </div>
        </div>
        <div class="right-main">
            <?php
            if (!isset($_SESSION['user'])) {
                echo ("<script>document.location.href  = '/auth.php'</script>");
                die;
            }
            $q = mysqli_query($connections, "SELECT * FROM `users` WHERE `id`=" . intval($_SESSION['user']['id']));
            if (mysqli_num_rows($q) == 0) {
                echo ("<script>document.location.href  = '/auth.php'</script>");
                die;
            }
            $_SESSION['user'] = mysqli_fetch_assoc($q);

            $sessionInfo = json_decode($_SESSION['user']['info_json']);
            if (isset($_GET['home'])) {
                include("home.php");
            } else
                if (isset($_GET['pushs'])) {
                include("pushs.php");
            } else
                if (isset($_GET['psycho'])) {
                include("psychologi.php");
            } else
                if (isset($_GET['search'])) {
                include("search.php");
            } else
                if (isset($_GET['painter'])) {
                include("painter.php");
            } else if (isset($_GET['news'])) {
                include("news.php");
            } else 
            
            {
            ?>
                <p style="color:gray; text-align:center; font-size:1.2vw;margin-top:20vh;">Вы авторизовались!<br>
                    Для того чтобы выбрать психолога, перейдите во вкладку слева <a href="?friends">"Наши специалисты"</a> и нажмите на кнопку <a href="?search=">"Выбрать"</a> у нижного специалиста<br>
                    Для прохождения тестирования перейдите во вкладку <a href="?home=">"Тестирование"</a> и следуйте дальнейшим указаниям программы.<br>
                </p>
            <?php
            }

            ?>
        </div>
    </div>
</body>

</html>