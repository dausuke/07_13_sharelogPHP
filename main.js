$(function () {


    //画面の切り替え
    $('.tab a').on('click', function () {
        $(this).parent().addClass('active').siblings('.active').removeClass('active');
        const content = $(this).attr('href');
        $(content).addClass('active').siblings('.active').removeClass('active');
        return false;
    });
 

    // //firestore
    // db.orderBy('getday', 'desc').get().then(function (querySnapshot) {
    //     querySnapshot.docs.forEach(function (doc) {
    //         const data = {
    //             id: doc.id,
    //             data: doc.data()
    //         };
    //         dataArray.push(data);
    //     });

    // //検索画面：検索時保存データ取得表示
    // $('#searchbutton').on('click', function () {
    //     const search = $('#search').val();
    //     const searchId =$.grep(dataArray,
    //         function(obj, idx){
    //         return (obj.data.name == search);  //data.nameがsearchと一致するオブジェクト抽出
    //         }
    //     );
    //     $('#kname').val(searchId[0].data.name);
    //     $('#karea').val(searchId[0].data.area);
    //     $('#kcategory').val(searchId[0].data.category);
    //     $('#kpnumber').val(searchId[0].data.pnumber);
    //     $('#getday').val(searchId[0].data.getday);
    // });

    //保存画面表示
    $('#savelog').on('click', function () {
        $('#savearea').append(`
        <div class="name">
            <p>店名</p>
            <input type="text" id="name">
        </div>
        <div class="area">
            <p>エリア</p>
            <select type="text" id="area">
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
        </div>
        <div class="evaluation">
            <p>評価</p>
            <select type="text" id="evaluation">
                <option value="">選択</option>
                <option value="★★★★★">★★★★★</option>
                <option value="★★★★">★★★★</option>
                <option value="★★★">★★★</option>
                <option value="★★">★★</option>
                <option value="★">★</option>
            </select>
        </div>
        <div class="category">
            <p>カテゴリー</p>
            <select type="text" id="category">
                <option value="">選択</option>
                <option value="ファッション">ファッション</option>
                <option value="ランチ">ランチ</option>
                <option value="ディナー">ディナー</option>
                <option value="コーヒー">コーヒー</option>
                <option value="スポット">スポット</option>
            </select>
        </div>
        <div class="freetext">
            <p>メモ</p>
            <textarea id="freetext" maxlength="150" placeholder="150文字以内"></textarea>
        </div>
        <div class="save">
            <button id="save">保存する</button>
        </div>
        `);
     });

    //保存するボタンクリックイベント
    $(document).on('click', '#save', function () {
        const data = {
            name: $('#name').val(),
            area: $('#area').val(),
            evaluation: $('#evaluation').val(),
            category: $('#category').val(),
            freetext: $('#freetext').val(),
        };
        //PHP送信
        $.ajax({
        //POST通信
            type: "POST",
            url: "data.php",
            data: data,
            success: function (data, dataType) {
                // const json_response_data = data;
                console.log(data)
                // const response_tag = JSON.parse(json_response_data);
                // response_data.push(response_tag);
            },
            //エラー時の処理
            error : function() {
            alert('通信エラー');
            }
        });
        
        //送信後、各エリアの表示を削除
        $('#name').val('');
        $('#area').val('');
        $('#pnumber').val('');
        $('#evaluation').val('');
        $('#category').val('');
        $('#freetext').val('');
    });
    //サインアウト
    $('#signout').on('click', function () {
       if (confirm('サインアウトしますか？')) {
            window.location.href = 'index.php';
        } 
    });
});

