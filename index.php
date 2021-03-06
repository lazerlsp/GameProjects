<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>New Game</title>
    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!--CSS-->
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/adaptive.css" type="text/css">
    <link rel="stylesheet" href="css/popup.css" type="text/css">
</head>
<body>

<header class="top_bar">
    <img id="logo" src="img/logo.png" alt="logo">
    <a class="top_btn" id="forum" href="#">Форум</a>
    <a class="top_btn" id="group" href="#">Группа ВК</a>
    <a class="top_btn" id="rules" href="#">Правила</a>
    <a class="top_btn" id="news" href="#">Новости</a>
<!--    <a class="top_btn" id="autr" href="autorize.php">Вход</a>-->
    <!--Pop-up-->
    <div>
        <a href="#popup-1" class="popup-link top_btn" id="autr">Вход</a>
    </div>
    <div id="popup-1" class="popup">
        <div class="popup__body">
            <button class="popup__close close-popup">&#10006;</button>
            <h2 class="popup_hello">Авторизация</h2>
            <form action="autorize.php" method="post">
                <span id="login">Логин:</span><input class="login" name="LOGIN" type="text" size="16" maxlength="16" value="">
                <span id="pass">Пароль:</span><input class="pass" name="PASSWORD" type="password" size="16" maxlength="16" value="">
                <input class="top_bar_login login_go" type="submit" name="submit" value="Вход" />
            </form>
        </div>
    </div>
    <!--Pop-up End-->
</header>

<main>
    <span id="main_logo_text">Начни свое приключение здесь!</span>
    <img id="main_logo" src="img/bg.jpg" alt="background">

    <h2 id="online_text">Онлайн</h2>
    <div class="main_bar" id="online"></div>

    <h2 id="popularity_text">Зал славы</h2>
    <div class="main_bar" id="popularity"></div>

    <h2 id="events_text">События</h2>
    <div class="main_bar" id="events"></div>
</main>

<footer>
    <h1>Все права защищены!</h1>
</footer>
<script src="script/script.js"></script>
</body>
</html>