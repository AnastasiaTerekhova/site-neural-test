<?php include("include/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

    <script src="logreg.js"></script>
</head>

<body style="overflow:hidden;">
    <?php
    if (isset($_POST['go_reg'])) {

        $g = mysqli_query($connections, "SELECT * FROM `users` WHERE `login`='{$_POST['login']}'");

        if (mysqli_num_rows($g) == 0) {
            $info = array(
                'location' => trim($_POST['mest_jit']),
                'born' => trim($_POST['rodil']),
                'job' => trim($_POST['rab']),
                'study' => trim($_POST['uch']),
                'type' => trim($_POST['polog']),
                'hobby' => trim($_POST['evlech']),
                'email' => trim($_POST['mail']),
                'background' => "img/background.jpg",
                'avatar' => "img/avatar.jpg",
                'friends' => array()

            );
            $info_json = (json_encode($info, JSON_UNESCAPED_UNICODE));
            $posts = json_encode(array(), JSON_UNESCAPED_UNICODE);
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            mysqli_query($connections, "INSERT INTO `users` (`name`, `login`, `password`, `info_json`, `posts_json`) VALUES ('{$_POST['login']}', '{$_POST['login']}', '{$pass}', '{$info_json}', '{$posts}')");
            echo ("<script>document.location.href  = '/indexstart.php'</script>");
        } else {
            echo ("Эти данные уже используются.");
        }
    }
    if (isset($_POST['go_log'])) {
        $loginEx = mysqli_query($connections, "SELECT * FROM `users` WHERE `login`='{$_POST['login']}'");

        if (mysqli_num_rows($loginEx) == 1) {
            $loginExFetch = mysqli_fetch_assoc($loginEx);
            if (password_verify($_POST['password'], substr($loginExFetch['password'], 0, 60))) {

                $_SESSION['user'] = $loginExFetch;
                echo ("<script>document.location.href  = '/indexstart.php'</script>");
            } else {
                echo ("Неверные данные");
            }
        } else {
            echo ("Неверные данные");
        }
    }
    ?>
    <style>
        input {
            font-size: 14px;
            margin-top: 20px;
            padding: 10px;
            width: 350px;
            /* border-style: 1px solid #000; */
            background: unset;
            font-family: "Raleway";
            border: 1px solid #c9c6c6;
        }

        #login {
            position: absolute;
            width: fit-content;
            box-shadow: 0 0 22px #b8cbda9f;
            padding: 20px;
            /* margin-top: 30vh; */
            margin-left: auto;
            margin-right: auto;
            left: 0;
            right: 0;
            font-family: "Raleway";
            transition: 0.5s;
        }

        #reg {
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            left: 0;
            right: 0;
            width: fit-content;
            box-shadow: 0 0 22px #b8cbda9f;
            font-family: "Raleway";
            padding: 1vw;
            margin: 0 auto;
            margin-top: 10vh;
            transition: 0.5s;
            margin-top: 200vh;
        }

        form h1 {
            text-align: center;
            color: #032133e8;
        }

        form p {
            font-size: 14px;
        }

        .btnsubmit {
            padding: 0;
            border: 1px solid #107ec2;
            width: 150px;
            height: 30px;
            /* font: inherit; */
            /* color: inherit; */
            background: #107ec2;
            text-transform: uppercase;
            font-weight: 600;
            font-family: "Raleway";
            letter-spacing: 0.2rem;
            transition: 0.3s;
            color: #f4f8fa;
            display: flex;
            text-align: center;
            justify-content: center;
            margin: auto;
            margin-top: 20px;
            font-size: 13px;
        }

        .btnsubmit:hover {
            background: #1a6797;
            border: 1px solid #1a6797;
            cursor: pointer;
        }

        .btnreg {
            border: 1px solid #107ec2;
            background: #107ec2;
            text-transform: uppercase;
            font-weight: 600;
            font-family: "Raleway";
            letter-spacing: 0.2rem;
            transition: 0.3s;
            color: #f4f8fa;
            font-size: 13px;
        }

        .btnreg:hover {
            cursor: pointer;
        }
    </style>
    <!-- <p style="position:absolute; bottom:0;right:0;">В браузерах MSEdge, Explorer и подобных, вёрстка может отображаться некорректно</p> -->
    <div id="login" style=" <?php if (isset($_POST['go_reg'])) {
                                echo ("margin-top:-100vh;");
                            } else {
                                echo ("margin-top:30vh;");
                            } ?>">
        <form action="#" method="POST">
            <h1>Войти</h1>
            <input type="text" placeholder="Логин" name="login" minlength="4" required><br>
            <input type="password" placeholder="Пароль" name="password" minlength="6" required>
            <p style="text-align:right; margin-top:1vw;cursor:pointer;" onclick="toRegister()">Нет аккаунта? <span style="color:#126da5;">Зарегистрироваться</span></p>

            <input type="submit" value="Войти" class="btnsubmit" name="go_log">

        </form>
    </div>


    <div id="reg" style=" <?php if (isset($_POST['go_reg'])) {
                                echo ("margin-top:10vh;");
                            } else {
                                echo ("margin-top:200vh;");
                            } ?>">
        <form action="#" method="POST">
            <h1>Зарегистрироваться </h1>
            <div style="display:flex;">
                <div style="margin-right:2vw;">
                    <input type="text" placeholder="Логин*" name="login" minlength="4" required><br>
                    <input type="password" placeholder="Пароль*" name="password" minlength="6" required><br>
                    <input type="email" placeholder="Mail*" name="mail" required><br>
                </div>
                <div>
                    <input type="text" placeholder="Город" name="mest_jit"><br>
                    <input type="text" placeholder="Дата рождения" name="rodil"><br>
                    <input type="text" placeholder="Место работы" name="rab"><br>
                    <input type="text" placeholder="Место учебы" name="uch"><br>
                    <input type="text" placeholder="Семейное положение" name="polog"><br>
                    <input type="text" placeholder="Увлечения" name="evlech"><br>
                </div>
            </div>
            <p style="text-align:right; margin-top:1vw;cursor:pointer;color:#126da5;" onclick="toLogin()">Назад &rarr;</p>
            <input type="submit" class="btnreg" value="Зарегистрироваться" style="width:100%;" name="go_reg">
        </form>
    </div>
</body>

</html>