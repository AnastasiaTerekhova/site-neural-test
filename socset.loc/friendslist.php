<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Друзья</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="user-card-all" style="display:flex; flex-wrap:wrap;">

        <h1 style="width: 50%;color: #032133e8; padding: 50px 0px 50px 0px; font-size:18px">Список друзей:</h1>
        <h1 style="float:right; width:50%; text-align:right; cursor:pointer; padding: 50px 0px 50px 0px; font-size:18px"><a style="color: #032133e8; font-family:Raleway" href="?search="><i class="fa fa-search" style="padding: 0px 10px 0px 0px" aria-hidden="true"></i>Поиск</a></h1><br>
        <?php


        if (isset($_POST['deleteGo'])) {
            unset($sessionInfo->friends[intval($_POST['userid'])]);

            $user = mysqli_fetch_assoc(mysqli_query($connections, "SELECT * FROM `users` WHERE `id`=" . $_POST['id']));
            $info = json_decode($user['info_json']);
            for ($i = 0; $i < count($info->friends); $i++) {
                if ($info->friends[$i] == strval($_SESSION['user']['id'])) {
                    unset($info->friends[$i]);
                    break;
                }
            }
            $info_json = json_encode($info, JSON_UNESCAPED_UNICODE);
            mysqli_query($connections, "UPDATE `users` SET `info_json` = '{$info_json}' WHERE `id`=" . (int)$user['id']);


            $infous_json = json_encode($sessionInfo, JSON_UNESCAPED_UNICODE);
            mysqli_query($connections, "UPDATE `users` SET `info_json` = '{$infous_json}' WHERE `id`=" . (int)$_SESSION['user']['id']);
            echo ("<script>document.location.href  = '/?friends='</script>");
        }

        $allfriends = $sessionInfo->friends;
        // $allfriends = $sessionInfo['friends'];
        for ($i = 0; $i < count($allfriends); $i++) {
            if ($allfriends != '') {
                $user = mysqli_fetch_assoc(mysqli_query($connections, "SELECT * FROM `users` WHERE `id`=" . $allfriends[$i]));
        ?>
                <div class="user-card-posts" style="display:flex; width:30%; margin-right:0.8%; flex-wrap:wrap; box-shadow: 0 0 7px #03213350; border-radius:6px">
                    <div style="background-image:url(<?php echo (json_decode($user['info_json'])->avatar) ?>);width:10vw; height:10vw; background-repeat: no-repeat; border-radius:50vw;">
                    </div>
                    <div style="margin-left:2%; width:60%;">
                        <h1 class="link" style="cursor:pointer; padding:40px 20px 20px 20px; font-size:16px"><a href="?home=&id=<?php echo $user['id']; ?>"><?php echo ($user['name']) ?></a></h1>
                    </div>
                    <form action="" method="post" style="width:100%; margin-top:1vw;">
                        <input type="hidden" name="userid" value="<?php echo $i; ?>">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <button type="submit" style="width:100%;
                     font-size:1vw;
                     border: 1px solid #107ec2;
    background: #107ec2;
    color: #fff;
    text-transform: uppercase;
  font-weight: 600;
  font-family:  Raleway;
   letter-spacing: 0.2rem;
   padding:5px;
   font-size:10px;
   cursor: pointer;" name="deleteGo">Удалить</button>
                    </form>
                </div>

        <?php
            }
        }
        ?>
    </div>
    <?php

    if (count($allfriends) == 0) {
    ?>
        <br>
        <h2 style="text-align:center;">У вас нет друзей :(</h2>
    <?php
    }
    ?>
    <script src="https://use.fontawesome.com/e97bffe0be.js"></script>
</body>

</html>