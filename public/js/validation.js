 
// 到着時刻の保存ボタンが押された時に実行
function checkArrivalTime(e){
    const n = document.getElementById('js-getVariable').name;
    // n番目の出発時刻を取り出す
    const DEPARTURE_TIME = document.getElementById('departure-entered-' + n);
    // 出発時刻から数字だけ抜き出す
    const INT_DEPARTURE_TIME = DEPARTURE_TIME.innerHTML.replace(/[^0-9]/g, '');
    // 入力されたn番目の到着時刻を取り出す
    const ARRIVAL_TIME = document.getElementById('arrival-empty-' + n).value;
    // 到着時刻から数字だけ抜き出す
    const INT_ARRIVAL_TIME = ARRIVAL_TIME.replace(/[^0-9]/g, '');
    if(INT_DEPARTURE_TIME > INT_ARRIVAL_TIME){
        window.alert(n);
        console.log(n);
        return false;
    }else{
        document.arrival_time_empty.submit();
    }
}


// for (let i = 0; i < n; i++) {
 
//  // 繰り返し処理
 
// }





function check_new_entry(e){
    if(2>1){
        const message = document.getElementById('title').value;
        const departure = document.getElementById('departure').value;
        console.log(departure);
        window.alert(departure);
    };
}
