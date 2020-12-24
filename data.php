<?php
$shopname = $_POST['name'];
$area = $_POST['area'];
$pnumber = $_POST['pnumber'];
$evaluation = $_POST['evaluation'];
$category = $_POST['category'];
$freetext = $_POST['freetext'];

// $result = [$name, $area, $pnumber, $evaluation, $category, $freetext];

// echo $result;
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

$sql = 'INSERT INTO content_table(id,shopname,area,pnumber,evaluation,category,freetext,getday) VALUES(NULL,:shopname,:area,:pnumber,:evaluation,:category,:freetext,sysdate())';
$stmt = $pdo->prepare($sql);
//バインド変数設定
$stmt->bindValue(':shopname', $shopname, PDO::PARAM_STR);
$stmt->bindValue(':area', $area, PDO::PARAM_STR);
$stmt->bindValue(':pnumber', $pnumber, PDO::PARAM_STR);
$stmt->bindValue(':evaluation', $evaluation, PDO::PARAM_STR);
$stmt->bindValue(':category', $category, PDO::PARAM_STR);
$stmt->bindValue(':freetext', $freetext, PDO::PARAM_STR);
//SQL実行
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    // データ登録失敗次にエラーを表示
    exit('sqlError:' . $error[2]);
} else {
    //データ取得
    $sql = 'SELECT * FROM content_table';
    $stmt = $pdo->prepare($sql);
    //SQL実行
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    } else {
        // データ表示
        $immediately_result = $stmt->fetchAll(PDO::PARAM_STR);
        //JSON形式でmain.jsに受け渡し
        $immediately_json_read_data = json_encode($immediately_result, JSON_UNESCAPED_UNICODE);
        echo ($immediately_json_read_data);
    }
}

?>
