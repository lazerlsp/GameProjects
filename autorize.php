<?php
session_start();

include ("database/base.php");

$dat = date('Y-m-d');
function obTxt($text): string
{
    $text = trim($text);
    $text = stripslashes($text);
    return htmlspecialchars($text);
}

if(isset($_POST['PASSWORD']) && isset($_POST['LOGIN'])){
    $password = md5(obTxt($_POST['PASSWORD'])); if ($password == '') unset($password);
    $login    = obTxt($_POST['LOGIN']);    if ($login == '')    unset($login);
}

if(empty($login) OR empty($password)){
    echo
    "<script>alert('Вы ввели не всю информацию, пожалуйста, заполните все необходимые поля!')</script>";
    echo
    "<script>window.location.href='..';</script>";
    exit;
}

if(!preg_match("|^[a-z_-]+$|i", $login)){
    echo "<script>alert('Не правильно введен логин!')</script>";
    echo "<script>window.location.href='..';</script>";
    exit;
}

if(strlen($login) < 3 OR strlen($login) > 16){
    echo
    "<script>alert('Логин должен состоять не менее чем из 3 символов и не более чем из 15.')</script>";
    echo "<script>window.location.href='..';</script>";
    exit;
}

if(strlen($password) < 6 OR strlen($password) > 40){
    echo
    "<script>alert('Пароль должен состоять не менее чем из 6 символов и не более чем из 16.')</script>";
    echo "<script>window.location.href='..';</script>";
    exit;
}

$ippMy = $_SERVER['REMOTE_ADDR'];
if(empty($ippMy) || $ippMy=='unknown') $ippMy = getenv("HTTP_X_FORWARDED_FOR");
if(empty($ippMy)) $ippMy = getenv("REMOTE_ADDR");

$password = strrev($password); //Реверс пароля
$password = $password."b3p6f";
$autorize = first('SELECT id,password,login,groups,activation FROM users WHERE login="%s" AND password="%s" AND activation=1',$login,$password);

if(empty($autorize['id'])){
    echo "<script>alert('Извините, введённый вами логин или пароль неверный.')</script>";
    echo "<script>window.location.href='..';</script>";
    exit;
}else {
    $_SESSION['password'] = $autorize['password'];
    $_SESSION['login'] = $autorize['login'];
    $_SESSION['id'] = $autorize['id'];
    update('users', array('online' => '1', 'onlinetime' => time(), 'ip' => ip2long($ippMy)), 'id=' . (int)$autorize['id']);
    if ($autorize['groups'] == 7 || $autorize['groups'] == 10 || $autorize['activation'] == 0) {
    }else {
        //usersunictable - таблица настройки ивента
        require_once('include/function/globfanction.php');
        require_once('include/function/function.events.php');
        $unic = first('SELECT id,myday,coolday FROM usersunictable WHERE id=%d', $autorize['id']);
        if (!empty($unic['id'])) {
            $tm = time() + (60 * 60 * 24);
            $datUnc = date('Y-m-d', $tm);
            if ($unic['myday'] === $dat || $unic['myday'] === '0000-00-00') {
                $coolday = $unic['coolday'] + 1;
                if ($coolday > 0) $_SESSION['prizeUsers'] = funcItemEventDay($coolday); // Уник. сессия.
                query('UPDATE usersunictable SET myday="%s", coolday=coolday+1 WHERE id=%d', $datUnc, $unic['id']);
            } else {
                update('usersunictable', array('myday' => $datUnc), 'id=' . (int)$unic['id']);
            }
        }
    }
}

echo "<script>window.location.href='/game.php?go=start';</script>";
exit;
