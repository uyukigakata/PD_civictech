<!DOCTYPE html>
<html>
<head>
  <title>野々市市に関するグラフ</title>
  <link rel="stylesheet" href="../CSS/graph.css" media="all" />
</head>
<body>
  <h1>野々市市に関するグラフ</h1>

  <?php
  $file_path = '../TXT/nonoichi_count.txt';
  if (file_exists($file_path)) {
    @unlink($file_path);
  }
  //野々市市の総数
  $file = fopen($file_path, 'a');
  $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');
  $sql_nonoichi = "SELECT COUNT(*) AS nonoichi_count FROM civic WHERE choice = '野々市市'";
  $result_nonoichi = $conn->query($sql_nonoichi);
  $row_nonoichi = $result_nonoichi->fetch(PDO::FETCH_ASSOC);
  $nonoichi_count = $row_nonoichi['nonoichi_count'];
  fwrite($file, "$nonoichi_count\n");

  //野々市市+ゴミというワードが含まれている総数
  $sql_nonoichi_w1 = "SELECT COUNT(*) AS nonoichi_count FROM civic WHERE choice = '野々市市' AND choice2 = 'ゴミ'";
  $result_nonoichi_w1 = $conn->query($sql_nonoichi_w1);
  $row_nonoichi_w1 = $result_nonoichi_w1->fetch(PDO::FETCH_ASSOC);
  $nonoichi_count_w1 = $row_nonoichi_w1['nonoichi_count'];
  fwrite($file, "$nonoichi_count_w1\n");

  //野々市市+人というワードが含まれている総数
  $sql_nonoichi_w2 = "SELECT COUNT(*) AS nonoichi_count FROM civic WHERE choice = '野々市市' AND choice2 = '人'";
  $result_nonoichi_w2 = $conn->query($sql_nonoichi_w2);
  $row_nonoichi_w2 = $result_nonoichi_w2->fetch(PDO::FETCH_ASSOC);
  $nonoichi_count_w2 = $row_nonoichi_w2['nonoichi_count'];
  fwrite($file, "$nonoichi_count_w2\n");

  //野々市市+環境というワードが含まれている総数
  $sql_nonoichi_w3 = "SELECT COUNT(*) AS nonoichi_count FROM civic WHERE choice = '野々市市' AND choice2 = '環境'";
  $result_nonoichi_w3 = $conn->query($sql_nonoichi_w3);
  $row_nonoichi_w3 = $result_nonoichi_w3->fetch(PDO::FETCH_ASSOC);
  $nonoichi_count_w3 = $row_nonoichi_w3['nonoichi_count'];
  fwrite($file, "$nonoichi_count_w3\n");

  //野々市市のその他の総数
  $sql_nonoichi_other = "SELECT COUNT(*) AS nonoichi_count FROM civic WHERE choice = '野々市市' AND choice2 = 'その他'";
  $result_nonoichi_other = $conn->query($sql_nonoichi_other);
  $row_nonoichi_other = $result_nonoichi_other->fetch(PDO::FETCH_ASSOC);
  $nonoichi_count_other = $row_nonoichi_other['nonoichi_count'];
  fwrite($file, "$nonoichi_count_other\n");

  
  //野々市市の最新のゴミのコメントを検索
  $sql_gomi_comment = "SELECT comment AS gomi_count FROM civic WHERE choice = '野々市市' AND choice2 = 'ゴミ' ORDER BY id DESC LIMIT 1";
  $result_gomi = $conn->query($sql_gomi_comment);
  $row_gomi = $result_gomi->fetch(PDO::FETCH_ASSOC);
  if ($row_gomi) {
    $nonoichi_gomi = $row_gomi['gomi_count'];
  } else {
    $nonoichi_gomi = "現在投稿されていません";
  }

  //野々市市の最新の人のコメントを検索
  $sql_hito_comment = "SELECT comment AS hito_count FROM civic WHERE choice = '野々市市' AND choice2 = '人' ORDER BY id DESC LIMIT 1";
  $result_hito = $conn->query($sql_hito_comment);
  $row_hito = $result_hito->fetch(PDO::FETCH_ASSOC);
  if ($row_hito) {
    $nonoichi_hito = $row_hito['hito_count'];
  } else {
    $nonoichi_hito = "現在投稿されていません";
  }

   //野々市市の最新の環境のコメントを検索
   $sql_kankyou_comment = "SELECT comment AS kankyou_count FROM civic WHERE choice = '野々市市' AND choice2 = '環境' ORDER BY id DESC LIMIT 1";
   $result_kankyou = $conn->query($sql_kankyou_comment);
   $row_kankyou = $result_kankyou->fetch(PDO::FETCH_ASSOC);
   if ($row_kankyou) {
     $nonoichi_kankyou = $row_kankyou['kankyou_count'];
   } else {
     $nonoichi_kankyou = "現在投稿されていません";
   }

   //野々市市の最新のその他のコメントを検索
   $sql_other_comment = "SELECT comment AS other_count FROM civic WHERE choice = '野々市市' AND choice2 = 'その他' ORDER BY id DESC LIMIT 1";
   $result_other = $conn->query($sql_other_comment);
   $row_other = $result_other->fetch(PDO::FETCH_ASSOC);
   if ($row_other) {
     $nonoichi_other = $row_other['other_count'];
   } else {
     $nonoichi_other = "現在投稿されていません";
   }

  ?>

  <!-- ここでPythonスクリプトを実行する -->

  <?php
  exec('python ../Python/nonoichi_graph.py', $output);
  foreach ($output as $line) {
    echo "<p>$line</p>";
  }
  echo "野々市市の総数は{$nonoichi_count}です.<br> ";
  echo "野々市市のゴミに関する投稿の総数は{$nonoichi_count_w1}です。<br>";
  echo "野々市市の人に関する投稿の総数は{$nonoichi_count_w2}です。<br >";
  echo "野々市市の環境に関する投稿の総数は{$nonoichi_count_w3}です。<br >";
  echo "野々市市のその他の投稿総数は{$nonoichi_count_other}です。<br >";

  echo "<b>ゴミに関するコメント：</b><br>";
  echo "{$nonoichi_gomi}<br>";
  echo "<b>人に関するコメント：</b><br>";
  echo "{$nonoichi_hito}<br>";
  echo "<b>環境に関するコメント：</b><br>";
  echo "{$nonoichi_kankyou}<br>";
  echo "<b>その他に関するコメント：</b><br>";
  echo "{$nonoichi_other}<br>";

  $file_path = '../png/nonoichi_graph.png';
  if (file_exists($file_path)) {
    echo '<img src="' . $file_path . '" alt="Pythonで作成したPNGファイル">';
  } else {
    echo "グラフ作成できるほどのデータがありません";
  }
  ?>
</body>
</html>