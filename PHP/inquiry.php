<?php

$P1 = $_POST['nameless'];
$P2 = $_POST['mail'];
$P3 = $_POST['inquiry'];

session_start(); 
// バリデーション
if (empty($P2) || empty($P3)) {
    echo "<script>alert('空白欄を入力してください');</script>";
    echo "<script>window.location.href = '../HTML/inquiry.html?error=1';</script>";
    exit();
}elseif (!filter_var($P2, FILTER_VALIDATE_EMAIL)) {
    // メールアドレスの形式を確認
    echo "<script>alert('メールアドレスの形式で入力してください');</script>";
    echo "<script>window.location.href = '../HTML/inquiry.html?error=1';</script>";
    exit();
}

if(empty($P1)){
    $P1 = '匿名';
}

$pdo = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');

$stmt = $pdo->prepare("INSERT INTO inquiry_data(nameless, mail, inquiry) VALUES(:nameless, :mail, :inquiry)");
$stmt->bindValue(':nameless', $P1, PDO::PARAM_STR);
$stmt->bindValue(':mail', $P2, PDO::PARAM_STR);
$stmt->bindValue(':inquiry', $P3, PDO::PARAM_STR);

$stmt->execute();

$pdo = null;

header('Location: ../HTML/completely.html')
?>