$(function () {
    //PHPからのデータ受け取り用
    const response_data = [];
    //緯度経度取得用の配列
    const latArray = [];
    const lngArray = [];
    //緯度経度をfirestoreから取得するための配列
    const latArrayfirestoe = [];
    const lngArrayfirestoe = [];
    const pushpinsinfo = [];    //ピンの情報用の配列
    const pushpins = [];

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


    //     //dataArray内の緯度経度を配列posiArrayに格納
    //     dataArray.forEach(function (value) {
    //         const lattag = value.data.lat;
    //         const lngtag = value.data.lng;
    //         latArrayfirestoe.push(lattag);
    //         lngArrayfirestoe.push(lngtag);
    //     });
    //     //保存されている位置情報のマップピン表示用
    //     dataArray.forEach(function (value,index) {
    //         const infotag = {
    //             id:value.data.id,
    //             latitude: latArrayfirestoe[index],
    //             longitude: lngArrayfirestoe[index],
    //             title: value.data.name,
    //             description:value.data.freetext
    //         };
    //         pushpinsinfo.push(infotag);
    //     });
    // });

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
            <input type="text" id="area">
        </div>
        <div class="pnumber">
            <p>電話番号</p>
            <input type="text" id="pnumber">
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
            pnumber: $('#pnumber').val(),
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
                const json_response_data = data;
                const response_tag = JSON.parse(json_response_data);
                response_data.push(response_tag);
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

    // //消去ボタンクリック時の処理
    // $(document).on('click', '#dataclear', function () {
    //     //クリックされた.clearの兄弟要素から.liatknameのvalue値取得し、変数cnameに格納
    //     const cname = $(this).parents('header').siblings('div').find('#logdata').find('li').eq(0).text();
    //     console.log(cname);
    //     $(this).parents('#mypagetimelineitem').append('<div class= modal ></div >')
    //     $(this).parents('#mypagetimelineitem').find('.modal').append('<div class = modal-content></div>')
    //     $(this).parents('#mypagetimelineitem').find('.modal-content').append('<p>消去</p>');
    //     $('.modal p').addClass("modal-close")
    //     $('modal').fadeIn();
    //     // モーダルウィンドウ表示・非表示(消去の確認画面)
    //     $('.modal-close').text(cname + 'を消去しますか？')
    //     return false;
    // });
    //.modal-closeクリック時、該当のfirebaseのデータを消去
    // $(document).on('click', '.modal-close', function () {
    //     //.modalの兄弟要素にあたる#mypagetimelineitemを取得し、その子要素.listknameを再取得して変数deletenameに格納
    //     const deletename = $(this).parents('#mypagetimelineitem').find('.listkname').val();
    //     console.log(deletename);
    //     const deleteId = $.grep(dataArray,
    //         function (obj, idx) {
    //             return (obj.data.name == deletename);  //data.nameがdeletenameと一致するオブジェクト抽出
    //         }
    //     );
    //     console.log(deleteId[0].id);
    //     db.doc(deleteId[0].id).delete().then(function () {
    //         console.log("Document successfully deleted!");
    //     })
    //     // localStorage.removeItem(removename);
    //     $(this).parents('.listitem').find('.listkname').val('');
    //     $(this).parents('.listitem').find('.listgetday').val('');
    //     $(this).parents('.listitem').find('.listkarea').val('');
    //     $(this).parents('.listitem').find('.listcategory').val('');
    //     $(this).parents('.listitem').find('.listpnumber').val('');
    //     $(this).parents('.listitem').find('.listevaluation').val('')
    //     $(this).parents('.listitem').find('.listfreetext').val('');
    //     $('.modal').fadeOut();
    //     return false;
    // });
    
    //map表示用に使用する変数
    let map;
    console.log(pushpinsinfo)
    function setinfopin() {
        
        //infoboxは一つ作成して再利用する
        var infobox = new Microsoft.Maps.Infobox(new Microsoft.Maps.Location(0, 0), { visible: false, autoAlignment: true });
        infobox.setMap(map);

        //pushpinの情報を作成
        pushpinsinfo.forEach(function (info) {
            if (uid == info.id) {
                var pushpin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(info.latitude, info.longitude),{
                color:'red',
                visible:'ture',
                });
            console.log(info)
                pushpin.metadata = info;
                Microsoft.Maps.Events.addHandler(pushpin, 'click', function (args) {
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
    function pushPin (lat, lng, map){
        const location = new Microsoft.Maps.Location(lat, lng);
        const pin = new Microsoft.Maps.Pushpin(location,{
            color:'navy',
            visible:'ture',
      });
        map.entities.push(pin);
        map.entities.push(pushpins);
    };
    
    // 現在地の取得に成功したときの関数
    function mapsInit(position) {
        // console.log(position)
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        map = new Microsoft.Maps.Map('#map',{
          center: {
            latitude: lat, longitude: lng
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
    function getPosition () {
      navigator.geolocation
        .getCurrentPosition(mapsInit, showError, option);
    };

    window.onload = function(){
        getPosition();
    }

});

