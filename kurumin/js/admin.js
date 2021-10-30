function approval () {
    /* 確認ダイアログ表示 */
    return window.confirm ( "承認しますか？");
}



$(function () {
  $('.company_list').on('click', function () {

  var f = document.createElement('form');
  f.method = 'post';               //通信方法はPOST
  f.action = '/kurumin/admin/admin_company_detail/';   //情報の送り先URL

  //innerHTMLメソッドは要素の内容を変更するプログラム。値を代入したり内容を空にすることができる。
  //ここではそれぞれのvalueにさきほど定義した変数を指定
  var company_id = $(this).children('td')[0].innerText;;
  f.innerHTML = '<input type="hidden" name="company_id" value='+  company_id + '>';

  //せっかく作ったform部品もhtmlのBodyに反映させなきゃ意味がないので
  //appendでBody内に挿入
  document.body.append(f);

  //submit()で情報送信
  f.submit();

  });
});
