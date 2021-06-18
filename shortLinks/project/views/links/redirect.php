<?php

require_once __DIR__."\..\..\classes\ShortUrl.php";

try{
    $pdo = new PDO("mysql:host=localhost;dbname=shortLinks",'root', '');
}catch(PDOException $e){
    print "Error!:" . $e->getMessage() . "<br/>";
    die();
}

$short = new ShortUrl($pdo);
try {
    $long_link = $short->shortCodeToUrl($link);
    header("Location: ".$long_link);
} catch (Exception $e) {
    echo $e->getMessage();
}


