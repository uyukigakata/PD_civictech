<!DOCTYPE html>
<html>
<head>
  <title>輪島市に関するグラフ</title>
  <link rel="stylesheet" href="../CSS/graph.css" media="all" />
</head>
<body>
  <h1>輪島市に関するグラフ</h1>

  <?php
  $file_path = '../TXT/wajima_count.txt';
  if (file_exists($file_path)) {
    @unlink($file_path);
  }
  //輪島市の総数
  $file = fopen($file_path, 'a');
  $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');
  $sql_wajima = "SELECT COUNT(*) AS wajima_count FROM civic WHERE choice = '輪島市'";
  $result_wajima = $conn->query($sql_wajima);
  $row_wajima = $result_wajima->fetch(PDO::FETCH_ASSOC);
  $wajima_count = $row_wajima['wajima_count'];
  fwrite($file, "$wajima_count\n");

  //輪島市+ゴミというワードが含まれている総数
  $sql_wajima_w1 = "SELECT COUNT(*) AS wajima_count FROM civic WHERE choice = '輪島市' AND choice2 = 'ゴミ'";
  $result_wajima_w1 = $conn->query($sql_wajima_w1);
  $row_wajima_w1 = $result_wajima_w1->fetch(PDO::FETCH_ASSOC);
  $wajima_count_w1 = $row_wajima_w1['wajima_count'];
  fwrite($file, "$wajima_count_w1\n");

  //輪島市+人というワードが含まれている総数
  $sql_wajima_w2 = "SELECT COUNT(*) AS wajima_count FROM civic WHERE choice = '輪島市' AND choice2 = '人'";
  $result_wajima_w2 = $conn->query($sql_wajima_w2);
  $row_wajima_w2 = $result_wajima_w2->fetch(PDO::FETCH_ASSOC);
  $wajima_count_w2 = $row_wajima_w2['wajima_count'];
  fwrite($file, "$wajima_count_w2\n");

  //輪島市+環境というワードが含まれている総数
  $sql_wajima_w3 = "SELECT COUNT(*) AS wajima_count FROM civic WHERE choice = '輪島市' AND choice2 = '環境'";
  $result_wajima_w3 = $conn->query($sql_wajima_w3);
  $row_wajima_w3 = $result_wajima_w3->fetch(PDO::FETCH_ASSOC);
  $wajima_count_w3 = $row_wajima_w3['wajima_count'];
  fwrite($file, "$wajima_count_w3\n");

  //輪島市のその他の総数
  $sql_wajima_other = "SELECT COUNT(*) AS wajima_count FROM civic WHERE choice = '輪島市' AND choice2 = 'その他'";
  $result_wajima_other = $conn->query($sql_wajima_other);
  $row_wajima_other = $result_wajima_other->fetch(PDO::FETCH_ASSOC);
  $wajima_count_other = $row_wajima_other['wajima_count'];
  fwrite($file, "$wajima_count_other\n");

  
  //輪島市の最新のゴミのコメントを検索
  $sql_gomi_comment = "SELECT comment AS gomi_count FROM civic WHERE choice = '輪島市' AND choice2 = 'ゴミ' ORDER BY id DESC LIMIT 1";
  $result_gomi = $conn->query($sql_gomi_comment);
  $row_gomi = $result_gomi->fetch(PDO::FETCH_ASSOC);
  if ($row_gomi) {
    $wajima_gomi = $row_gomi['gomi_count'];
  } else {
    $wajima_gomi = "現在投稿されていません";
  }

  //輪島市の最新の人のコメントを検索
  $sql_hito_comment = "SELECT comment AS hito_count FROM civic WHERE choice = '輪島市' AND choice2 = '人' ORDER BY id DESC LIMIT 1";
  $result_hito = $conn->query($sql_hito_comment);
  $row_hito = $result_hito->fetch(PDO::FETCH_ASSOC);
  if ($row_hito) {
    $wajima_hito = $row_hito['hito_count'];
  } else {
    $wajima_hito = "現在投稿されていません";
  }

   //輪島市の最新の環境のコメントを検索
   $sql_kankyou_comment = "SELECT comment AS kankyou_count FROM civic WHERE choice = '輪島市' AND choice2 = '環境' ORDER BY id DESC LIMIT 1";
   $result_kankyou = $conn->query($sql_kankyou_comment);
   $row_kankyou = $result_kankyou->fetch(PDO::FETCH_ASSOC);
   if ($row_kankyou) {
     $wajima_kankyou = $row_kankyou['kankyou_count'];
   } else {
     $wajima_kankyou = "現在投稿されていません";
   }

   //輪島市の最新のその他のコメントを検索
   $sql_other_comment = "SELECT comment AS other_count FROM civic WHERE choice = '輪島市' AND choice2 = 'その他' ORDER BY id DESC LIMIT 1";
   $result_other = $conn->query($sql_other_comment);
   $row_other = $result_other->fetch(PDO::FETCH_ASSOC);
   if ($row_other) {
     $wajima_other = $row_other['other_count'];
   } else {
     $wajima_other = "現在投稿されていません";
   }

  ?>

  <!-- ここでPythonスクリプトを実行する -->

  <?php
  exec('python ../Python/wajima_graph.py', $output);
  foreach ($output as $line) {
    echo "<p>$line</p>";
  }
  echo "輪島市の総数は{$wajima_count}です.<br> ";
  echo "輪島市のゴミに関する投稿の総数は{$wajima_count_w1}です。<br>";
  echo "輪島市の人に関する投稿の総数は{$wajima_count_w2}です。<br >";
  echo "輪島市の環境に関する投稿の総数は{$wajima_count_w3}です。<br >";
  echo "輪島市のその他の投稿総数は{$wajima_count_other}です。<br >";

  echo "<b>ゴミに関するコメント：</b><br>";
  echo "{$wajima_gomi}<br>";
  echo "<b>人に関するコメント：</b><br>";
  echo "{$wajima_hito}<br>";
  echo "<b>環境に関するコメント：</b><br>";
  echo "{$wajima_kankyou}<br>";
  echo "<b>その他に関するコメント：</b><br>";
  echo "{$wajima_other}<br>";

  $file_path = '../png/wajima_graph.png';
  if (file_exists($file_path)) {
    echo '<img src="' . $file_path . '" alt="Pythonで作成したPNGファイル">';
  } else {
    echo "グラフ作成できるほどのデータがありません";
  }
  ?>
</body>
</html>