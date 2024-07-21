<!DOCTYPE html>
<html>
<head>
  <title>白山市に関するグラフ</title>
  <link rel="stylesheet" href="../CSS/graph.css" media="all" />
</head>
<body>
  <h1>白山市に関するグラフ</h1>

  <?php
  $file_path = '../TXT/sirayama_count.txt';
  if (file_exists($file_path)) {
    @unlink($file_path);
  }
  //白山市の総数
  $file = fopen($file_path, 'a');
  $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');
  $sql_sirayama = "SELECT COUNT(*) AS sirayama_count FROM civic WHERE choice = '白山市'";
  $result_sirayama = $conn->query($sql_sirayama);
  $row_sirayama = $result_sirayama->fetch(PDO::FETCH_ASSOC);
  $sirayama_count = $row_sirayama['sirayama_count'];
  fwrite($file, "$sirayama_count\n");

  //白山市+ゴミというワードが含まれている総数
  $sql_sirayama_w1 = "SELECT COUNT(*) AS sirayama_count FROM civic WHERE choice = '白山市' AND choice2 = 'ゴミ'";
  $result_sirayama_w1 = $conn->query($sql_sirayama_w1);
  $row_sirayama_w1 = $result_sirayama_w1->fetch(PDO::FETCH_ASSOC);
  $sirayama_count_w1 = $row_sirayama_w1['sirayama_count'];
  fwrite($file, "$sirayama_count_w1\n");

  //白山市+人というワードが含まれている総数
  $sql_sirayama_w2 = "SELECT COUNT(*) AS sirayama_count FROM civic WHERE choice = '白山市' AND choice2 = '人'";
  $result_sirayama_w2 = $conn->query($sql_sirayama_w2);
  $row_sirayama_w2 = $result_sirayama_w2->fetch(PDO::FETCH_ASSOC);
  $sirayama_count_w2 = $row_sirayama_w2['sirayama_count'];
  fwrite($file, "$sirayama_count_w2\n");

  //白山市+環境というワードが含まれている総数
  $sql_sirayama_w3 = "SELECT COUNT(*) AS sirayama_count FROM civic WHERE choice = '白山市' AND choice2 = '環境'";
  $result_sirayama_w3 = $conn->query($sql_sirayama_w3);
  $row_sirayama_w3 = $result_sirayama_w3->fetch(PDO::FETCH_ASSOC);
  $sirayama_count_w3 = $row_sirayama_w3['sirayama_count'];
  fwrite($file, "$sirayama_count_w3\n");

  //白山市のその他の総数
  $sql_sirayama_other = "SELECT COUNT(*) AS sirayama_count FROM civic WHERE choice = '白山市' AND choice2 = 'その他'";
  $result_sirayama_other = $conn->query($sql_sirayama_other);
  $row_sirayama_other = $result_sirayama_other->fetch(PDO::FETCH_ASSOC);
  $sirayama_count_other = $row_sirayama_other['sirayama_count'];
  fwrite($file, "$sirayama_count_other\n");

  
  //白山市の最新のゴミのコメントを検索
  $sql_gomi_comment = "SELECT comment AS gomi_count FROM civic WHERE choice = '白山市' AND choice2 = 'ゴミ' ORDER BY id DESC LIMIT 1";
  $result_gomi = $conn->query($sql_gomi_comment);
  $row_gomi = $result_gomi->fetch(PDO::FETCH_ASSOC);
  if ($row_gomi) {
    $sirayama_gomi = $row_gomi['gomi_count'];
  } else {
    $sirayama_gomi = "現在投稿されていません";
  }

  //白山市の最新の人のコメントを検索
  $sql_hito_comment = "SELECT comment AS hito_count FROM civic WHERE choice = '白山市' AND choice2 = '人' ORDER BY id DESC LIMIT 1";
  $result_hito = $conn->query($sql_hito_comment);
  $row_hito = $result_hito->fetch(PDO::FETCH_ASSOC);
  if ($row_hito) {
    $sirayama_hito = $row_hito['hito_count'];
  } else {
    $sirayama_hito = "現在投稿されていません";
  }

   //白山市の最新の環境のコメントを検索
   $sql_kankyou_comment = "SELECT comment AS kankyou_count FROM civic WHERE choice = '白山市' AND choice2 = '環境' ORDER BY id DESC LIMIT 1";
   $result_kankyou = $conn->query($sql_kankyou_comment);
   $row_kankyou = $result_kankyou->fetch(PDO::FETCH_ASSOC);
   if ($row_kankyou) {
     $sirayama_kankyou = $row_kankyou['kankyou_count'];
   } else {
     $sirayama_kankyou = "現在投稿されていません";
   }

   //白山市の最新のその他のコメントを検索
   $sql_other_comment = "SELECT comment AS other_count FROM civic WHERE choice = '白山市' AND choice2 = 'その他' ORDER BY id DESC LIMIT 1";
   $result_other = $conn->query($sql_other_comment);
   $row_other = $result_other->fetch(PDO::FETCH_ASSOC);
   if ($row_other) {
     $sirayama_other = $row_other['other_count'];
   } else {
     $sirayama_other = "現在投稿されていません";
   }

  ?>

  <!-- ここでPythonスクリプトを実行する -->

  <?php
  exec('python ../Python/sirayama_graph.py', $output);
  foreach ($output as $line) {
    echo "<p>$line</p>";
  }
  echo "白山市の総数は{$sirayama_count}です.<br> ";
  echo "白山市のゴミに関する投稿の総数は{$sirayama_count_w1}です。<br>";
  echo "白山市の人に関する投稿の総数は{$sirayama_count_w2}です。<br >";
  echo "白山市の環境に関する投稿の総数は{$sirayama_count_w3}です。<br >";
  echo "白山市のその他の投稿総数は{$sirayama_count_other}です。<br >";

  echo "<b>ゴミに関するコメント：</b><br>";
  echo "{$sirayama_gomi}<br>";
  echo "<b>人に関するコメント：</b><br>";
  echo "{$sirayama_hito}<br>";
  echo "<b>環境に関するコメント：</b><br>";
  echo "{$sirayama_kankyou}<br>";
  echo "<b>その他に関するコメント：</b><br>";
  echo "{$sirayama_other}<br>";

  $file_path = '../png/sirayama_graph.png';
  if (file_exists($file_path)) {
    echo '<img src="' . $file_path . '" alt="Pythonで作成したPNGファイル">';
  } else {
    echo "グラフ作成できるほどのデータがありません";
  }
  ?>
</body>
</html>