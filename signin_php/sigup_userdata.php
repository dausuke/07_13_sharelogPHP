<?php
//データ受信
$username = $_POST['name'];
$age = $_POST['age'];
$city = $_POST['city'];
$email = $_POST['email'];
$userpassword = $_POST['password'];

// var_dump($_POST);
// exit();

// DB接続情報
$dbn = 'mysql:dbname=gsacf_d07_13;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
    $pdo = new PDO($dbn, $user, $pwd);
    // exit('ok');
} catch (PDOException $e) {
    //エラー時の処理
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
}

$sql = 'INSERT INTO userdata_table(id,username,age,city,email,userpassword,created_at) VALUES(NULL,:username,:age,:city,:email,:userpassword,sysdate())';
$stmt = $pdo->prepare($sql);
//バインド変数設定
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':age', $age, PDO::PARAM_STR);
$stmt->bindValue(':city', $city, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':userpassword', $userpassword, PDO::PARAM_STR);
//SQL実行
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    // データ登録失敗次にエラーを表示
    exit('sqlError:' . $error[2]);
} else {
    // 登録ページへ移動
    header('Location:../index.php');
}
// //メールアドレスとパスワードをサインイン認証のため連想配列に格納
// $signup_data = array('email' => $email, 'password' => $password);

// //他の情報をユーザー情報管理のため連想配列に格納
// $user_data = array('name' => $name, 'age' =>$age, 'city' => $city, 'email'=>$email);

// //受信したデータをjson形式へエンコード
// $json_sigin_data = json_encode($signup_data);

// // var_dump($createemail);
// // exit();

// //ファイル書き込み（ログイン情報）
// $file_a = fopen('data/sign_in.txt', 'a');
// flock($file_a, LOCK_EX);
// fwrite($file_a, $json_sigin_data . "\r\n");
// flock($file_a, LOCK_UN);
// fclose($file_a);

// //ファイル書き込み（ユーザー情報）
// $file_csv = fopen('data/userdata.csv', 'a');
// flock($file_csv, LOCK_EX);
// fputcsv($file_csv, $user_data );
// flock($file_csv, LOCK_UN);
// fclose($file_csv);


