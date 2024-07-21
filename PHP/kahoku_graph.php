<!DOCTYPE html>
<html>
<head>
  <title>かほく市に関するグラフ</title>
  <link rel="stylesheet" href="../CSS/graph.css" media="all" />
</head>
<body>
  <h1>かほく市に関するグラフ</h1>

  <?php
  $file_path = '../TXT/kahoku_count.txt';
  if (file_exists($file_path)) {
    @unlink($file_path);
  }
  //かほく市の総数
  $file = fopen($file_path, 'a');
  $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');
  $sql_kahoku = "SELECT COUNT(*) AS kahoku_count FROM civic WHERE choice = 'かほく市'";
  $result_kahoku = $conn->query($sql_kahoku);
  $row_kahoku = $result_kahoku->fetch(PDO::FETCH_ASSOC);
  $kahoku_count = $row_kahoku['kahoku_count'];
  fwrite($file, "$kahoku_count\n");

  //かほく市+ゴミというワードが含まれている総数
  $sql_kahoku_w1 = "SELECT COUNT(*) AS kahoku_count FROM civic WHERE choice = 'かほく市' AND choice2 = 'ゴミ'";
  $result_kahoku_w1 = $conn->query($sql_kahoku_w1);
  $row_kahoku_w1 = $result_kahoku_w1->fetch(PDO::FETCH_ASSOC);
  $kahoku_count_w1 = $row_kahoku_w1['kahoku_count'];
  fwrite($file, "$kahoku_count_w1\n");

  //かほく市+人というワードが含まれている総数
  $sql_kahoku_w2 = "SELECT COUNT(*) AS kahoku_count FROM civic WHERE choice = 'かほく市' AND choice2 = '人'";
  $result_kahoku_w2 = $conn->query($sql_kahoku_w2);
  $row_kahoku_w2 = $result_kahoku_w2->fetch(PDO::FETCH_ASSOC);
  $kahoku_count_w2 = $row_kahoku_w2['kahoku_count'];
  fwrite($file, "$kahoku_count_w2\n");

  //かほく市+環境というワードが含まれている総数
  $sql_kahoku_w3 = "SELECT COUNT(*) AS kahoku_count FROM civic WHERE choice = 'かほく市' AND choice2 = '環境'";
  $result_kahoku_w3 = $conn->query($sql_kahoku_w3);
  $row_kahoku_w3 = $result_kahoku_w3->fetch(PDO::FETCH_ASSOC);
  $kahoku_count_w3 = $row_kahoku_w3['kahoku_count'];
  fwrite($file, "$kahoku_count_w3\n");

  //かほく市のその他の総数
  $sql_kahoku_other = "SELECT COUNT(*) AS kahoku_count FROM civic WHERE choice = 'かほく市' AND choice2 = 'その他'";
  $result_kahoku_other = $conn->query($sql_kahoku_other);
  $row_kahoku_other = $result_kahoku_other->fetch(PDO::FETCH_ASSOC);
  $kahoku_count_other = $row_kahoku_other['kahoku_count'];
  fwrite($file, "$kahoku_count_other\n");

  
  //かほく市の最新のゴミのコメントを検索
  $sql_gomi_comment = "SELECT comment AS gomi_count FROM civic WHERE choice = 'かほく市' AND choice2 = 'ゴミ' ORDER BY id DESC LIMIT 1";
  $result_gomi = $conn->query($sql_gomi_comment);
  $row_gomi = $result_gomi->fetch(PDO::FETCH_ASSOC);
  if ($row_gomi) {
    $kahoku_gomi = $row_gomi['gomi_count'];
  } else {
    $kahoku_gomi = "現在投稿されていません";
  }

  //かほく市の最新の人のコメントを検索
  $sql_hito_comment = "SELECT comment AS hito_count FROM civic WHERE choice = 'かほく市' AND choice2 = '人' ORDER BY id DESC LIMIT 1";
  $result_hito = $conn->query($sql_hito_comment);
  $row_hito = $result_hito->fetch(PDO::FETCH_ASSOC);
  if ($row_hito) {
    $kahoku_hito = $row_hito['hito_count'];
  } else {
    $kahoku_hito = "現在投稿されていません";
  }

   //かほく市の最新の環境のコメントを検索
   $sql_kankyou_comment = "SELECT comment AS kankyou_count FROM civic WHERE choice = 'かほく市' AND choice2 = '環境' ORDER BY id DESC LIMIT 1";
   $result_kankyou = $conn->query($sql_kankyou_comment);
   $row_kankyou = $result_kankyou->fetch(PDO::FETCH_ASSOC);
   if ($row_kankyou) {
     $kahoku_kankyou = $row_kankyou['kankyou_count'];
   } else {
     $kahoku_kankyou = "現在投稿されていません";
   }

   //かほく市の最新のその他のコメントを検索
   $sql_other_comment = "SELECT comment AS other_count FROM civic WHERE choice = 'かほく市' AND choice2 = 'その他' ORDER BY id DESC LIMIT 1";
   $result_other = $conn->query($sql_other_comment);
   $row_other = $result_other->fetch(PDO::FETCH_ASSOC);
   if ($row_other) {
     $kahoku_other = $row_other['other_count'];
   } else {
     $kahoku_other = "現在投稿されていません";
   }

  ?>

  <!-- ここでPythonスクリプトを実行する -->

  <?php
  exec('python ../Python/kahoku_graph.py', $output);
  foreach ($output as $line) {
    echo "<p>$line</p>";
  }
  echo "かほく市の総数は{$kahoku_count}です.<br> ";
  echo "かほく市のゴミに関する投稿の総数は{$kahoku_count_w1}です。<br>";
  echo "かほく市の人に関する投稿の総数は{$kahoku_count_w2}です。<br >";
  echo "かほく市の環境に関する投稿の総数は{$kahoku_count_w3}です。<br >";
  echo "かほく市のその他の投稿総数は{$kahoku_count_other}です。<br >";

  echo "<b>ゴミに関するコメント：</b><br>";
  echo "{$kahoku_gomi}<br>";
  echo "<b>人に関するコメント：</b><br>";
  echo "{$kahoku_hito}<br>";
  echo "<b>環境に関するコメント：</b><br>";
  echo "{$kahoku_kankyou}<br>";
  echo "<b>その他に関するコメント：</b><br>";
  echo "{$kahoku_other}<br>";

  $file_path = '../png/kahoku_graph.png';
  if (file_exists($file_path)) {
    echo '<img src="' . $file_path . '" alt="Pythonで作成したPNGファイル">';
  } else {
    echo "グラフ作成できるほどのデータがありません";
  }
  ?>
</body>
</html>