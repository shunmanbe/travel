// 出発日を取り出す
const DEPARTURE_DAY = document.getElementById('departure_day');
// 出発日から数字を取り出し、足りない時・分のぶん0を4つ足す
const INT_DEPARTURE_DAY = DEPARTURE_DAY.innerHTML.replace(/[^0-9]/g, '') + '0000';

// 帰着日を取り出す
const ARRIVAL_DAY = document.getElementById('arrival_day');
// 帰着日から数字を取り出し、足りない時・分のぶん0を4つ足す
const INT_ARRIVAL_DAY = ARRIVAL_DAY.innerHTML.replace(/[^0-9]/g, '') + '0000';

// parseInt関数で文字列を整数に変換し、日にちを1日進める（10000足す, 月を跨ぐ時でも問題なし）
// INT_ARRIVAL_DAY_PLUS1は帰着日の次の日の0時00分を指定
const INT_ARRIVAL_DAY_PLUS1 = parseInt(INT_ARRIVAL_DAY) + 10000;

// 出発時刻・到着時刻は変数nを用いるため関数内で定義

// 出発時刻の保存ボタンが押された時に実行
function checkDepartureTime(n){
    // 入力されたn番目の出発時刻を取り出す
    const DEPARTURE_TIME = document.getElementById('departure-empty-' + n).value;
    // 出発時刻から数字だけ抜き出す
    const INT_DEPARTURE_TIME = DEPARTURE_TIME.replace(/[^0-9]/g, '');
    
    // n番目の到着時刻を取り出す
    const ARRIVAL_TIME = document.getElementById('arrival-entered-' + n);
    
    // もし到着時刻が入力されていない時、nullのままだとINT_ARRIVAL_TIMEでエラーが出てそれ以降のjsが
    // 機能しないため、到着日を代わりに代入しておく
    // if文内でconst, letで定義したものはifがいで呼び出せない。varを使う。
    if(ARRIVAL_TIME == null){
        var INT_ARRIVAL_TIME = INT_ARRIVAL_DAY_PLUS1;
    }else{
        // 到着時刻から数字だけ抜き出す
        var INT_ARRIVAL_TIME = ARRIVAL_TIME.innerHTML.replace(/[^0-9]/g, '');
    }
    
    // 入力された出発時刻に対するバリデーション
    if(INT_DEPARTURE_TIME == ""){
        window.alert('日時を指定してください');
        return false;
    }else if(INT_DEPARTURE_TIME < INT_DEPARTURE_DAY || INT_DEPARTURE_TIME >= INT_ARRIVAL_DAY_PLUS1){
        window.alert('旅行期間外の日時が入力されています');
        return false;
    }else if(INT_DEPARTURE_TIME > INT_ARRIVAL_TIME){
        window.alert('出発時刻が正しくありません');
        return false;
    }else{
        document.departure_time_store.submit();
    }
}

// 到着時刻の保存ボタンが押された時に実行
function checkArrivalTime(n){
    // 入力されたn番目の到着時刻を取り出す
    const ARRIVAL_TIME = document.getElementById('arrival-empty-' + n).value;
    // 到着時刻から数字だけ抜き出す
    const INT_ARRIVAL_TIME = ARRIVAL_TIME.replace(/[^0-9]/g, '');
    // n番目の出発時刻を取り出す
    const DEPARTURE_TIME = document.getElementById('departure-entered-' + n);
    
    // もし出発時刻が入力されていない時、nullのままだとINT_ARRIVAL_TIMEでエラーが出てそれ以降のjsが
    // 機能しないため、出発日を代わりに代入しておく。
    // if文内でconst, letで定義したものはifがいで呼び出せない。varを使う。
    if(DEPARTURE_TIME == null){
        var INT_DEPARTURE_TIME = INT_DEPARTURE_DAY;
    }else{
        // 出発時刻から数字だけ抜き出す
        var INT_DEPARTURE_TIME = DEPARTURE_TIME.innerHTML.replace(/[^0-9]/g, '');
    }
    // 入力された到着時刻に対するバリデーション
    if(INT_ARRIVAL_TIME == ""){
        window.alert('日時を指定してください');
        return false;
    }else if(INT_ARRIVAL_TIME < INT_DEPARTURE_DAY || INT_ARRIVAL_TIME >= INT_ARRIVAL_DAY_PLUS1){
        window.alert('旅行期間外の日時が入力されています');
        return false;
    }else if(INT_DEPARTURE_TIME > INT_ARRIVAL_TIME){
        window.alert('到着時刻が正しくありません');
        return false;
    }else{
        document.arrival_time_store.submit();
    }
}

// 新規登録の保存ボタンが押された時に実行
function checkNewEntry(e){
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

function checkPlaceSearch(e){
    // タイトルを取り出す
    const PLACE = document.getElementById('place').value;
    
    if(PLACE == ""){
        window.alert("検索したいワードを入力してください");
        return false;
    }else{
        document.date_store.submit();
    }
}

// 旅行期間内に収まっているかチェック
function checkWithinPeriod(e){
    // 出発日を取り出す
    const DEPARTURE_DAY = document.getElementById('departure_day');
    // 出発日から数字を取り出し、足りない時・分のぶん0を4つ足す
    const INT_DEPARTURE_DAY = DEPARTURE_DAY.replace(/[^0-9]/g, '') + '0000';
    // 帰着日を取り出す
    const ARRIVAL_DAY = document.getElementById('arrival_day');
    // 帰着日から数字を取り出し、足りない時・分のぶん0を4つ足す
    const INT_ARRIVAL_DAY = ARRIVAL_DAY.replace(/[^0-9]/g, '') + '0000';
    console.log(INT_ARRIVAL_DAY);
}

