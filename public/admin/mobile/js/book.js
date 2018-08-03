function hideActionSheet(weuiActionsheet, mask) {
    weuiActionsheet.removeClass('weui_actionsheet_toggle');
    mask.removeClass('weui_fade_toggle');
    weuiActionsheet.on('transitionend', function () {
        mask.hide();
    }).on('webkitTransitionEnd', function () {
        mask.hide();
    })
}

function onMenuClick () {
    var mask = $('#mask');
    var weuiActionsheet = $('#weui_actionsheet');
    weuiActionsheet.addClass('weui_actionsheet_toggle');
    mask.show().addClass('weui_fade_toggle').click(function () {
        hideActionSheet(weuiActionsheet, mask);
    });
    $('#actionsheet_cancel').click(function () {
        hideActionSheet(weuiActionsheet, mask);
    });
    weuiActionsheet.unbind('transitionend').unbind('webkitTransitionEnd');
}

function onMenuItemClick(index) {
  var mask = $('#mask');
  var weuiActionsheet = $('#weui_actionsheet');
  hideActionSheet(weuiActionsheet, mask);
  if(index == 1) {
    $('.bk_toptips').show();
    $('.bk_toptips span').html("敬请期待!");
    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
  } else if(index == 2) {
    location.href = '/admin/mobile/category';
  } else if(index == 3){
    location.href = '/admin/mobile/cart';
  } else if(index == 4){
    location.href = '/admin/mobile/order/list';
  }else if(index == 5){
    location.href = '/admin/mobile/logout';
  }else if(index == 0){
    location.href = '/admin/mobile/login';
  }
}

//将标题栏和标题保持一致
$('.bk_title_content').html(document.title);
