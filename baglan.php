<?php

try{
    $db = new PDO("mysql:host=localhost;dbname=editor;charset=utf8", "root", "");
    //print "Bağlantı Başarılı!";


}catch(PDOException $mesaj)
{
    echo $mesaj->getMessage();
}


?>