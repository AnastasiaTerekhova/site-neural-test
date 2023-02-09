<?php
$user = null;
$info = "";
if (isset($_GET['id'])) {
    $user = mysqli_fetch_assoc(mysqli_query($connections, "SELECT * FROM `users` WHERE `id`=" . intval($_GET['id'])));
    $info = json_decode($user['info_json']);
} else {
    $q = mysqli_query($connections, "SELECT * FROM `users` WHERE `id`=" . intval($_SESSION['user']['id']));
    if (mysqli_num_rows($q) == 0) {
        echo ("<script>document.location.href  = '/auth.php'</script>");
        die;
    }
    $user = mysqli_fetch_assoc(mysqli_query($connections, "SELECT * FROM `users` WHERE `id`=" . intval($_SESSION['user']['id'])));

    $info = json_decode($user['info_json']);
}
if (isset($_GET['deletePost'])) {
    if (isset($_GET['postid'])) {
        $q = mysqli_fetch_assoc(mysqli_query($connections, "SELECT * FROM `posts` WHERE `id`=" . (int)$_GET['postid']));

        if ($q['userid'] == $_SESSION['user']['id'] || $q['fromuser'] == $_SESSION['user']['id']) {

            mysqli_query($connections, "DELETE FROM `posts` WHERE `id`=" . (int)$_GET['postid']);

            echo ("<script>document.location.href  = '?home=&id=" . (int)$_GET['id'] . "'</script>");
        }
    }
}
if (isset($_POST['go_user_save'])) {

    $ava = $_POST['avatar'];
    $back = $_POST['fon'];
    if (trim($_POST['avatar']) == '' || !checkRemoteFile(trim($_POST['avatar']))) {
        $ava = "img/avatar.jpg";
    }

    if (trim($_POST['fon']) == '' || !checkRemoteFile(trim($_POST['fon']))) {
        $back = "img/background.jpg";
    }

    $info = array(
        'location' => trim($_POST['mest_jit']),
        'born' => trim($_POST['rodil']),
        'job' => trim($_POST['rab']),
        'study' => trim($_POST['uch']),
        'type' => trim($_POST['polog']),
        'hobby' => trim($_POST['evlech']),
        'email' => trim($_POST['mail']),
        'background' => $back,
        'avatar' => $ava,
        'friends' => $sessionInfo->friends
    );

    $info_json = (json_encode($info, JSON_UNESCAPED_UNICODE));
    mysqli_query($connections, "UPDATE `users` SET `info_json` = '{$info_json}' WHERE `id`=" . (int)$_SESSION['user']['id']);
    echo ("<script>document.location.href  = '/?home='</script>");
}

if (isset($_POST['postinuserprofile'])) {

    if (trim($_POST['message']) != '') {
        $images = array();
        for ($i = 0; $i < 4; $i++) {
            if (trim($_POST[(string)('i' . $i)]) != '')
                array_push($images, trim($_POST[(string)('i' . $i)]));
        }

        $images_json = (json_encode($images, JSON_UNESCAPED_UNICODE));

        mysqli_query($connections, "INSERT INTO `posts`(`message`, `images_json`, `userid`, `fromuser`) VALUES ('{$_POST['message']}','{$images_json}','{$user['id']}','{$_SESSION['user']['id']}')");
        $id = mysqli_insert_id($connections);
        $posts = json_decode($user['posts_json']);
        array_push($posts, $id);

        $posts_json = (json_encode($posts, JSON_UNESCAPED_UNICODE));

        mysqli_query($connections, "UPDATE `users` SET `posts_json`='{$posts_json}' WHERE `id`=" . $user['id']);
        echo ("<script>document.location.href='/?home=&id=" . $user['id'] . "';</script>");
    }
}

if (isset($_GET['addfriend']) && isset($_GET['id'])) {
    $check =  mysqli_query($connections, "SELECT * FROM `pushes` WHERE (`userid`={$user['id']} AND `fromuser`={$_SESSION['user']['id']}) OR (`userid`={$_SESSION['user']['id']} AND `fromuser`={$user['id']})");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($connections, "INSERT INTO `pushes`(`userid`, `fromuser`, `type`) VALUES ('{$user['id']}','{$_SESSION['user']['id']}','tofriend')");
    }
    echo ("<script>document.location.href  = '/?home=&id=" . $user['id'] . "'</script>");
}
?>
<div>
    <div id="editwindow">
        <h1>Редактировать:</h1>
        <form action="#" method="POST" style="margin-left:5%;">
            <style>
                input {
                    width: 90%;
                    font-size: 1.2vw;
                    margin-top: 1vw;
                    border-style: solid;
                }
            </style>
            <input id="avatarurl" type="url" require placeholder="Ссылка на аватар" name="avatar" oninput="if ($('#avatarurl').val().trim() ==''){ $('#avatarinput').attr('src','img/avatar.jpg'); return true; } $('#avatarinput').attr('src',$('#avatarurl').val()); " value="<?php echo ($info->avatar); ?>"><br>
            <img id="avatarinput" style="width:10vw; height:10vw; margin-top:1vw; border-radius:50%;" src="<?php echo ($info->avatar); ?>" alt=""><br>
            <input id="backurl" type="url" require placeholder="Ссылка на фон" name="fon" oninput="if ($('#backurl').val().trim() ==''){ $('#backinput').attr('src','img/background.jpg'); return true; }$('#backinput').attr('src',$('#backurl').val())" value="<?php echo ($info->background); ?>"><br>
            <img id="backinput" style="width:90%; height:10vw; margin-top:1vw;" src="<?php echo ($info->background); ?>" alt=""><br>
            <input type="text" placeholder="Город" name="mest_jit" value="<?php echo ($info->location); ?>"><br>
            <input type="text" placeholder="Дата рождения" name="rodil" value="<?php echo ($info->born); ?>"><br>
            <!-- <input type="text" placeholder="Место работы" name="rab" value="<?php echo ($info->job); ?>"><br> -->
            <!-- <input type="text" placeholder="Место учебы" name="uch" value="<?php echo ($info->study); ?>"><br> -->
            <!-- <input type="text" placeholder="Семейное положение" name="polog" value="<?php echo ($info->type); ?>"><br> -->
            <!-- <input type="text" placeholder="Увлечения" name="evlech" value="<?php echo ($info->hobby); ?>"><br> -->
            <input type="submit" value="Сохранить" style="width:90%;" name="go_user_save">
        </form>

    </div>
    <div class="back" style="background-image: url(<?php echo ($info->background) ?>); overflow:hidden; ">
        <div id="editButton">
            <p onclick="$('#editwindow').show();" style="cursor:pointer;display:table; background-color: white; padding: 6vw; width: fit-content; border-radius: 50%; margin-left: -6vw; margin-top: -6vw;"><img style="width:2vw; height:2vw; " src="webicons/pen.svg"></p>
        </div>
    </div>
    <?php if ($user['id'] != $_SESSION['user']['id']) echo ("<script>document.querySelector('#editwindow').remove();  document.querySelector('#editButton').remove();</script>"); ?>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Raleway:400,300,600);

        .user-card {
            background: none;
            border-radius: 1px;
            box-shadow: 0 0 0;
            display: flex;
            justify-content: center;
        }

        .user-card .img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
        }

        .user-card-right h1 {
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 130px;
            width: 230px;
            height: 40px;
            top: 100px;
            margin-left: -180px;
            color: #2a80a1;
            font-size: 19px;
        }

        .infopage {
            margin: 20px;
            box-shadow: 0 0 7px #03213350;
            border-radius: 6px;
            border: 1px solid #2a80a1;
            background: #a4cad621;
        }

        .infopage h1 {
            padding-top: 30px;
            padding-left: 50px;
            color: #222;
            font-size: 16px;
        }

        .infopush h1 {
            padding-top: 30px;
            padding-left: 70px;
            color: #222;
            font-size: 16px;
        }

        .user-card-posts {
            box-shadow: 0 0 7px #03213350;
            border-radius: 6px;
            /* background: #a4cad621; */
        }

        .user-card-posts-creator h2 {
            padding-left: 20px;
        }

        .btn-sub {
            text-transform: uppercase;
            font-size: 13px;
            font-weight: 600;
            font-family: "Raleway";
            letter-spacing: 0.2rem;
            text-decoration: none;
            background: #fff;
            padding: 15px;
            border: 1px solid #222;
            color: #222;
            cursor: pointer;
            margin-top: 30px;
        }

        .btn-sub:hover {
            border: 1px solid #3eb7e6;
            color: #3eb7e6;
        }
    </style>
    <div class="user-card">
        <div class="img" style="background-image: url(<?php echo ($info->avatar) ?>);background-repeat: no-repeat;background-size: cover;"></div>
        <div class="user-card-right">
            <h1><?php echo ($user['name']); ?></h1>
            <?php
            $check =  mysqli_query($connections, "SELECT * FROM `pushes` WHERE (`userid`={$user['id']} AND `fromuser`={$_SESSION['user']['id']}) OR (`userid`={$_SESSION['user']['id']} AND `fromuser`={$user['id']})");
            if ($user['id'] != $_SESSION['user']['id']) {
                if (mysqli_num_rows($check) == 0) {
                    if ($sessionInfo->friends != null && in_array($user['id'], $sessionInfo->friends)) { ?>
                        <a style="width:2vw; height:2vw; margin:0; padding:0;" href="/?home=&id=<?php echo $user['id']; ?>&minusfriend=1"><img style="width:2vw;height:2vw; margin:0; padding:0" src="webicons\minus.svg" alt=""></a>
                    <?php
                    } else {
                    ?>
                        <a style="width:2vw; height:2vw; margin:0; padding:0;" href="/?home=&id=<?php echo $user['id']; ?>&addfriend=1"><img style="width:2vw;height:2vw; margin:0; padding:0" src="webicons\plus.svg" alt=""></a>
                    <?php
                    }
                    ?>

            <?php } else {
                    $check = mysqli_fetch_assoc($check);
                    if ($_SESSION['user']['id'] == $check['userid'])
                        echo ("Вам уже отправили запрос на дружбу");
                    else
                        echo ("Вы уже отправили запрос на дружбу");
                }
            } ?>
        </div>
    </div>
</div>
<div class="page-scroll-main">
    <div class="infopage">
        <h1>Личная информация:</h1>
        <table style="width:100%" cellspacing="50" style="text-align:center;">
            <tr>
                <td>
                    <p><b>Город:</b> <?php if ($info->location == "") echo ('Не указано');
                                        else echo ($info->location); ?> </p>
                </td>
                <td>
                    <p><b>Дата рождения:</b> <?php if ($info->born == "") echo ('Не указано');
                                                else echo ($info->born); ?> </p>
                </td>
                <!-- <td>
                    <p><b>Место работы:</b> <?php if ($info->job == "") echo ('Не указано');
                                            else echo ($info->job); ?> </p>
                </td> -->
                <!-- <td>
                    <p><b>Семейное положение:</b> <?php if ($info->type == "") echo ('Не указано');
                                                    else echo ($info->type); ?> </p>
                </td> -->
            </tr>
            <tr>
                <!-- <td>
                    <p><b>Место учебы:</b> <?php if ($info->study == "") echo ('Не указано');
                                            else echo ($info->study); ?> </p>
                </td> -->
               
                <!-- <td>
                    <p><b>Увлечения:</b> <?php if ($info->hobby == "") echo ('Не указано');
                                            else echo ($info->hobby); ?> </p>
                </td> -->
            </tr>
        </table>
    </div>


    <?php $ids = json_decode($user['posts_json']);
    $currentinfo = json_decode($_SESSION['user']['info_json']); ?>

    <div class="user-card-all">
        <div class="user-card-posts">
            <div class="user-card-posts-creator">
                <div style="background-image:url(<?php echo ($currentinfo->avatar); ?>); background-repeat: no-repeat;background-size: cover;"></div>
                <h2><?php echo ($_SESSION['user']['name']); ?></h2>
            </div>
            <form action="#" method="POST">
                <textarea minlength="20" require style="width:90%; margin-top:1vw; margin-left:30px; min-height:10vw; border-style:solid; resize: vertical; padding:20px;font-size:16px;" placeholder="Здесь вы можете опубликовать результаты теста" name="message"></textarea>
                <input style="border-style:solid; width:100%;" onclick="$('.images').show()" type="button" class="btn-sub" value="Вставить изображение">
                <style>
                    .images {
                        width: 100%;
                    }

                    .images input {
                        width: 100%;
                    }
                </style>
                <div class="images" style="display:none;">
                    <input type="text" name="i1" placeholder="url.com\imagename.png/.jpg/.gif...">
                    <input type="text" name="i2" placeholder="url.com\imagename.png/.jpg/.gif...">
                    <input type="text" name="i3" placeholder="url.com\imagename.png/.jpg/.gif...">
                    <input type="text" name="i4" placeholder="url.com\imagename.png/.jpg/.gif...">
                    <input type="text" name="i5" placeholder="url.com\imagename.png/.jpg/.gif...">
                </div>
                <button style="border-style:solid; width:100%;" type="submit" class="btn-sub" name="postinuserprofile">Отправить</button>
            </form>
        </div>
        <?php for ($i = count($ids) - 1; $i >= 0; $i--) {

            $post_q = mysqli_query($connections, "SELECT * FROM `posts` WHERE `id`=" . $ids[$i]);

            if (mysqli_num_rows($post_q) == 0)
                continue;

            $post = mysqli_fetch_assoc($post_q);
            $fromuser = mysqli_fetch_assoc(mysqli_query($connections, "SELECT * FROM `users` WHERE `id`=" . $post['fromuser']));
            $images = json_decode($post['images_json']);
            $formuserinfo = json_decode($fromuser['info_json']);
        ?>
            <div class="infopush">
                <h1>Публикации пользователя:</h1>
            </div>
            <div class="user-card-posts">
                <div class="user-card-posts-creator">
                    <div style="background-image:url(<?php echo ($formuserinfo->avatar); ?>); background-repeat: no-repeat;background-size: cover;"></div>
                    <div style="width:100%;">
                        <h2 class="link" style="cursor:pointer; float:left;"><a href="?home=&id=<?php echo $fromuser['id']; ?>" target="_blank"><?php echo ($fromuser['name']); ?></a></h2>
                        <?php if ($_SESSION['user']['id'] == $fromuser['id'] || $_SESSION['user']['id'] == $post['userid']) { ?>
                            <h2 style="cursor:pointer; float:right;"><a href="?home=&deletePost=&id=<?php echo $user['id']; ?>&postid=<?php echo $post['id']; ?>">X</a></h2>
                        <?php } ?>

                    </div>

                </div>
                <p style="margin-top:1vw;padding:20px;line-height:25px;"><?php echo ($post['message']); ?></p>
                <?php if (count($images) == 0) { ?>
                    <p><?php
                        $timestamp = strtotime($post['date']);
                        echo date('H:i:s d/m/Y', $timestamp); ?>
                    </p>


                <?php echo ('</div>');
                    continue;
                } ?>
                <div class="postImages">
                    <?php
                    for ($j = 0; $j < count($images); $j++) { ?>
                        <div style="height:10vw; overflow:hidden;width:<?php echo (100 / count($images)); ?>%;"><a style="width:100%;" href="<?php echo ($images[$j]); ?>" target_="_blank"> <img style="width:100%; cursor:pointer;" src="<?php echo ($images[$j]); ?>"></a></div>
                    <?php
                    }
                    ?>
                </div>
                <p><?php
                    $timestamp = strtotime($post['date']);
                    echo date('H:i:s d/m/Y', $timestamp); ?>
                </p>
            </div>
        <?php } ?>
    </div>
</div>