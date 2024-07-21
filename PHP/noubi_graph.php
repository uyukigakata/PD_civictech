<!DOCTYPE html>
<html>
<head>
  <title>能美市に関するグラフ</title>
  <link rel="stylesheet" href="../CSS/graph.css" media="all" />
</head>
<body>
  <h1>能美市に関するグラフ</h1>

  <?php
  $file_path = '../TXT/noubi_count.txt';
  if (file_exists($file_path)) {
    @unlink($file_path);
  }
  //能美市の総数
  $file = fopen($file_path, 'a');
  $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');
  $sql_noubi = "SELECT COUNT(*) AS noubi_count FROM civic WHERE choice = '能美市'";
  $result_noubi = $conn->query($sql_noubi);
  $row_noubi = $result_noubi->fetch(PDO::FETCH_ASSOC);
  $noubi_count = $row_noubi['noubi_count'];
  fwrite($file, "$noubi_count\n");

  //能美市+ゴミというワードが含まれている総数
  $sql_noubi_w1 = "SELECT COUNT(*) AS noubi_count FROM civic WHERE choice = '能美市' AND choice2 = 'ゴミ'";
  $result_noubi_w1 = $conn->query($sql_noubi_w1);
  $row_noubi_w1 = $result_noubi_w1->fetch(PDO::FETCH_ASSOC);
  $noubi_count_w1 = $row_noubi_w1['noubi_count'];
  fwrite($file, "$noubi_count_w1\n");

  //能美市+人というワードが含まれている総数
  $sql_noubi_w2 = "SELECT COUNT(*) AS noubi_count FROM civic WHERE choice = '能美市' AND choice2 = '人'";
  $result_noubi_w2 = $conn->query($sql_noubi_w2);
  $row_noubi_w2 = $result_noubi_w2->fetch(PDO::FETCH_ASSOC);
  $noubi_count_w2 = $row_noubi_w2['noubi_count'];
  fwrite($file, "$noubi_count_w2\n");

  //能美市+環境というワードが含まれている総数
  $sql_noubi_w3 = "SELECT COUNT(*) AS noubi_count FROM civic WHERE choice = '能美市' AND choice2 = '環境'";
  $result_noubi_w3 = $conn->query($sql_noubi_w3);
  $row_noubi_w3 = $result_noubi_w3->fetch(PDO::FETCH_ASSOC);
  $noubi_count_w3 = $row_noubi_w3['noubi_count'];
  fwrite($file, "$noubi_count_w3\n");

  //能美市のその他の総数
  $sql_noubi_other = "SELECT COUNT(*) AS noubi_count FROM civic WHERE choice = '能美市' AND choice2 = 'その他'";
  $result_noubi_other = $conn->query($sql_noubi_other);
  $row_noubi_other = $result_noubi_other->fetch(PDO::FETCH_ASSOC);
  $noubi_count_other = $row_noubi_other['noubi_count'];
  fwrite($file, "$noubi_count_other\n");

  
  //能美市の最新のゴミのコメントを検索
  $sql_gomi_comment = "SELECT comment AS gomi_count FROM civic WHERE choice = '能美市' AND choice2 = 'ゴミ' ORDER BY id DESC LIMIT 1";
  $result_gomi = $conn->query($sql_gomi_comment);
  $row_gomi = $result_gomi->fetch(PDO::FETCH_ASSOC);
  if ($row_gomi) {
    $noubi_gomi = $row_gomi['gomi_count'];
  } else {
    $noubi_gomi = "現在投稿されていません";
  }

  //能美市の最新の人のコメントを検索
  $sql_hito_comment = "SELECT comment AS hito_count FROM civic WHERE choice = '能美市' AND choice2 = '人' ORDER BY id DESC LIMIT 1";
  $result_hito = $conn->query($sql_hito_comment);
  $row_hito = $result_hito->fetch(PDO::FETCH_ASSOC);
  if ($row_hito) {
    $noubi_hito = $row_hito['hito_count'];
  } else {
    $noubi_hito = "現在投稿されていません";
  }

   //能美市の最新の環境のコメントを検索
   $sql_kankyou_comment = "SELECT comment AS kankyou_count FROM civic WHERE choice = '能美市' AND choice2 = '環境' ORDER BY id DESC LIMIT 1";
   $result_kankyou = $conn->query($sql_kankyou_comment);
   $row_kankyou = $result_kankyou->fetch(PDO::FETCH_ASSOC);
   if ($row_kankyou) {
     $noubi_kankyou = $row_kankyou['kankyou_count'];
   } else {
     $noubi_kankyou = "現在投稿されていません";
   }

   //能美市の最新のその他のコメントを検索
   $sql_other_comment = "SELECT comment AS other_count FROM civic WHERE choice = '能美市' AND choice2 = 'その他' ORDER BY id DESC LIMIT 1";
   $result_other = $conn->query($sql_other_comment);
   $row_other = $result_other->fetch(PDO::FETCH_ASSOC);
   if ($row_other) {
     $noubi_other = $row_other['other_count'];
   } else {
     $noubi_other = "現在投稿されていません";
   }

  ?>

  <!-- ここでPythonスクリプトを実行する -->

  <?php
  exec('python ../Python/noubi_graph.py', $output);
  foreach ($output as $line) {
    echo "<p>$line</p>";
  }
  echo "能美市の総数は{$noubi_count}です.<br> ";
  echo "能美市のゴミに関する投稿の総数は{$noubi_count_w1}です。<br>";
  echo "能美市の人に関する投稿の総数は{$noubi_count_w2}です。<br >";
  echo "能美市の環境に関する投稿の総数は{$noubi_count_w3}です。<br >";
  echo "能美市のその他の投稿総数は{$noubi_count_other}です。<br >";

  echo "<b>ゴミに関するコメント：</b><br>";
  echo "{$noubi_gomi}<br>";
  echo "<b>人に関するコメント：</b><br>";
  echo "{$noubi_hito}<br>";
  echo "<b>環境に関するコメント：</b><br>";
  echo "{$noubi_kankyou}<br>";
  echo "<b>その他に関するコメント：</b><br>";
  echo "{$noubi_other}<br>";

  $file_path = '../png/noubi_graph.png';
  if (file_exists($file_path)) {
    echo '<img src="' . $file_path . '" alt="Pythonで作成したPNGファイル">';
  } else {
    echo "グラフ作成できるほどのデータがありません";
  }
  ?>
</body>
</html>