<script>
    //展开收起
    $(".tab-content .panles .panels-tt span.closed").click(function () {
        $(this).parents(".panels-tt").find(".open").show();
        $(this).hide();
        $(this).parents(".panles").find(".create-cont").hide();
    });
    $(".tab-content .panles .panels-tt span.open").click(function () {
        $(this).parents(".panels-tt").find(".closed").show();
        $(this).hide();
        $(this).parents(".panles").find(".create-cont").show();
    });
    /*关闭弹出框口*/
    function layer_close(){
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
</script>
<script>
    //ajax提交 [参与活动]
    $(".ajax").click(function () {
        var the_form=$(this).parents('form').eq(0);
        var form_url = the_form.attr('action');
        $.post(form_url,$("#form1").serialize(),function (data) {
            if(data.status==201 || data.status==0){
                layer.msg(data.info);
                return
            }
            if(data.status==200){
                layer.msg(data.info,{icon:1,time:2000},function () {
                    parent.location.reload();// 刷新父窗口
                    layer_close();
                });
                return
            }
            if (data.url!=undefined) {
                setTimeout(function () {
                    window.location.href = data.url
                }, 2000);
            }
        });
        return false;
    });
</script>