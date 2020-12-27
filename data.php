<?php
session_start();
$shopname = $_POST['name'];
$area = $_POST['area'];
$evaluation = $_POST['evaluation'];
$category = $_POST['category'];
$freetext = $_POST['freetext'];
$userid = $_SESSION["uid"];

//map用（YOLPローカルサーチAPI)
$baseurl = 'https://map.yahooapis.jp/search/local/V1/localSearch';
$appid = "?appid=";
$query = "&query=" . $shopname;
$output = "&output=json";

//住所コード
$prefectures = array("01" => "北海道", "02" => "青森", "03" => "岩手", "04" => "宮城", "05" => "秋田", "06" => "山形", "07" => "福島", "08" => "茨城", "09" => "栃木", "10" => "群馬", "11" => "埼玉", "12" => "千葉", "13" => "東京", "14" => "神奈川", "15" => "新潟", "16" => "富山", "17" => "石川", "18" => "福井", "19" => "山梨", "20" => "長野", "21" => "岐阜", "22" => "静岡", "23" => "愛知", "24" => "三重", "25" => "滋賀", "26" => "京都", "27" => "大阪", "28" => "兵庫", "29" => "奈良", "30" => "和歌山", "31" => "鳥取", "32" => "島根", "33" => "岡山", "34" => "広島", "35" => "山口", "36" => "徳島", "37" => "香川", "38" => "愛媛", "39" => "高知", "40" => "福岡", "41" => "佐賀", "42" => "長崎", "43" => "熊本", "44" => "大分", "45" => "宮崎", "46" => "鹿児島", "47" => "沖縄");
//入力された都道府県から都道府県コード取得
$pref_codes = array_search($area, $prefectures);
$ac = "&ac=" . $pref_codes;

//リクエスト用URL
$request_url = $baseurl . $appid . $query . $ac . $output;

$json = file_get_contents($request_url);
$json = json_decode($json, JSON_UNESCAPED_UNICODE);
// var_dump($json['Feature']);
// exit();

foreach ($json['Feature'] as $item) {
    $position = $item['Geometry']['Coordinates'];
    $pnumber = $item['Property']['Tel1'];
    $stationname = $item['Property']['Station'][0]['Name'] . '駅';
    $name = $item['Name'];
}
// var_dump($address);
// // var_dump($pnumber);
// // var_dump($stationname);
// // var_dump($name);
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

$sql = 'INSERT INTO content_table(id,userid,shopname,area,pnumber,station,position,evaluation,category,freetext,getday) VALUES(NULL,:userid,:shopname,:area,:pnumber,:stationname,:position,:evaluation,:category,:freetext,sysdate())';
$stmt = $pdo->prepare($sql);
//バインド変数設定
$stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
$stmt->bindValue(':shopname', $shopname, PDO::PARAM_STR);
$stmt->bindValue(':area', $area, PDO::PARAM_STR);
$stmt->bindValue(':pnumber', $pnumber, PDO::PARAM_STR);
$stmt->bindValue(':stationname', $stationname, PDO::PARAM_STR);
$stmt->bindValue(':position', $position, PDO::PARAM_STR);
$stmt->bindValue(':evaluation', $evaluation, PDO::PARAM_STR);
$stmt->bindValue(':category', $category, PDO::PARAM_STR);
$stmt->bindValue(':freetext', $freetext, PDO::PARAM_STR);
//SQL実行
$status = $stmt->execute();

exit();
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
// データ表示
$immediately_result = $stmt->fetchAll(PDO::PARAM_STR);
//JSON形式でmain.jsに受け渡し
$immediately_json_read_data = json_encode($immediately_result, JSON_UNESCAPED_UNICODE);
echo ($immediately_json_read_data);
}
?>