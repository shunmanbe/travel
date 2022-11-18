// n番目の出発時刻を取り出す
const departureTime = document.getElementById('departure-entered-' + n);
// 入力されたn番目の到着時刻を取り出す
const arrivalTime = document.getElementById('arrival-empty-' + n);
// 出発時刻から数字だけ抜き出す
const intDepartureTime = departureTime.innerHTML.replace(/[^0-9]/g, '');
// 到着時刻から数字だけ抜き出す
const intArrivalTime = arrivalTime.innerHTML.replace(/[^0-9]/g, '');
// 到着時刻の保存ボタンが押された時に実行
function check(e){
    if(2>1){
        console.log(intDepartureTime);
        window.alert(intDepartureTime);
        // window.alert('到着時刻が正しくありません');
        return false;
    }else{
        return false;
    }
}