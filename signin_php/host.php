<?php
// CSVファイル読み込み
$file = fopen('data/userdata.csv', 'r');
$user_data_array = array();

flock($file, LOCK_EX);
// 1行ずつCSVを配列に変換して$user_data_arrayに格納。
while ($line = fgetcsv($file)) {
    $user_data_array[] = $line;
}
flock($file, LOCK_UN);
fclose($file);

//年齢、都道府県のデータを取り出し、$ageと$cityに格納
$agedata = array_column($user_data_array, '1');
$city = array_column($user_data_array, '2');
$email = array_column($user_data_array, '3');

//$ageは文字列のため数値に変換
foreach ($agedata as $v) {
    $age[] = (int) $v;
};


$age_range = [];
$city_range = [];
$email_range = [];

for ($i = 0; $i < count($age); $i++) {
    switch ($age[$i]) {
        case 10 <= $age[$i] && $age[$i] < 20:
            $age_range[$i] = '10代';
            break;
        case 20 <= $age[$i] && $age[$i] < 30:
            $age_range[$i] = '20代';
            break;
        case 30 <= $age[$i] && $age[$i] < 40:
            $age_range[$i] = '30代';
            break;
        case 40 <= $age[$i] && $age[$i] < 50:
            $age_range[$i] = '40代';
            break;
        case 50 <= $age[$i] && $age[$i] < 60:
            $age_range[$i] = '50代';
            break;
        case 60 <= $age[$i]:
            $age_range[$i] = '60代以上';
            break;
    }
}
$key10 = count(array_keys($age_range, "10代"));
$key20 = count(array_keys($age_range, "20代"));
$key30 = count(array_keys($age_range, "30代"));
$key40 = count(array_keys($age_range, "40代"));
$key50 = count(array_keys($age_range, "50代"));
$key60 = count(array_keys($age_range, "60代以上"));

// var_dump($key20);
// exit();
// // 作成した配列を出力
// print_r($email);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーデータ一覧</title>
    <style>
        table {
            margin: 0;
        }
    </style>
</head>

<body>
    <h1>ユーザーデータ一覧</h1>
    <table>
        <thead>
            <tr>
                <th>10代</th>
                <td><?= $key10 ?></td>
            </tr>
            <tr>
                <th>20代</th>
                <td><?= $key20 ?></td>
            </tr>
            <tr>
                <th>30代</th>
                <td><?= $key30 ?></td>
            </tr>
            <tr>
                <th>40代</th>
                <td><?= $key40 ?></td>
            </tr>
            <tr>
                <th>50代</th>
                <td><?= $key50 ?></td>
            </tr>
            <tr>
                <th>60代以上</th>
                <td><?= $key60 ?></td>
            </tr>
        </thead>
        <!-- <tbody>
            <tr>

            </tr>
            <tr>

            </tr>
            <tr>

            </tr>
            <tr>

            </tr>
            <tr>

            </tr>
            <tr>

            </tr>
        </tbody> -->
    </table>
</body>

</html>