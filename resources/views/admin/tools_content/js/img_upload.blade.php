<script type="text/javascript">
    $(function () {
        //上传单图片
        $('.upload_image_btn').each(function () {
            var theThis=this;
            var uploader = WebUploader.create({
                // swf文件路径
                swf: '{{URL::asset('home/script/webuploader/Uploader.swf')}}',
                // 文件接收服务端。
                server: '{{URL::action('Common\UploadController@postImg')}}',
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: theThis,
                // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: false,
                duplicate :true,
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'file/*'
                },
                auto:true,
                fileVal:'Filedata'
            });
            uploader.on( 'uploadProgress', function( file, percentage ) {
                var $li = $( '#'+file.id ),
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
            uploader.on('error', function (type) {
                if (type == "Q_TYPE_DENIED") {
                    layer.msg("请上传jpg,jpeg,bmp,png格式的文件！", { icon: 2 });
                    return;
                } else if (type == "F_EXCEED_SIZE") {
                    layer.msg("文件大小不能超过30M", { icon: 2 });
                    return;
                }
            });
            uploader.on('onError', function (type) {
                if (code == "Q_TYPE_DENIED") {
                    layer.msg("请上传jpg,jpeg,bmp,png格式的文件！", { icon: 2 });
                    return;
                } else if (code == "F_EXCEED_SIZE") {
                    layer.msg("文件大小不能超过30M", { icon: 2 });
                    return;
                }
            });
            uploader.on('filesQueued', function (file) {
                if( file != "" && file != null && file != undefined ){
                    var _format =file[0].ext;
                    if( _format == "jpg" || _format == "jpeg" || _format == "bmp" || _format == "png"  || _format == "JPG" || _format == "JPEG" || _format == "BMP" || _format == "PNG"){
                    }else{
//                        layer.msg("请上传jpg,jpeg,bmp,png格式的文件！", { icon: 2 });
                        return;
                    };
                };
            });
            uploader.on( 'uploadSuccess', function( file,data ) {
                console.log(data)
                if(data.status == 1){
                    $(theThis).parents('.upload_image').eq(0).find('.input_image').val(data.url);
                    $(theThis).parents('.upload_image').eq(0).find('.image').attr('src',data.url);
                }else{
                    layer.msg(data.msg);
                }
            });
        });
        //endregion
    })
</script>

<script type="text/javascript">
    //region 上传多图(材料证明)  oldboy
    var uploader1 = WebUploader.create({
        // swf文件路径
        {{--                            swf: '{{URL::asset('js/webuploader/Uploader.swf')}}',--}}
        swf: '{{URL::asset('home/script/webuploader/Uploader.swf')}}',
        // 文件接收服务端。
        server: '{{URL::action('Background\UploadController@postImg')}}',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#upload_images',
        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,
        // 只允许选择图片文件。
        multiple:true,
        accept: {
            title: 'Images',
            extensions: 'jpg,jpeg,bmp,png',
            mimeTypes: 'file/*'
        },
        auto:true,
        fileVal:'Filedata',
        duplicate :false
    });
    uploader1.on('error', function (type) {
        if (type == "Q_TYPE_DENIED") {
            layer.msg("请上传jpg,jpeg,bmp,png格式的文件！", { icon: 2 });
            return;
        } else if (type == "F_EXCEED_SIZE") {
            layer.msg("文件大小不能超过30M", { icon: 2 });
            return;
        }
    });
    uploader1.on('onError', function (type) {
        if (code == "Q_TYPE_DENIED") {
            layer.msg("请上传jpg,jpeg,bmp,png格式的文件！", { icon: 2 });
            return;
        } else if (code == "F_EXCEED_SIZE") {
            layer.msg("文件大小不能超过30M", { icon: 2 });
            return;
        }
    });
    uploader1.on('filesQueued', function (file) {
        if( file != "" && file != null && file != undefined ){
            var _format =file[0].ext;
            if( _format == "jpg" || _format == "jpeg" || _format == "bmp" || _format == "png"  || _format == "JPG" || _format == "JPEG" || _format == "BMP" || _format == "PNG"){

            }else{
                layer.msg("请上传jpg,jpeg,bmp,png格式的文件！", { icon: 2 });
                return;
            };
        };
    });
    uploader1.on( 'uploadSuccess', function( file,data ) {
        if(data.status == 0){
            layer.msg(data.msg);
        }else {
            if($(".upload-fileimg span").length<4){
                appendAttachHtml_heying(file.id,file.name,data.path,"zip",data.size,data.size,data.url);
            }else{
                layer.msg("材料证明最多上传4张");
            }

        }
    });
    //创建附件节点的HTML
    function appendAttachHtml_heying(fileId,fileName, filePath, fileExt, fileSize, fileSizeStr,img_url) {
        var rand=Math.random();
        // var imgType = ProType(fileName);
        // var _thisTime=_thisDate();
        var strVar = "";
        strVar += "<span>\n";
        strVar += "	<input class=\"filename\" name=\"user_prove_img["+rand+"][filename]\" type=\"hidden\" value=\"" + fileName + "\" />\n";
        strVar += "	<input class=\"filepath\" name=\"user_prove_img["+rand+"][filepath]\" type=\"hidden\" value=\"" + filePath + "\" />\n";
        strVar += "	<input class=\"filesize\" name=\"user_prove_img["+rand+"][filesize]\" type=\"hidden\" value=\"" + fileSize + "\" />\n";
        strVar += "	<input class=\"fileId\" type=\"hidden\" value=\""+ fileId +"\" />\n";
        strVar += "	<img src=\""+img_url+"\">\n";
        strVar += "	<i>"+fileName+"<\/i>\n";
        strVar += "	<font class=\"iconfont\">&#xe64d;<\/font>\n";
        strVar += "<\/span>\n";
        $(".upload-fileimg").append(strVar);
    }
</script>