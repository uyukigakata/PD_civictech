<!DOCTYPE html>
<html>
<head>
  <title>金沢市に関するグラフ</title>
  <link rel="stylesheet" href="../CSS/graph.css" media="all" />
</head>
<body>
  <h1>金沢市に関するグラフ</h1>

  <?php
  $file_path = '../TXT/kanazawa_count.txt';
  if (file_exists($file_path)) {
    @unlink($file_path);
  }
  //金沢市の総数
  $file = fopen($file_path, 'a');
  $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');
  $sql_kanazawa = "SELECT COUNT(*) AS kanazawa_count FROM civic WHERE choice = '金沢市'";
  $result_kanazawa = $conn->query($sql_kanazawa);
  $row_kanazawa = $result_kanazawa->fetch(PDO::FETCH_ASSOC);
  $kanazawa_count = $row_kanazawa['kanazawa_count'];
  fwrite($file, "$kanazawa_count\n");

  //金沢市+ゴミというワードが含まれている総数
  $sql_kanazawa_w1 = "SELECT COUNT(*) AS kanazawa_count FROM civic WHERE choice = '金沢市' AND choice2 = 'ゴミ'";
  $result_kanazawa_w1 = $conn->query($sql_kanazawa_w1);
  $row_kanazawa_w1 = $result_kanazawa_w1->fetch(PDO::FETCH_ASSOC);
  $kanazawa_count_w1 = $row_kanazawa_w1['kanazawa_count'];
  fwrite($file, "$kanazawa_count_w1\n");

  //金沢市+人というワードが含まれている総数
  $sql_kanazawa_w2 = "SELECT COUNT(*) AS kanazawa_count FROM civic WHERE choice = '金沢市' AND choice2 = '人'";
  $result_kanazawa_w2 = $conn->query($sql_kanazawa_w2);  $row_kanazawa_w2 = $result_kanazawa_w2->fetch(PDO::FETCH_ASSOC);
  $kanazawa_count_w2 = $row_kanazawa_w2['kanazawa_count'];
  fwrite($file, "$kanazawa_count_w2\n");

  //金沢市+環境というワードが含まれている総数
  $sql_kanazawa_w3 = "SELECT COUNT(*) AS kanazawa_count FROM civic WHERE choice = '金沢市' AND choice2 = '環境'";
  $result_kanazawa_w3 = $conn->query($sql_kanazawa_w3);
  $row_kanazawa_w3 = $result_kanazawa_w3->fetch(PDO::FETCH_ASSOC);
  $kanazawa_count_w3 = $row_kanazawa_w3['kanazawa_count'];
  fwrite($file, "$kanazawa_count_w3\n");

  //金沢市のその他の総数
  $sql_kanazawa_other = "SELECT COUNT(*) AS kanazawa_count FROM civic WHERE choice = '金沢市' AND choice2 = 'その他'";
  $result_kanazawa_other = $conn->query($sql_kanazawa_other);
  $row_kanazawa_other = $result_kanazawa_other->fetch(PDO::FETCH_ASSOC);
  $kanazawa_count_other = $row_kanazawa_other['kanazawa_count'];
  fwrite($file, "$kanazawa_count_other\n");

  
  //金沢市の最新のゴミのコメントを検索
  $sql_gomi_comment = "SELECT comment AS gomi_count FROM civic WHERE choice = '金沢市' AND choice2 = 'ゴミ' ORDER BY id DESC LIMIT 1";
  $result_gomi = $conn->query($sql_gomi_comment);
  $row_gomi = $result_gomi->fetch(PDO::FETCH_ASSOC);
  if ($row_gomi) {
    $kanazawa_gomi = $row_gomi['gomi_count'];
  } else {
    $kanazawa_gomi = "現在投稿されていません";
  }

  //金沢市の最新の人のコメントを検索
  $sql_hito_comment = "SELECT comment AS hito_count FROM civic WHERE choice = '金沢市' AND choice2 = '人' ORDER BY id DESC LIMIT 1";
  $result_hito = $conn->query($sql_hito_comment);
  $row_hito = $result_hito->fetch(PDO::FETCH_ASSOC);
  if ($row_hito) {
    $kanazawa_hito = $row_hito['hito_count'];
  } else {
    $kanazawa_hito = "現在投稿されていません";
  }

   //金沢市の最新の環境のコメントを検索
   $sql_kankyou_comment = "SELECT comment AS kankyou_count FROM civic WHERE choice = '金沢市' AND choice2 = '環境' ORDER BY id DESC LIMIT 1";
   $result_kankyou = $conn->query($sql_kankyou_comment);
   $row_kankyou = $result_kankyou->fetch(PDO::FETCH_ASSOC);
   if ($row_kankyou) {
     $kanazawa_kankyou = $row_kankyou['kankyou_count'];
   } else {
     $kanazawa_kankyou = "現在投稿されていません";
   }

   //金沢市の最新のその他のコメントを検索
   $sql_other_comment = "SELECT comment AS other_count FROM civic WHERE choice = '金沢市' AND choice2 = 'その他' ORDER BY id DESC LIMIT 1";
   $result_other = $conn->query($sql_other_comment);
   $row_other = $result_other->fetch(PDO::FETCH_ASSOC);
   if ($row_other) {
     $kanazawa_other = $row_other['other_count'];
   } else {
     $kanazawa_other = "現在投稿されていません";
   }
  ?>

  <!-- ここでPythonスクリプトを実行する -->

  <?php
  exec('python ../Python/kanazawa_graph.py', $output);
  foreach ($output as $line) {
    echo "<p>$line</p>";
  }
  echo "金沢市の総数は{$kanazawa_count}です.<br> ";
  echo "金沢市のゴミに関する投稿の総数は{$kanazawa_count_w1}です。<br>";
  echo "金沢市の人に関する投稿の総数は{$kanazawa_count_w2}です。<br >";
  echo "金沢市の環境に関する投稿の総数は{$kanazawa_count_w3}です。<br >";
  echo "金沢市のその他の投稿総数は{$kanazawa_count_other}です。<br >";

  echo "<b>ゴミに関するコメント：</b><br>";
  echo "{$kanazawa_gomi}<br>";
  echo "<b>人に関するコメント：</b><br>";
  echo "{$kanazawa_hito}<br>";
  echo "<b>環境に関するコメント：</b><br>";
  echo "{$kanazawa_kankyou}<br>";
  echo "<b>その他に関するコメント：</b><br>";
  echo "{$kanazawa_other}<br>";

  $file_path = '../png/kanazawa_graph.png';
  if (file_exists($file_path)) {
    echo '<img src="' . $file_path . '" alt="Pythonで作成したPNGファイル">';
  } else {
    echo "グラフ作成できるほどのデータがありません";
  }
  ?>
</body>
</html>