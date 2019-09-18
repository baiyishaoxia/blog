<script type="text/javascript">
    var uploader = WebUploader.create({

        // swf文件路径
        swf:  "{{asset('/admin/script/webuploader/uploader.swf')}}",

        // 文件接收服务端。
        server: "{{URL::action('Background\UploadController@postVideoFile')}}",

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '.file_video',

        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,
        auto:true,
        duplicate :true
    });
    uploader.on( 'uploadSuccess', function( file,data ) {
        if(data.status == 0){
            layer.msg(data.msg);
        }else {
            appendAttachHtml_video(file.name,data.path,"zip",data.size,data.size);
        }
    });
     // 文件上传过程中创建进度条实时显示。
     uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li =$(".videos").attr("id", file.id ),
            $percent = $li.find('.progress .progress-bar');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="progress progress-striped active">' +
            '<div class="progress-bar" role="progressbar" style="width: 0%">' +
            '</div>' +
            '</div>').appendTo( $li ).find('.progress-bar');
        }

        $li.find('p.state').text('上传中');

        $percent.css( 'width', percentage * 100 + '%' );
    });
    // 完成上传完
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').fadeOut();
        $( '#'+file.id ).html("").attr("id","");
    });
    //创建附件节点的HTML
    function appendAttachHtml_video(fileName, filePath, fileExt, fileSize, fileSizeStr) {
        if($("#show_file_video li").length<4){
            var rand=Math.random();
            var imgType = ProType(fileName);
            var _thisTime=_thisDate();
            var strVar = "";
            strVar += "         <li>\n";
            strVar += "			<input class=\"filename\" name=\"file_video["+rand+"][filename]\" type=\"hidden\" value=\"" + fileName + "\" />\n";
            strVar += "			<input class=\"filepath\" name=\"file_video["+rand+"][filepath]\" type=\"hidden\" value=\"" + filePath + "\" />\n";
            strVar += "			<input class=\"filesize\" name=\"file_video["+rand+"][filesize]\" type=\"hidden\" value=\"" + fileSize + "\" />\n";
            strVar += "			<input class=\"filesize\" name=\"file_video["+rand+"][filetime]\" type=\"hidden\" value=\""+_thisTime+"\" />\n";
            strVar += "	            <span class=\"img_show\"><img src=\""+imgType+"\"><\/span>\n";
            strVar += "	            <div class=\"info\">\n";
            strVar += "		            <p>"+fileName+"<\/p>\n";
            strVar += "		            <label>大小："+fileSizeStr+"<\/label>\n";
            strVar += "	            <\/div>\n";
            strVar += "	            <span class=\"time\">提交时间： "+_thisTime+"<\/span>\n";
            strVar += "         	<a href=\"javascript:void(0);\" class=\"delete\" onclick=\"delAttachNode($(this));\"><i class=\"iconfont\">&#xe68e;<\/i>删除<\/a>\n";
            strVar += "         <\/li>\n";
            $("#show_file_video").prepend(strVar);
        }else{
            layer.msg("最多不能超过4个文件");
        }
    }
</script>