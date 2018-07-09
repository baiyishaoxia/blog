
    $(function () {
        //region 列表页保存排序
        $('.btnsave').each(function () {
            var href = $(this).attr('href');
            $(this).attr('href','javascript:void(0)');
            $(this).attr('url',href);
        });
        $('.btnsave').click(function () {
            var action=$(this).attr('url');
            $(this).parents('form').eq(0).attr('action',action);
            $(this).parents('form').eq(0).attr('method','POST');
            $(this).parents('form').eq(0).submit();
        });
        /*$('.wangeditor').each(function () {
            // 生成编辑器
            var editor = new wangEditor(this);
            editor.config.uploadImgUrl = '';
            editor.config.menus = $.map(wangEditor.config.menus, function(item, key) {
                 if (item === 'location') {
                     return null;
                 }
                 return item;
             });
            editor.create();
        });*/
        //endregion

        //region 列表页删除选中的ID
        $('.btndel').each(function () {
            var href = $(this).attr('href');
            $(this).attr('href','javascript:void(0)');
            $(this).attr('url',href);
        });
        $('.btndel').click(function () {
            if ($(".checkall input:checked").length < 1) {
                layer.msg('对不起，请选中您要操作的记录！');
                return false;
            }
            var msg = "删除记录后不可恢复，您确定吗？";
            if (arguments.length == 2) {
                msg = objmsg;
            }
            var obj=this;
            parent.layer.confirm(msg, {
                btn: ['確定','取消'] //按钮
            },function () {
                parent.layer.closeAll();
                var action=$(obj).attr('url');
                $(obj).parents('form').eq(0).attr('action',action);
                $(obj).parents('form').eq(0).submit();
            });
            return false;
        });
        //endregion

        //region get弹窗访问URL   Panjunwei
        $('.get_alert').each(function () {
            var href = $(this).attr('href');
            $(this).attr('href','javascript:void(0)');
            $(this).attr('url',href);
        });
        $('.get_alert').click(function () {
            var msg = $(this).attr('msg')?$(this).attr('msg'):"您确定吗？";
            if (arguments.length == 2) {
                msg = objmsg;
            }
            var obj=this;
            parent.layer.confirm(msg, {
                btn: ['確定','取消'] //按钮
            },function () {
                parent.layer.closeAll();
                var action=$(obj).attr('url');
                window.location.href=action;
            });
            /*parent.dialog({
                title: '提示',
                content: msg,
                okValue: '确定',
                ok: function () {
                    var action=$(obj).attr('url');
                    window.location.href=action;
                },
                cancelValue: '取消',
                cancel: function () { }
            }).showModal();*/
            return false;
        });
        //endregion

        //region 点击搜索   Panjunwei
        $('.btn-search').click(function () {
            $(this).parents('form').eq(0).attr('method','get');
            $(this).parents('form').eq(0).find("input[name='_token']").remove();
            $(this).parents('form').eq(0).submit();
        });
        //endregion
    });