// 到着時刻の保存ボタンが押された時に実行
function checkArrivalTime(n){
    // n番目の出発時刻を取り出す
    const DEPARTURE_TIME = document.getElementById('departure-entered-' + n);
    // 出発時刻から数字だけ抜き出す
    const INT_DEPARTURE_TIME = DEPARTURE_TIME.innerHTML.replace(/[^0-9]/g, '');
          
    // 入力されたn番目の到着時刻を取り出す
    const ARRIVAL_TIME = document.getElementById('arrival-empty-' + n).value;
    // 到着時刻から数字だけ抜き出す
    const INT_ARRIVAL_TIME = ARRIVAL_TIME.replace(/[^0-9]/g, '');
          
    console.log(n);
    if(INT_DEPARTURE_TIME > INT_ARRIVAL_TIME){
        window.alert('到着時刻が正しくありません');
        return false;
    }else{
        document.arrival_time_empty.submit();
    }
}

// 新規登録の保存ボタンが押された時に実行
function check_new_entry(e){
    // タイトルを取り出す
    const TITLE = document.getElementById('title').value;
    
    // 出発日を取り出す
    const DEPARTURE_DAY = document.getElementById('departure-day').value;
    // 出発日から数字だけ抜き出す
    const INT_DEPARTURE_DAY = DEPARTURE_DAY.replace(/[^0-9]/g, '');
    
    // 帰着日を取り出す
    const ARRIVAL_DAY = document.getElementById('arrival-day').value;
    // 帰着日から数字だけ抜き出す
    const INT_ARRIVAL_DAY = ARRIVAL_DAY.replace(/[^0-9]/g, '');
    
    if(TITLE == ""){
        window.alert("旅行タイトルを入力してください");
        return false;
    }else if(INT_DEPARTURE_DAY == "" || INT_ARRIVAL_DAY == ""){
        window.alert("期間を入力してください");
        return false;
    }else if(INT_DEPARTURE_DAY > INT_ARRIVAL_DAY){
        window.alert("期間が正しくありません");
        return false;
    }else{
        document.date_store.submit();
    }
}

function check_place_search(e){
    // タイトルを取り出す
    const PLACE = document.getElementById('place').value;
    
    if(PLACE == ""){
        window.alert("検索したいワードを入力してください");
        return false;
    }else{
        document.date_store.submit();
    }
}

