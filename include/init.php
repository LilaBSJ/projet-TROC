<?php

$pdo = new PDO('mysql:host=cl1-sql10.lan.phpnet.org;dbname=qxt42091', 'qxt42091', "schastie", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

session_start();

define('RACINE_SITE', $_SERVER['DOCUMENT_ROOT'] . '/projet_troc/');
define('URL', 'https://lila-bsj.fr/');



$erreur= '';
$erreurIndex = '';
$yes = '';
$yesIndex = '';
$mess = '';


foreach($_POST as $key => $value){
    $_POST[$key] = htmlspecialchars(trim($value));
}

foreach($_GET as $key => $value){
    $_GET[$key] = htmlspecialchars(trim($value));
}

require_once('fonctions.php');