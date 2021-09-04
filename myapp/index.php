<?php

// Lesson12_2 課題1 userテーブルから20名表示させる
$dsn = 'mysql:host=db;dbname=sample;port=3306;charset=utf8';
$user = 'phper';
$pass = 'root';

try{
  $dbh = new PDO($dsn,$user,$pass);
  $sql = "SELECT * FROM users limit 20";  //SQLの準備
  $stmt = $dbh->query($sql);  //SQLの実行
  // var_dump($result);
  foreach($stmt as $column){
    echo 'ID:'.$column['id'].' => ユーザーID:'.$column['user_id'];
    echo '<br>';
  }
}catch(PDOException $e){
  echo '接続失敗'. $e->getMessage();
  exit;
};

// Lesson12_2 課題2 SQLを渡して実行し結果を返す関数を作成する
// 引数：id
// 返り値：接続結果を返す
function getResult($id){
  $dsn = 'mysql:host=db;dbname=sample;port=3306;charset=utf8';
  $user = 'phper';
  $pass = 'root';

  try{
    $dbh = new PDO($dsn,$user,$pass);
    $sql = "SELECT * FROM users where id = $id";  //SQLの準備
    $stmt = $dbh->query($sql);  //SQLの実行
    $result = $stmt->fetchall(PDO::FETCH_ASSOC);  //SQLの結果を受け取る
    
    if(empty($result)){
      echo '結果なし';
    }else{
      echo 'IDは'.$id.'です';
    }
  }catch(PDOException $e){
    echo '接続失敗'. $e->getMessage();
    exit;
  };
}

getResult(2);
echo '<br>';
getResult(10);
?>