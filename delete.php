<?php

$id = $_POST['id'] ?? null;

if(!$id){
    header('Location:index.php');
    exit;
}

$dbname = "product_crud";
$dbuser = "root";
$dbpass = "";

$pdo = new PDO("mysql:host=localhost;port=8111;dbname=$dbname", $dbuser . $dbpass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement = $pdo->prepare('DELETE FROM products WHERE id=:id');
$statement->bindValue(":id",$id);
$statement->execute();
header('Location:index.php');