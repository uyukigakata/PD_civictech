<!DOCTYPE html>
<html>
<head>
  <title>七尾市に関するグラフ</title>
  <link rel="stylesheet" href="../CSS/graph.css" media="all" />
</head>
<body>
  <h1>七尾市に関するグラフ</h1>

  <?php
  $file_path = '../TXT/nanao_count.txt';
  if (file_exists($file_path)) {
    @unlink($file_path);
  }
  //七尾市の総数
  $file = fopen($file_path, 'a');
  $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');
  $sql_nanao = "SELECT COUNT(*) AS nanao_count FROM civic WHERE choice = '七尾市'";
  $result_nanao = $conn->query($sql_nanao);
  $row_nanao = $result_nanao->fetch(PDO::FETCH_ASSOC);
  $nanao_count = $row_nanao['nanao_count'];
  fwrite($file, "$nanao_count\n");

  //七尾市+ゴミというワードが含まれている総数
  $sql_nanao_w1 = "SELECT COUNT(*) AS nanao_count FROM civic WHERE choice = '七尾市' AND choice2 = 'ゴミ'";
  $result_nanao_w1 = $conn->query($sql_nanao_w1);
  $row_nanao_w1 = $result_nanao_w1->fetch(PDO::FETCH_ASSOC);
  $nanao_count_w1 = $row_nanao_w1['nanao_count'];
  fwrite($file, "$nanao_count_w1\n");

  //七尾市+人というワードが含まれている総数
  $sql_nanao_w2 = "SELECT COUNT(*) AS nanao_count FROM civic WHERE choice = '七尾市' AND choice2 = '人'";
  $result_nanao_w2 = $conn->query($sql_nanao_w2);
  $row_nanao_w2 = $result_nanao_w2->fetch(PDO::FETCH_ASSOC);
  $nanao_count_w2 = $row_nanao_w2['nanao_count'];
  fwrite($file, "$nanao_count_w2\n");

  //七尾市+環境というワードが含まれている総数
  $sql_nanao_w3 = "SELECT COUNT(*) AS nanao_count FROM civic WHERE choice = '七尾市' AND choice2 = '環境'";
  $result_nanao_w3 = $conn->query($sql_nanao_w3);
  $row_nanao_w3 = $result_nanao_w3->fetch(PDO::FETCH_ASSOC);
  $nanao_count_w3 = $row_nanao_w3['nanao_count'];
  fwrite($file, "$nanao_count_w3\n");

  //七尾市のその他の総数
  $sql_nanao_other = "SELECT COUNT(*) AS nanao_count FROM civic WHERE choice = '七尾市' AND choice2 = 'その他'";
  $result_nanao_other = $conn->query($sql_nanao_other);
  $row_nanao_other = $result_nanao_other->fetch(PDO::FETCH_ASSOC);
  $nanao_count_other = $row_nanao_other['nanao_count'];
  fwrite($file, "$nanao_count_other\n");

  
  //七尾市の最新のゴミのコメントを検索
  $sql_gomi_comment = "SELECT comment AS gomi_count FROM civic WHERE choice = '七尾市' AND choice2 = 'ゴミ' ORDER BY id DESC LIMIT 1";
  $result_gomi = $conn->query($sql_gomi_comment);
  $row_gomi = $result_gomi->fetch(PDO::FETCH_ASSOC);
  if ($row_gomi) {
    $nanao_gomi = $row_gomi['gomi_count'];
  } else {
    $nanao_gomi = "現在投稿されていません";
  }

  //七尾市の最新の人のコメントを検索
  $sql_hito_comment = "SELECT comment AS hito_count FROM civic WHERE choice = '七尾市' AND choice2 = '人' ORDER BY id DESC LIMIT 1";
  $result_hito = $conn->query($sql_hito_comment);
  $row_hito = $result_hito->fetch(PDO::FETCH_ASSOC);
  if ($row_hito) {
    $nanao_hito = $row_hito['hito_count'];
  } else {
    $nanao_hito = "現在投稿されていません";
  }

   //七尾市の最新の環境のコメントを検索
   $sql_kankyou_comment = "SELECT comment AS kankyou_count FROM civic WHERE choice = '七尾市' AND choice2 = '環境' ORDER BY id DESC LIMIT 1";
   $result_kankyou = $conn->query($sql_kankyou_comment);
   $row_kankyou = $result_kankyou->fetch(PDO::FETCH_ASSOC);
   if ($row_kankyou) {
     $nanao_kankyou = $row_kankyou['kankyou_count'];
   } else {
     $nanao_kankyou = "現在投稿されていません";
   }

   //七尾市の最新のその他のコメントを検索
   $sql_other_comment = "SELECT comment AS other_count FROM civic WHERE choice = '七尾市' AND choice2 = 'その他' ORDER BY id DESC LIMIT 1";
   $result_other = $conn->query($sql_other_comment);
   $row_other = $result_other->fetch(PDO::FETCH_ASSOC);
   if ($row_other) {
     $nanao_other = $row_other['other_count'];
   } else {
     $nanao_other = "現在投稿されていません";
   }

  ?>

  <!-- ここでPythonスクリプトを実行する -->

  <?php
  exec('python ../Python/nanao_graph.py', $output);
  foreach ($output as $line) {
    echo "<p>$line</p>";
  }
  echo "七尾市の総数は{$nanao_count}です.<br> ";
  echo "七尾市のゴミに関する投稿の総数は{$nanao_count_w1}です。<br>";
  echo "七尾市の人に関する投稿の総数は{$nanao_count_w2}です。<br >";
  echo "七尾市の環境に関する投稿の総数は{$nanao_count_w3}です。<br >";
  echo "七尾市のその他の投稿総数は{$nanao_count_other}です。<br >";

  echo "<b>ゴミに関するコメント：</b><br>";
  echo "{$nanao_gomi}<br>";
  echo "<b>人に関するコメント：</b><br>";
  echo "{$nanao_hito}<br>";
  echo "<b>環境に関するコメント：</b><br>";
  echo "{$nanao_kankyou}<br>";
  echo "<b>その他に関するコメント：</b><br>";
  echo "{$nanao_other}<br>";

  $file_path = '../png/nanao_graph.png';
  if (file_exists($file_path)) {
    echo '<img src="' . $file_path . '" alt="Pythonで作成したPNGファイル">';
  } else {
    echo "グラフ作成できるほどのデータがありません";
  }
  ?>
</body>
</html>