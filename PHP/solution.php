<?php
    session_start(); 
    
    // フォームの値を取得する
    $choice = $_POST['choice'];
    $choice2 = $_POST['choice2'];
    $choice3 = $_POST['choice3'];

    $count = true;

    if ($choice == '---'){
        echo "<script>alert('市を選択してください');</script>";
        echo "<script>window.location.href = '../HTMLsolution.html?error=1';</script>";
        exit();
    }
    if ($choice2 == '---'){
        echo "<script>alert('解決してみたいジャンルを選択してください');</script>";
        echo "<script>window.location.href = '../HTML/solution.html?error=1';</script>";
        exit();
    }

    
    $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');

    $sql_kanazawa = "SELECT comment FROM civic WHERE choice = '$choice' AND choice2 = '$choice2' AND comment LIKE '%$choice3%'";
    $result_kanazawa = $conn->query($sql_kanazawa);
    $row_kanazawa = $result_kanazawa->fetch(PDO::FETCH_ASSOC);
    if ($row_kanazawa) {
        $file_path = '../TXT/test.txt';
        file_put_contents($file_path, $row_kanazawa);
    } else {
        $sql_kanazawa = "SELECT comment FROM civic WHERE choice = '$choice' AND choice2 = '$choice2'";
        $result_kanazawa = $conn->query($sql_kanazawa);
        $row_kanazawa = $result_kanazawa->fetch(PDO::FETCH_ASSOC);
        if ($row_kanazawa) {
            $file_path = '../TXT/test.txt';
            file_put_contents($file_path, $row_kanazawa);
        } else {
            $count = false;
        }
    }
    
    if ($count == true) {
        header('Location: ../HTML/solution2.html');
    }else{
        header('Location: ../HTML/solution3.html');
    }
    
?>