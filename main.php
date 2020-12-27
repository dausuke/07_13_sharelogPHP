<?php
session_start();
//ユーザー情報取得
$uid = $_SESSION["uid"];
// var_dump($uid);
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
    // var_dump($result[0]['shopname']);
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
    <script src="https://cdn.geolonia.com/community-geocoder.js"></script>
    <script src='https://www.bing.com/api/maps/mapcontrol?key=_' async defer>
    </script>
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
                <!-- <li><a href="#shopsarch" class="buttom3d">Shop-Sarch</a></li> -->
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
        <!-- 検索画面
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
        </div> -->
    </main>
    <script>
        const dataArray = <?= $json_read_data ?>; //DBのデータ
        console.log(dataArray);
        const read_position = [];
        dataArray.forEach(function(value) {
            const read_positiontag = value.position;
            read_position.push(read_positiontag);
        });
        console.log(read_position);
        const uid = <?= $uid ?>; //ユーザーID
        //現在地の緯度経度取得用の配列
        const latArray = [];
        const lngArray = [];

        //保存した店の緯度経度を格納するための配列
        const tagintArray = [];
        const tagstrArray = [];

        //緯度経度が1つの文字列で返って来てるので「,」で分割し配列tagstrArr配列に格納
        read_position.forEach(function(value) {
            const tagstr = value.split(',');
            tagstrArray.push(tagstr)
        });
        //緯度経度の配列をFloat型に変換
        tagstrArray.forEach(function(value, index) {
            value.forEach(function(latlng) {
                const tagint = parseFloat(latlng)
                tagintArray.push(tagint);
            });
        });
        //配列を分割する関数
        const arrayChunk = ([...array], size = 1) => {
            return array.reduce((acc, value, index) => index % size ? acc : [...acc, array.slice(index, index + size)], []);
        }
        //緯度が格納された配列と経度が格納された配列に2分割
        const posiArraydb = arrayChunk(tagintArray, 2);

        console.log(tagstrArray)
        console.log(posiArraydb)
        const pushpinsinfo = []; //ピンの情報用の配列
        const pushpins = [];

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
                        <li>　最寄り駅：</il>
                        <li>連　絡　先：</li>
                        <li>カテゴリー：</li>
                        <li>評　　　価：</li>
                    </ul>
                    <ul>
                        <li id="listname${i}"></li>
                        <li id="listarea${i}"></li>
                        <li id="liststaition${i}"></li>
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
            //DBに保存した全データを表示
            $('#timeline').append(memoTag);
            $('#listname' + i).text(dataArray[i].shopname);
            $('#listgetday' + i).text(dataArray[i].getday);
            $('#listarea' + i).text(dataArray[i].area);
            $('#liststaition' + i).text(dataArray[i].station);
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
                        <li>　最寄り駅：</il>
                        <li>連　絡　先：</li>
                        <li>カテゴリー：</li>
                        <li>評　　　価：</li>
                    </ul>
                    <ul id = "logdata">
                        <li id="mypagelistname${i}"></li>
                        <li id="mypagelistarea${i}"></li>
                        <li id="mypagestation${i}"></li>
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
            //ログインしているユーザーのidとDBに保存しているuidが一致しているデータを表示
            if (uid == dataArray[i].userid) {
                $('#mypagetimeline').append(memoTag);
                $('#mypagelistname' + i).text(dataArray[i].shopname);
                $('#mypagelistgetday' + i).text(dataArray[i].getday);
                $('#mypagelistarea' + i).text(dataArray[i].area);
                $('#mypagestation' + i).text(dataArray[i].station);
                $('#mypagelistcategory' + i).text(dataArray[i].category);
                $('#mypagelistpnumber' + i).text(dataArray[i].pnumber);
                $('#mypagelistevaluation' + i).text(dataArray[i].evaluation);
                $('#mypagelistfreetext' + i).text(dataArray[i].freetext);
            }
        };
        map表示
        ローカルサーチAPIで取得した住所から座標情報取得
        dataArray.forEach(function(value) {
            const address = value.shopaddress;
            getLatLng(address, function(latlng) {
                const lattag = latlng.lat;
                const lngtag = latlng.lng;
                console.log(latlng)
                latArraydb.push(lattag);
                lngArraydb.push(lngtag);
            });
        });



        //保存されている位置情報のマップピン表示用
        dataArray.forEach(function(value, index) {
            const infotag = {
                id: value.userid,
                latitude: posiArraydb[index][0],
                longitude: posiArraydb[index][1],
                title: value.shopname,
                description: value.freetext
            };
            console.log(posiArraydb[index][0])
            pushpinsinfo.push(infotag);
        });

        //map表示用に使用する変数
        let map;
        console.log(pushpinsinfo)

        function setinfopin() {

            //infoboxは一つ作成して再利用する
            var infobox = new Microsoft.Maps.Infobox(new Microsoft.Maps.Location(0, 0), {
                visible: false,
                autoAlignment: true
            });
            infobox.setMap(map);

            //pushpinの情報を作成
            pushpinsinfo.forEach(function(info) {
                console.log(info)
                if (uid == info.id) {
                    var pushpin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(info.latitude, info.longitude), {
                        color: 'red',
                        visible: 'ture',
                    });
                    pushpin.metadata = info;
                    Microsoft.Maps.Events.addHandler(pushpin, 'click', function(args) {
                        infobox.setOptions({
                            location: args.target.getLocation(),
                            title: args.target.metadata.title,
                            description: args.target.metadata.description,
                            visible: true
                        });
                    });
                    pushpins.push(pushpin);
                }
            });
        };
        // 現在地を取得するときのオプション
        const option = {
            enableHighAccuracy: true,
            maximumAge: 20000,
            timeout: 100000000
        };

        //ピンの生成(現在地)
        function pushPin(lat, lng, map) {
            const location = new Microsoft.Maps.Location(lat, lng);
            const pin = new Microsoft.Maps.Pushpin(location, {
                color: 'navy',
                visible: 'ture',
            });
            map.entities.push(pin);
            map.entities.push(pushpins);
        };

        // 現在地の取得に成功したときの関数
        function mapsInit(position) {
            // console.log(position)
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            map = new Microsoft.Maps.Map('#map', {
                center: {
                    latitude: lat,
                    longitude: lng
                },
                zoom: 15,
            });
            latArray.push(lat);
            lngArray.push(lng);
            setinfopin();
            pushPin(lat, lng, map);
        };

        // 現在位置の取得に失敗したの実行する関数
        function showError(error) {
            let e = "";
            if (error.code == 1) {
                e = "位置情報が許可されてません";
            }
            if (error.code == 2) {
                e = "現在位置を特定できません";
            }
            if (error.code == 3) {
                e = "位置情報を取得する前にタイムアウトになりました";
            }
            alert("error：" + e);
        }

        // 位置情報を取りにいく処理
        function getPosition() {
            navigator.geolocation
                .getCurrentPosition(mapsInit, showError, option);
        };

        window.onload = function() {
            getPosition();
        }
    </script>

</body>

</html>