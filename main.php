<?php
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
//DBからデータ取得
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
    $result = $stmt->fetchAll(PDO::PARAM_STR);
    $json_read_data = json_encode($result, JSON_UNESCAPED_UNICODE);
    // var_dump($json_read_data);
    // exit();
}
?>

<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <title>sharelog</title>
</head>

<body>
    <script src="main.js"></script>
    <header>
        <h1>sharelog</h1>
        <span id="signout">signout</span>
    </header>
    <main>
        <!-- タイムライン -->
        <div class="content active" id="home">
            <!-- <div id="map"></div> -->
            <div id="timeline"></div>
            <ul class="tab">
                <li class="active"><a href="#mypage" class="buttom3d">Mypage</a></li>
                <li><a href="#shopsarch" class="buttom3d">Shop-Sarch</a></li>
                <li><a href="#mymap" class="buttom3d">mymap</a></li>
            </ul>
        </div>
        <!-- マイページ -->
        <div class="content" id="mypage">
            <div id="mypagetimeline"></div>
            <div id="savearea"></div>
            <ul class="tab">
                <li id="savelog" class="buttom3d">SaveLog</li>
                <li><a href="#home" class="buttom3d">home</a></li>
            </ul>
            <div id="sample"></div>
        </div>
        <!-- マップ画面 -->
        <div class="content" id="mymap">
            <ul class="tab">
                <li><a href="#home" class="buttom3d">home</a></li>
            </ul>
            <p>マイマップ</p>
            <div id=map class="map"></div>
        </div>
        <!-- 検索画面 -->
        <div class="content" id="shopsarch">
            <div class="kensakudata">
                <p>リストを検索</p>
                <input type="text" id="search">
                <div class="searchbutton">
                    <button id=searchbutton>検索する</button>
                </div>
            </div>
            <div class="kensakuitem">
                <span>店　　　名<input type="text" id="kname"></span>
                <span>保　存　日<input type="text" id="getday"></span>
                <span>エ　リ　ア<input type="text" id="karea"></span>
                <span>連　絡　先<input type="text" id="kpnumber"></span>
                <span>カテゴリー<input type="text" id="kcategory"></span>
            </div>
            <ul class="tab">
                <li><a href="#home" class="buttom3d">home</a></li>
            </ul>
        </div>
    </main>
    <script>
        const dataArray = <?= $json_read_data ?>;
        console.log(dataArray)
        //ホーム画面：保存されているデータ表示
        for (let i = 0; i < dataArray.length; i++) { //保存しているすべてのデータ表示
            const memoTag = `
            <article class = "timelineitem" id = "timelineitem">
                <header>
                    pp
                </header>
                <div class = "timelinecontent">
                    <p class = "getday" id= "listgetday${i}"></p>
                    <ul>
                        <li>店　　　名：</li>
                        <li>エ　リ　ア：</li>
                        <li>連　絡　先：</li>
                        <li>カテゴリー：</li>
                        <li>評　　　価：</li>
                    </ul>
                    <ul>
                        <li id="listkname${i}"></li>
                        <li id="listkarea${i}"></li>
                        <li id="listpnumber${i}"></li>
                        <li id="listcategory${i}"></li>
                        <li id="listevaluation${i}"></li>
                    </ul>
                    <ul>
                        <li>メモ</li>
                        <li><div id="listfreetext${i}" ></div ></li>
                    </ul>
                </div>
            </article>
                `;
            //#listに.lsititemを追加
            //firebaseに保存したデータを表示
            $('#timeline').append(memoTag);
            $('#listkname' + i).text(dataArray[i].shopname);
            $('#listgetday' + i).text(dataArray[i].getday);
            $('#listkarea' + i).text(dataArray[i].area);
            $('#listcategory' + i).text(dataArray[i].category);
            $('#listpnumber' + i).text(dataArray[i].pnumber);
            $('#listevaluation' + i).text(dataArray[i].evaluation);
            $('#listfreetext' + i).text(dataArray[i].freetext);
        };

        //マイページのタイムライン
        for (let i = 0; i < dataArray.length; i++) { //保存しているすべてのデータ表示
            const memoTag = `
            <article class = "timelineitem" id = "mypagetimelineitem">
                <header>
                    pp
                </header>
                <div class = "timelinecontent">
                    <p class = "getday" id= "mypagelistgetday${i}"></p>
                    <ul>
                        <li>店　　　名：</li>
                        <li>エ　リ　ア：</li>
                        <li>連　絡　先：</li>
                        <li>カテゴリー：</li>
                        <li>評　　　価：</li>
                    </ul>
                    <ul id = "logdata">
                        <li id="mypagelistkname${i}"></li>
                        <li id="mypagelistkarea${i}"></li>
                        <li id="mypagelistpnumber${i}"></li>
                        <li id="mypagelistcategory${i}"></li>
                        <li id="mypagelistevaluation${i}"></li>
                    </ul>
                    <ul>
                        <li>メモ</li>
                        <li><div id="mypagelistfreetext${i}" ></div ></li>
                    </ul>

                </div>
            </article>
                `;
            //#listに.lsititemを追加
            //firebaseに保存したデータを表示
            $('#mypagetimeline').append(memoTag);
            $('#mypagelistkname' + i).text(dataArray[i].shopname);
            $('#mypagelistgetday' + i).text(dataArray[i].getday);
            $('#mypagelistkarea' + i).text(dataArray[i].area);
            $('#mypagelistcategory' + i).text(dataArray[i].category);
            $('#mypagelistpnumber' + i).text(dataArray[i].pnumber);
            $('#mypagelistevaluation' + i).text(dataArray[i].evaluation);
            $('#mypagelistfreetext' + i).text(dataArray[i].freetext);
        };
    </script>
</body>

</html>