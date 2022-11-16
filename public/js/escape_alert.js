function escape_alert(e){
     if(!window.confirm('このグループを本当に抜けますか？')){
      window.alert('キャンセルされました'); 
      return false;
     }
     document.deleteform.submit();
}