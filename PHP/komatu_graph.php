<!DOCTYPE html>
<html>
<head>
  <title>小松市に関するグラフ</title>
  <link rel="stylesheet" href="../CSS/graph.css" media="all" />
</head>
<body>
  <h1>小松市に関するグラフ</h1>

  <?php
  $file_path = '../TXT/komatu_count.txt';
  if (file_exists($file_path)) {
    @unlink($file_path);
  }
  //小松市の総数
  $file = fopen($file_path, 'a');
  $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');
  $sql_komatu = "SELECT COUNT(*) AS komatu_count FROM civic WHERE choice = '小松市'";
  $result_komatu = $conn->query($sql_komatu);
  $row_komatu = $result_komatu->fetch(PDO::FETCH_ASSOC);
  $komatu_count = $row_komatu['komatu_count'];
  fwrite($file, "$komatu_count\n");

  //小松市+ゴミというワードが含まれている総数
  $sql_komatu_w1 = "SELECT COUNT(*) AS komatu_count FROM civic WHERE choice = '小松市' AND choice2 = 'ゴミ'";
  $result_komatu_w1 = $conn->query($sql_komatu_w1);
  $row_komatu_w1 = $result_komatu_w1->fetch(PDO::FETCH_ASSOC);
  $komatu_count_w1 = $row_komatu_w1['komatu_count'];
  fwrite($file, "$komatu_count_w1\n");

  //小松市+人というワードが含まれている総数
  $sql_komatu_w2 = "SELECT COUNT(*) AS komatu_count FROM civic WHERE choice = '小松市' AND choice2 = '人'";
  $result_komatu_w2 = $conn->query($sql_komatu_w2);
  $row_komatu_w2 = $result_komatu_w2->fetch(PDO::FETCH_ASSOC);
  $komatu_count_w2 = $row_komatu_w2['komatu_count'];
  fwrite($file, "$komatu_count_w2\n");

  //小松市+環境というワードが含まれている総数
  $sql_komatu_w3 = "SELECT COUNT(*) AS komatu_count FROM civic WHERE choice = '小松市' AND choice2 = '環境'";
  $result_komatu_w3 = $conn->query($sql_komatu_w3);
  $row_komatu_w3 = $result_komatu_w3->fetch(PDO::FETCH_ASSOC);
  $komatu_count_w3 = $row_komatu_w3['komatu_count'];
  fwrite($file, "$komatu_count_w3\n");

  //小松市のその他の総数
  $sql_komatu_other = "SELECT COUNT(*) AS komatu_count FROM civic WHERE choice = '小松市' AND choice2 = 'その他'";
  $result_komatu_other = $conn->query($sql_komatu_other);
  $row_komatu_other = $result_komatu_other->fetch(PDO::FETCH_ASSOC);
  $komatu_count_other = $row_komatu_other['komatu_count'];
  fwrite($file, "$komatu_count_other\n");

  
  //小松市の最新のゴミのコメントを検索
  $sql_gomi_comment = "SELECT comment AS gomi_count FROM civic WHERE choice = '小松市' AND choice2 = 'ゴミ' ORDER BY id DESC LIMIT 1";
  $result_gomi = $conn->query($sql_gomi_comment);
  $row_gomi = $result_gomi->fetch(PDO::FETCH_ASSOC);
  if ($row_gomi) {
    $komatu_gomi = $row_gomi['gomi_count'];
  } else {
    $komatu_gomi = "現在投稿されていません";
  }

  //小松市の最新の人のコメントを検索
  $sql_hito_comment = "SELECT comment AS hito_count FROM civic WHERE choice = '小松市' AND choice2 = '人' ORDER BY id DESC LIMIT 1";
  $result_hito = $conn->query($sql_hito_comment);
  $row_hito = $result_hito->fetch(PDO::FETCH_ASSOC);
  if ($row_hito) {
    $komatu_hito = $row_hito['hito_count'];
  } else {
    $komatu_hito = "現在投稿されていません";
  }

   //小松市の最新の環境のコメントを検索
   $sql_kankyou_comment = "SELECT comment AS kankyou_count FROM civic WHERE choice = '小松市' AND choice2 = '環境' ORDER BY id DESC LIMIT 1";
   $result_kankyou = $conn->query($sql_kankyou_comment);
   $row_kankyou = $result_kankyou->fetch(PDO::FETCH_ASSOC);
   if ($row_kankyou) {
     $komatu_kankyou = $row_kankyou['kankyou_count'];
   } else {
     $komatu_kankyou = "現在投稿されていません";
   }

   //小松市の最新のその他のコメントを検索
   $sql_other_comment = "SELECT comment AS other_count FROM civic WHERE choice = '小松市' AND choice2 = 'その他' ORDER BY id DESC LIMIT 1";
   $result_other = $conn->query($sql_other_comment);
   $row_other = $result_other->fetch(PDO::FETCH_ASSOC);
   if ($row_other) {
     $komatu_other = $row_other['other_count'];
   } else {
     $komatu_other = "現在投稿されていません";
   }

  ?>

  <!-- ここでPythonスクリプトを実行する -->

  <?php
  exec('python ../Python/komatu_graph.py', $output);
  foreach ($output as $line) {
    echo "<p>$line</p>";
  }
  echo "小松市の総数は{$komatu_count}です.<br> ";
  echo "小松市のゴミに関する投稿の総数は{$komatu_count_w1}です。<br>";
  echo "小松市の人に関する投稿の総数は{$komatu_count_w2}です。<br >";
  echo "小松市の環境に関する投稿の総数は{$komatu_count_w3}です。<br >";
  echo "小松市のその他の投稿総数は{$komatu_count_other}です。<br >";

  echo "<b>ゴミに関するコメント：</b><br>";
  echo "{$komatu_gomi}<br>";
  echo "<b>人に関するコメント：</b><br>";
  echo "{$komatu_hito}<br>";
  echo "<b>環境に関するコメント：</b><br>";
  echo "{$komatu_kankyou}<br>";
  echo "<b>その他に関するコメント：</b><br>";
  echo "{$komatu_other}<br>";

  $file_path = '../png/komatu_graph.png';
  if (file_exists($file_path)) {
    echo '<img src="' . $file_path . '" alt="Pythonで作成したPNGファイル">';
  } else {
    echo "グラフ作成できるほどのデータがありません";
  }
  ?>
</body>
</html>