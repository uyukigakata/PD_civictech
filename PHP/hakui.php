<!DOCTYPE html>
<html>
<head>
  <title>羽咋市に関するグラフ</title>
  <link rel="stylesheet" href="../CSS/graph.css" media="all" />
</head>
<body>
  <h1>羽咋市に関するグラフ</h1>

  <?php
  $file_path = '../TXT/hakui_count.txt';
  if (file_exists($file_path)) {
    @unlink($file_path);
  }
  
  //羽咋市の総数
  $file = fopen($file_path, 'a');
  $conn = new PDO('mysql:host=localhost;dbname=civictech;charset=utf8','root','');
  $sql_hakui = "SELECT COUNT(*) AS hakui_count FROM civic WHERE choice = '羽咋市'";
  $result_hakui = $conn->query($sql_hakui);
  $row_hakui = $result_hakui->fetch(PDO::FETCH_ASSOC);
  $hakui_count = $row_hakui['hakui_count'];
  fwrite($file, "$hakui_count\n");

  //羽咋市+ゴミというワードが含まれている総数
  $sql_hakui_w1 = "SELECT COUNT(*) AS hakui_count FROM civic WHERE choice = '羽咋市' AND choice2 = 'ゴミ'";
  $result_hakui_w1 = $conn->query($sql_hakui_w1);
  $row_hakui_w1 = $result_hakui_w1->fetch(PDO::FETCH_ASSOC);
  $hakui_count_w1 = $row_hakui_w1['hakui_count'];
  fwrite($file, "$hakui_count_w1\n");

  //羽咋市+人というワードが含まれている総数
  $sql_hakui_w2 = "SELECT COUNT(*) AS hakui_count FROM civic WHERE choice = '羽咋市' AND choice2 = '人'";
  $result_hakui_w2 = $conn->query($sql_hakui_w2);
  $row_hakui_w2 = $result_hakui_w2->fetch(PDO::FETCH_ASSOC);
  $hakui_count_w2 = $row_hakui_w2['hakui_count'];
  fwrite($file, "$hakui_count_w2\n");

  //羽咋市+環境というワードが含まれている総数
  $sql_hakui_w3 = "SELECT COUNT(*) AS hakui_count FROM civic WHERE choice = '羽咋市' AND choice2 = '環境'";
  $result_hakui_w3 = $conn->query($sql_hakui_w3);
  $row_hakui_w3 = $result_hakui_w3->fetch(PDO::FETCH_ASSOC);
  $hakui_count_w3 = $row_hakui_w3['hakui_count'];
  fwrite($file, "$hakui_count_w3\n");

  //羽咋市のその他の総数
  $sql_hakui_other = "SELECT COUNT(*) AS hakui_count FROM civic WHERE choice = '羽咋市' AND choice2 = 'その他'";
  $result_hakui_other = $conn->query($sql_hakui_other);
  $row_hakui_other = $result_hakui_other->fetch(PDO::FETCH_ASSOC);
  $hakui_count_other = $row_hakui_other['hakui_count'];
  fwrite($file, "$hakui_count_other\n");

  
  //羽咋市の最新のゴミのコメントを検索
  $sql_gomi_comment = "SELECT comment AS gomi_count FROM civic WHERE choice = '羽咋市' AND choice = 'ゴミ' ORDER BY id DESC LIMIT 1";
  $result_gomi = $conn->query($sql_gomi_comment);
  $row_gomi = $result_gomi->fetch(PDO::FETCH_ASSOC);
  if ($row_gomi) {
    $hakui_gomi = $row_gomi['gomi_count'];
  } else {
    $hakui_gomi = "現在投稿されていません";
  }

  //羽咋市の最新の人のコメントを検索
  $sql_hito_comment = "SELECT comment AS hito_count FROM civic WHERE choice = '羽咋市' AND choice2 = '人' ORDER BY id DESC LIMIT 1";
  $result_hito = $conn->query($sql_hito_comment);
  $row_hito = $result_hito->fetch(PDO::FETCH_ASSOC);
  if ($row_hito) {
    $hakui_hito = $row_hito['hito_count'];
  } else {
    $hakui_hito = "現在投稿されていません";
  }

   //羽咋市の最新の環境のコメントを検索
   $sql_kankyou_comment = "SELECT comment AS kankyou_count FROM civic WHERE choice = '羽咋市' AND choice2 = '環境' ORDER BY id DESC LIMIT 1";
   $result_kankyou = $conn->query($sql_kankyou_comment);
   $row_kankyou = $result_kankyou->fetch(PDO::FETCH_ASSOC);
   if ($row_kankyou) {
     $hakui_kankyou = $row_kankyou['kankyou_count'];
   } else {
     $hakui_kankyou = "現在投稿されていません";
   }

   //羽咋市の最新のその他のコメントを検索
   $sql_other_comment = "SELECT comment AS other_count FROM civic WHERE choice = '羽咋市' AND choice2 = 'その他' ORDER BY id DESC LIMIT 1";
   $result_other = $conn->query($sql_other_comment);
   $row_other = $result_other->fetch(PDO::FETCH_ASSOC);
   if ($row_other) {
     $hakui_other = $row_other['other_count'];
   } else {
     $hakui_other = "現在投稿されていません";
   }

  ?>

  <!-- ここでPythonスクリプトを実行する -->

  <?php
  exec('python ../Python/hakui_graph.py', $output);
  foreach ($output as $line) {
    echo "<p>$line</p>";
  }
  echo "羽咋市の総数は{$hakui_count}です.<br> ";
  echo "羽咋市のゴミに関する投稿の総数は{$hakui_count_w1}です。<br>";
  echo "羽咋市の人に関する投稿の総数は{$hakui_count_w2}です。<br >";
  echo "羽咋市の環境に関する投稿の総数は{$hakui_count_w3}です。<br >";
  echo "羽咋市のその他の投稿総数は{$hakui_count_other}です。<br >";

  echo "<b>ゴミに関するコメント：</b><br>";
  echo "{$hakui_gomi}<br>";
  echo "<b>人に関するコメント：</b><br>";
  echo "{$hakui_hito}<br>";
  echo "<b>環境に関するコメント：</b><br>";
  echo "{$hakui_kankyou}<br>";
  echo "<b>その他に関するコメント：</b><br>";
  echo "{$hakui_other}<br>";

  $file_path = '../png/hakui_graph.png';
  if (file_exists($file_path)) {
    echo '<img src="' . $file_path . '" alt="Pythonで作成したPNGファイル">';
  } else {
    echo "グラフ作成できるほどのデータがありません";
  }
  ?>
</body>
</html>