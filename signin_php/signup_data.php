<?php
//新規登録
// var_dump($_POST);
// exit();
$createemail = strval($_POST['createmail']);
// var_dump($createemail);
// exit();

//認証コード生成・送信
$authentication_code = '';
for ($count = 0; $count < 6; $count++) {
    $authentication_code .= rand(1, 6);
}
// var_dump($authentication_code);
// exit();
$to = $createemail;
$subject = "認証コードの確認";
$message = "ご登録ありがとうございます。\r\n下記の認証コードを登録フォームに入力してください。\r\n\r\n\r\n---------------------\r\n\r\n{$authentication_code}\r\n\r\n---------------------";
$headers = "From: phpkadai06@gmail.com";
mb_send_mail($to, $subject, $message, $headers);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../signin_css/signup.css">
    <title>sign-up</title>
</head>

<body>
    <div class="authentication" id="number">
        <p>確認コードを入力してください</p>
        <input type="text" name="createnumber" id='createnumber'>
        <button id="next">next</button>
    </div>
    <form action="sigup_userdata.php" method="post">
        <div id="userdata">
            <fieldset class="signup-content">
                <p>氏名</p>
                <input type="text" name="name" id="name" placeholder="古閑　大輔">
                <p>年齢</p>
                <input type="text" name="age" id="age" placeholder="26">
                <select type="text" name="gender" id="gender">
                    <optgroup label="">
                        <option>性別</option>
                        <option>男性</option>
                        <option>女性</option>
                        <option>指定しない</option>
                    </optgroup>
                </select>
                <select type="text" name="city" id="city">
                    <optgroup label="">
                        <option>都道府県</option>
                        <option>北海道</option>
                        <option>青森</option>
                        <option>岩手</option>
                        <option>宮城</option>
                        <option>秋田</option>
                        <option>山形</option>
                        <option>福島</option>
                        <option>茨城</option>
                        <option>栃木</option>
                        <option>群馬</option>
                        <option>埼玉</option>
                        <option>千葉</option>
                        <option>東京</option>
                        <option>神奈川</option>
                        <option>新潟</option>
                        <option>富山</option>
                        <option>石川</option>
                        <option>福井</option>
                        <option>山梨</option>
                        <option>長野</option>
                        <option>岐阜</option>
                        <option>静岡</option>
                        <option>愛知</option>
                        <option>三重</option>
                        <option>滋賀</option>
                        <option>京都</option>
                        <option>大阪</option>
                        <option>兵庫</option>
                        <option>奈良</option>
                        <option>和歌山</option>
                        <option>鳥取</option>
                        <option>島根</option>
                        <option>岡山</option>
                        <option>広島</option>
                        <option>山口</option>
                        <option>徳島</option>
                        <option>香川</option>
                        <option>愛媛</option>
                        <option>高知</option>
                        <option>福岡</option>
                        <option>佐賀</option>
                        <option>長崎</option>
                        <option>熊本</option>
                        <option>大分</option>
                        <option>宮崎</option>
                        <option>鹿児島</option>
                        <option>沖縄</option>
                    </optgroup>
                </select>
                <span id="next2">next</p>
            </fieldset>
        </div>
        <div id="sigindata">
            <fieldset class="signup-content">
                <p>パスワード</p>
                <input type="password" name="password" id="password">
                <p>メールアドレス</p>
                <input type="text" name="email" id="email">
                <button id="signup">submit</button>
            </fieldset>
        </div>
    </form>
    <script>
        //送信キャンセル
        function nosubmit() {
            $('form').submit(function() {
                return false;
            });
        };
        //認証コード判定
        $('#next').on('click', function() {
            const createnumber = $('#createnumber').val();
            if (createnumber == <?= $authentication_code ?>) {
                //画面の切り替え
                $('#userdata').fadeIn(100);
                $('#number').addClass('none');
            } else {
                alert('認証コードが違います')
            }
        });
        //年齢入力画面は半角表示
        $('#age').on('input', function(e) {
            let value = $(e.currentTarget).val();
            value = value
                .replace(/[０-９]/g, function(s) {
                    return String.fromCharCode(s.charCodeAt(0) - 65248);
                })
                .replace(/[^0-9]/g, '');
            $(e.currentTarget).val(value);
        });
        //入力判定を行い、パスワード設定画面へ
        $('#next2').on('click', function() {
            if ($('name').val() != '' && $('#age').val() != '' && $('gender').val() != '' && $('#city').val() != '') {
                //メールアドレス取得
                const emai = "<?= $createemail ?>";
                //画面の切り替え
                $('#sigindata').fadeIn(100);
                $('#userdata').fadeOut(100);
                $('#email').val(emai);
            } else {
                alert('値をすべて入力してください');
            };
        });
        //全項目記入したらアカウント作成
        $('#signup').on('click', function() {
            if ($('#password').val() != '' && $('#email').val() != '') {
                alert('アカウント作成');
            } else {
                alert('パスワードを入力してください');
                nosubmit()
            };
        });
    </script>
</body>

</html>