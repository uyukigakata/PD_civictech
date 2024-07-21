<!DOCTYPE html>
<html>
<head>
  <title>珠洲市に関するグラフ</title>
  <link rel="stylesheet" href="../CSS/graph.css" media="all" />
</head>
<body>
  <h1>珠洲市に関するグラフ</h1>

  <?php
  $file_path = '../TXT/suzu_count.txt';
  if (file_exists($file_path)) {
    @unlink($file_path);
  }
  //珠洲市の総数
  $file = fopen($file_path, 'a');
  $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');
  $sql_suzu = "SELECT COUNT(*) AS suzu_count FROM civic WHERE choice = '珠洲市'";
  $result_suzu = $conn->query($sql_suzu);
  $row_suzu = $result_suzu->fetch(PDO::FETCH_ASSOC);
  $suzu_count = $row_suzu['suzu_count'];
  fwrite($file, "$suzu_count\n");

  //珠洲市+ゴミというワードが含まれている総数
  $sql_suzu_w1 = "SELECT COUNT(*) AS suzu_count FROM civic WHERE choice = '珠洲市' AND choice2 = 'ゴミ'";
  $result_suzu_w1 = $conn->query($sql_suzu_w1);
  $row_suzu_w1 = $result_suzu_w1->fetch(PDO::FETCH_ASSOC);
  $suzu_count_w1 = $row_suzu_w1['suzu_count'];
  fwrite($file, "$suzu_count_w1\n");

  //珠洲市+人というワードが含まれている総数
  $sql_suzu_w2 = "SELECT COUNT(*) AS suzu_count FROM civic WHERE choice = '珠洲市' AND choice2 = '人'";
  $result_suzu_w2 = $conn->query($sql_suzu_w2);
  $row_suzu_w2 = $result_suzu_w2->fetch(PDO::FETCH_ASSOC);
  $suzu_count_w2 = $row_suzu_w2['suzu_count'];
  fwrite($file, "$suzu_count_w2\n");

  //珠洲市+環境というワードが含まれている総数
  $sql_suzu_w3 = "SELECT COUNT(*) AS suzu_count FROM civic WHERE choice = '珠洲市' AND choice2 = '環境'";
  $result_suzu_w3 = $conn->query($sql_suzu_w3);
  $row_suzu_w3 = $result_suzu_w3->fetch(PDO::FETCH_ASSOC);
  $suzu_count_w3 = $row_suzu_w3['suzu_count'];
  fwrite($file, "$suzu_count_w3\n");

  //珠洲市のその他の総数
  $sql_suzu_other = "SELECT COUNT(*) AS suzu_count FROM civic WHERE choice = '珠洲市' AND choice2 = 'その他'";
  $result_suzu_other = $conn->query($sql_suzu_other);
  $row_suzu_other = $result_suzu_other->fetch(PDO::FETCH_ASSOC);
  $suzu_count_other = $row_suzu_other['suzu_count'];
  fwrite($file, "$suzu_count_other\n");

  
  //珠洲市の最新のゴミのコメントを検索
  $sql_gomi_comment = "SELECT comment AS gomi_count FROM civic WHERE choice = '珠洲市' AND choice2 = 'ゴミ' ORDER BY id DESC LIMIT 1";
  $result_gomi = $conn->query($sql_gomi_comment);
  $row_gomi = $result_gomi->fetch(PDO::FETCH_ASSOC);
  if ($row_gomi) {
    $suzu_gomi = $row_gomi['gomi_count'];
  } else {
    $suzu_gomi = "現在投稿されていません";
  }

  //珠洲市の最新の人のコメントを検索
  $sql_hito_comment = "SELECT comment AS hito_count FROM civic WHERE choice = '珠洲市' AND choice2 = '人' ORDER BY id DESC LIMIT 1";
  $result_hito = $conn->query($sql_hito_comment);
  $row_hito = $result_hito->fetch(PDO::FETCH_ASSOC);
  if ($row_hito) {
    $suzu_hito = $row_hito['hito_count'];
  } else {
    $suzu_hito = "現在投稿されていません";
  }

   //珠洲市の最新の環境のコメントを検索
   $sql_kankyou_comment = "SELECT comment AS kankyou_count FROM civic WHERE choice = '珠洲市' AND choice2 = '環境' ORDER BY id DESC LIMIT 1";
   $result_kankyou = $conn->query($sql_kankyou_comment);
   $row_kankyou = $result_kankyou->fetch(PDO::FETCH_ASSOC);
   if ($row_kankyou) {
     $suzu_kankyou = $row_kankyou['kankyou_count'];
   } else {
     $suzu_kankyou = "現在投稿されていません";
   }

   //珠洲市の最新のその他のコメントを検索
   $sql_other_comment = "SELECT comment AS other_count FROM civic WHERE choice = '珠洲市' AND choice2 = 'その他' ORDER BY id DESC LIMIT 1";
   $result_other = $conn->query($sql_other_comment);
   $row_other = $result_other->fetch(PDO::FETCH_ASSOC);
   if ($row_other) {
     $suzu_other = $row_other['other_count'];
   } else {
     $suzu_other = "現在投稿されていません";
   }

  ?>

  <!-- ここでPythonスクリプトを実行する -->

  <?php
  exec('python ../Python/suzu_graph.py', $output);
  foreach ($output as $line) {
    echo "<p>$line</p>";
  }
  echo "珠洲市の総数は{$suzu_count}です.<br> ";
  echo "珠洲市のゴミに関する投稿の総数は{$suzu_count_w1}です。<br>";
  echo "珠洲市の人に関する投稿の総数は{$suzu_count_w2}です。<br >";
  echo "珠洲市の環境に関する投稿の総数は{$suzu_count_w3}です。<br >";
  echo "珠洲市のその他の投稿総数は{$suzu_count_other}です。<br >";

  echo "<b>ゴミに関するコメント：</b><br>";
  echo "{$suzu_gomi}<br>";
  echo "<b>人に関するコメント：</b><br>";
  echo "{$suzu_hito}<br>";
  echo "<b>環境に関するコメント：</b><br>";
  echo "{$suzu_kankyou}<br>";
  echo "<b>その他に関するコメント：</b><br>";
  echo "{$suzu_other}<br>";

  $file_path = '../png/suzu_graph.png';
  if (file_exists($file_path)) {
    echo '<img src="' . $file_path . '" alt="Pythonで作成したPNGファイル">';
  } else {
    echo "グラフ作成できるほどのデータがありません";
  }
  ?>
</body>
</html>