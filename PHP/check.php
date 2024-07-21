<?php
    session_start(); 
    
    // フォームの値を取得する
    $cho = $_POST["choice"];
    $cho2 = $_POST['choice2'];
    $com = $_POST['comment'];
    $toggleState = isset($_POST['toggleState']) ? $_POST['toggleState'] : 'off';

    // バリデーション
    if ($cho == '---'){
        echo "<script>alert('市を選択してください');</script>";
        echo "<script>window.location.href = 'opinion.html?error=1';</script>";
        exit();
    }
    if ($cho2 == '---'){
        echo "<script>alert('ジャンルを選択してください');</script>";
        echo "<script>window.location.href = 'opinion.html?error=1';</script>";
        exit();
    }
    if (empty($com)) {
        echo "<script>alert('空白欄を入力してください');</script>";
        echo "<script>window.location.href = 'opinion.html?error=1';</script>";
        exit();
    }

    if ($toggleState === 'on'){
        $cho = '匿名';
    }

    $pdo = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');

    $stmt = $pdo->prepare("INSERT INTO civic(choice, choice2, comment) VALUES(:choice, :choice2, :comment)");
    $stmt->bindValue('choice',$cho, PDO::PARAM_STR);
    $stmt->bindValue('choice2',$cho2, PDO::PARAM_STR);
    $stmt->bindValue('comment',$com, PDO::PARAM_STR);

    $stmt->execute();
    
    header('Location: ../HTML/completely.html');
?>