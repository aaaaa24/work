<?php
//Lesson12_3_2 作成したテーブルにレコードを追加する
$file = file_get_contents('sample.json');
$data = json_decode($file,true);

//データベース接続準備
$dsn = 'mysql:host=db;dbname=sample;port=3306;charset=utf8';
$user = 'phper';
$pass = 'root';

//地方ごとに取り出す
$state1 = array_slice($data[0],0,1); //北海道地方
$state2 = array_slice($data[0],1,6); //東北地方
$state3 = array_slice($data[0],7,7); //関東地方
$state4 = array_slice($data[0],14,9); //中部地方
$state5 = array_slice($data[0],23,7); //関西地方
$state6 = array_slice($data[0],30,5); //中国地方
$state7 = array_slice($data[0],35,4); //四国地方
$state8 = array_slice($data[0],39,8); //九州地方
$allStates = [$state1,$state2,$state3,$state4,$state5,$state6,$state7,$state8];
$states_name = ['北海道地方','東北地方','関東地方','中部地方','関西地方','中国地方','四国地方','九州地方'];

$large_area = [];
$prefeture = [];
$city = [];

$num = 0;
// var_dump($allStates);  //各地方名


//large_areaテーブルにレコードを挿入
foreach($allStates as $key => $val){ 
  $m = $val;
  // var_dump($m);
  foreach($m as $key_1 => $val_1){
    $name = $val_1['name']; //prefecture_name
    $id = $val_1['id'];//prefecture_id
    $large_area[] = [
      $states_name[$num],
      $name,
      $id
    ];
  }
  $num++;
}
//地方ごとに表示する
// echo "<pre>";
// var_dump($large_area);
// echo "</pre>";

//PDOインスタンスを使ってデータベースに接続する
try {
  $dbh = new PDO(
    $dsn,
    $user,
    $pass,
    [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //フェッチモード変える
    ]);
  $sql_l = "SELECT * FROM large_area";
  $stmt_l = $dbh->query($sql_l);
  $result = $stmt_l->fetch();
  if(empty($result)){
    foreach($large_area as $key_2 => $val_2) {
      $sql = "INSERT INTO large_area (name,prefecture_name,prefecture_id) VALUES (:name,:prefecture_name,:prefecture_id)";
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':name',$val_2[0],PDO::PARAM_STR);
      $stmt->bindValue(':prefecture_name',$val_2[1],PDO::PARAM_STR);
      $stmt->bindValue(':prefecture_id',$val_2[2],PDO::PARAM_STR);
      $stmt->execute();
    }
  }
  echo 'INSERTできました';
} catch (PDOException $e) {
  echo 'データベースに接続できません' . $e->getMessage();
  exit;
}

//prefectureテーブルにレコードを挿入
foreach($allStates as $key_3 => $val_3){
  $p = $val_3;
  foreach($p as $key_4 => $val_4){
    $prefecture[] = [$val_4['id'],$val_4['name']]; //2つのカラムを格納
  }
}
//県ごとに表示する
// echo "<pre>";
// var_dump($prefecture);
// echo "</pre>";

try {
  $dbh = new PDO(
    $dsn,
    $user,
    $pass,
    [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //フェッチモード変える
    ]);
  foreach($prefecture as $key_5 => $val_5){
    $sql = "INSERT INTO prefecture (prefecture_id,name) VALUES (:prefecture_id,:name)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':prefecture_id',$val_5[0],PDO::PARAM_STR);
    $stmt->bindValue(':name',$val_5[1],PDO::PARAM_STR);
    $stmt->execute();
  }
  echo 'INSERTできました';
} catch (PDOException $e) {
  echo 'データベースに接続できません' . $e->getMessage();
  exit;
}

//cityテーブルにレコードを挿入
foreach($allStates as $key_6 => $val_6){
  $c = $val_6;
  foreach($c as $key_7 => $val_7){
    // echo "<pre>";
    // var_dump($val_7);
    // echo "</pre>";
    $cc = $val_7['city'];
    // echo "<pre>";
    // var_dump($cc);
    // echo "</pre>";
    foreach($cc as $key_8 => $val_8){
      $city[] = [$val_8['city'],$val_8['citycode']];//2つのカラムを格納
      // echo "<pre>";
      // var_dump($city);
      // echo "</pre>";
    }
  }
}

try {
  $dbh = new PDO(
    $dsn,
    $user,
    $pass,
    [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //フェッチモード変える
    ]);
  foreach($city as $key_9 => $val_9){
    $sql = "INSERT INTO city (name,citycode) VALUES (:name,:citycode)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name',$val_9[0],PDO::PARAM_STR);
    $stmt->bindValue(':citycode',$val_9[1],PDO::PARAM_STR);
    $stmt->execute();
  }
  echo 'INSERTできました';
} catch (PDOException $e) {
  echo 'データベースに接続できません' . $e->getMessage();
  exit;
}

//Lesson12_3_3 地方ごとの県を表示する
try {
  $dbh = new PDO(
    $dsn,
    $user,
    $pass,
    [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //フェッチモード変える
    ]);
    $sql = "SELECT name,prefecture_name FROM large_area ORDER BY name";
    $stmt = $dbh->query($sql);//値が変動しないのでquery
    $stmt->execute();
    $pref = $stmt->fetchAll();
  echo '表示できています';
} catch (PDOException $e) {
  echo 'データベースに接続できません' . $e->getMessage();
  exit;
}

//Lesson12_3_4 県ごとの区の数を表示する