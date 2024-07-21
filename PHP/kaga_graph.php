<!DOCTYPE html>
<html>
<head>
  <title>加賀市に関するグラフ</title>
  <link rel="stylesheet" href="../CSS/graph.css" media="all" />
</head>
<body>
  <h1>加賀市に関するグラフ</h1>

  <?php
  $file_path = '../TXT/kaga_count.txt';
  if (file_exists($file_path)) {
    @unlink($file_path);
  }
  //加賀市の総数
  $file = fopen($file_path, 'a');
  $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');
  $sql_kaga = "SELECT COUNT(*) AS kaga_count FROM civic WHERE choice = '加賀市'";
  $result_kaga = $conn->query($sql_kaga);
  $row_kaga = $result_kaga->fetch(PDO::FETCH_ASSOC);
  $kaga_count = $row_kaga['kaga_count'];
  fwrite($file, "$kaga_count\n");

  //加賀市+ゴミというワードが含まれている総数
  $sql_kaga_w1 = "SELECT COUNT(*) AS kaga_count FROM civic WHERE choice = '加賀市' AND choice2 = 'ゴミ'";
  $result_kaga_w1 = $conn->query($sql_kaga_w1);
  $row_kaga_w1 = $result_kaga_w1->fetch(PDO::FETCH_ASSOC);
  $kaga_count_w1 = $row_kaga_w1['kaga_count'];
  fwrite($file, "$kaga_count_w1\n");

  //加賀市+人というワードが含まれている総数
  $sql_kaga_w2 = "SELECT COUNT(*) AS kaga_count FROM civic WHERE choice = '加賀市' AND choice2 = '人'";
  $result_kaga_w2 = $conn->query($sql_kaga_w2);
  $row_kaga_w2 = $result_kaga_w2->fetch(PDO::FETCH_ASSOC);
  $kaga_count_w2 = $row_kaga_w2['kaga_count'];
  fwrite($file, "$kaga_count_w2\n");

  //加賀市+環境というワードが含まれている総数
  $sql_kaga_w3 = "SELECT COUNT(*) AS kaga_count FROM civic WHERE choice = '加賀市' AND choice2 = '環境'";
  $result_kaga_w3 = $conn->query($sql_kaga_w3);
  $row_kaga_w3 = $result_kaga_w3->fetch(PDO::FETCH_ASSOC);
  $kaga_count_w3 = $row_kaga_w3['kaga_count'];
  fwrite($file, "$kaga_count_w3\n");

  //加賀市のその他の総数
  $sql_kaga_other = "SELECT COUNT(*) AS kaga_count FROM civic WHERE choice = '加賀市' AND choice2 = 'その他'";
  $result_kaga_other = $conn->query($sql_kaga_other);
  $row_kaga_other = $result_kaga_other->fetch(PDO::FETCH_ASSOC);
  $kaga_count_other = $row_kaga_other['kaga_count'];
  fwrite($file, "$kaga_count_other\n");

  
  //加賀市の最新のゴミのコメントを検索
  $sql_gomi_comment = "SELECT comment AS gomi_count FROM civic WHERE choice = '加賀市' AND choice2 = 'ゴミ' ORDER BY id DESC LIMIT 1";
  $result_gomi = $conn->query($sql_gomi_comment);
  $row_gomi = $result_gomi->fetch(PDO::FETCH_ASSOC);
  if ($row_gomi) {
    $kaga_gomi = $row_gomi['gomi_count'];
  } else {
    $kaga_gomi = "現在投稿されていません";
  }

  //加賀市の最新の人のコメントを検索
  $sql_hito_comment = "SELECT comment AS hito_count FROM civic WHERE choice = '加賀市' AND choice2 = '人' ORDER BY id DESC LIMIT 1";
  $result_hito = $conn->query($sql_hito_comment);
  $row_hito = $result_hito->fetch(PDO::FETCH_ASSOC);
  if ($row_hito) {
    $kaga_hito = $row_hito['hito_count'];
  } else {
    $kaga_hito = "現在投稿されていません";
  }

   //加賀市の最新の環境のコメントを検索
   $sql_kankyou_comment = "SELECT comment AS kankyou_count FROM civic WHERE choice = '加賀市' AND choice2 = '環境' ORDER BY id DESC LIMIT 1";
   $result_kankyou = $conn->query($sql_kankyou_comment);
   $row_kankyou = $result_kankyou->fetch(PDO::FETCH_ASSOC);
   if ($row_kankyou) {
     $kaga_kankyou = $row_kankyou['kankyou_count'];
   } else {
     $kaga_kankyou = "現在投稿されていません";
   }

   //加賀市の最新のその他のコメントを検索
   $sql_other_comment = "SELECT comment AS other_count FROM civic WHERE choice = '加賀市' AND choice2 = 'その他' ORDER BY id DESC LIMIT 1";
   $result_other = $conn->query($sql_other_comment);
   $row_other = $result_other->fetch(PDO::FETCH_ASSOC);
   if ($row_other) {
     $kaga_other = $row_other['other_count'];
   } else {
     $kaga_other = "現在投稿されていません";
   }

  ?>

  <!-- ここでPythonスクリプトを実行する -->

  <?php
  exec('python ../Python/kaga_graph.py', $output);
  foreach ($output as $line) {
    echo "<p>$line</p>";
  }
  echo "加賀市の総数は{$kaga_count}です.<br> ";
  echo "加賀市のゴミに関する投稿の総数は{$kaga_count_w1}です。<br>";
  echo "加賀市の人に関する投稿の総数は{$kaga_count_w2}です。<br >";
  echo "加賀市の環境に関する投稿の総数は{$kaga_count_w3}です。<br >";
  echo "加賀市のその他の投稿総数は{$kaga_count_other}です。<br >";

  echo "<b>ゴミに関するコメント：</b><br>";
  echo "{$kaga_gomi}<br>";
  echo "<b>人に関するコメント：</b><br>";
  echo "{$kaga_hito}<br>";
  echo "<b>環境に関するコメント：</b><br>";
  echo "{$kaga_kankyou}<br>";
  echo "<b>その他に関するコメント：</b><br>";
  echo "{$kaga_other}<br>";

  $file_path = '../png/kaga_graph.png';
  if (file_exists($file_path)) {
    echo '<img src="' . $file_path . '" alt="Pythonで作成したPNGファイル">';
  } else {
    echo "グラフ作成できるほどのデータがありません";
  }
  ?>
</body>
</html>