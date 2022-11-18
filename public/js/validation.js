 
// 到着時刻の保存ボタンが押された時に実行
function checkArrivalTime(e){
    // n番目の出発時刻を取り出す
    const departureTime = document.getElementById('departure-entered-' + n);
    // 出発時刻から数字だけ抜き出す
    const intDepartureTime = departureTime.innerHTML.replace(/[^0-9]/g, '');
    // 入力されたn番目の到着時刻を取り出す
    const arrivalTime = document.getElementById('arrival-empty-' + n).value;
    // 到着時刻から数字だけ抜き出す
    const intArrivalTime = arrivalTime.replace(/[^0-9]/g, '');
    if(intDepartureTime > intArrivalTime){
        window.alert('到着時刻が正しくありません');
        return false;
    }else{
        document.arrival-time-empty.submit();
    }
}




function check_new_entry(e){
    if(2>1){
        const message = document.getElementById('title').value;
        const departure = document.getElementById('departure').value;
        console.log(departure);
        window.alert(departure);
    };
}


function check_a(e){
     if(!window.confirm('本当に削除しますか？')){
      window.alert('キャンセルされました'); 
      return false;
     }
     document.deleteform.submit();
}



// // n番目の出発時刻を取り出す
// const departureTime = document.getElementById('departure-entered-' + n);
// // 入力されたn番目の到着時刻を取り出す
// const arrivalTime = document.getElementById('arrival-empty-' + n);
// // 出発時刻から数字だけ抜き出す
// const intDepartureTime = departureTime.innerHTML.replace(/[^0-9]/g, '');
// // 到着時刻から数字だけ抜き出す
// const intArrivalTime = arrivalTime.innerHTML.replace(/[^0-9]/g, '');
// // 到着時刻の保存ボタンが押された時に実行
// function check(e){
//     if(2>1){
//         console.log(intDepartureTime);
//         window.alert(intDepartureTime);
//         // window.alert('到着時刻が正しくありません');
//         return false;
//     }else{
//         return false;
//     }
// }