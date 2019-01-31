<script type="text/javascript">
    //    上传文档显示对应的文档类型图片
    function ProType(fileName) {
        if( fileName !="" && fileName != undefined && fileName !=null ){
            var fileSplit = fileName.split(".");
            var fileType = fileSplit[fileSplit.length-1];
            var ImgSrc ="";
            switch (fileType){
                case "pdf":
                case "PDF":
                    ImgSrc = "/home/web/images/m-pdf.png";
                    break;
                case "docx":
                case "DOCX":
                case "doc":
                case "DOC":
                    ImgSrc = "/home/web/images/m-doc.png";
                    break;
                case "ppt":
                case "PPT":
                    ImgSrc = "/home/web/images/PPT.jpg";
                    break;
                case "pptx":
                case "PPTX":
                    ImgSrc = "/home/web/images/PPT.jpg";
                    break;
                case "xls":
                case "XLS":
                    ImgSrc = "/home/web/images/xls.png";
                    break;
                case "png":
                case "PNG":
                case "jpg":
                case "JPG":
                    ImgSrc = "/home/web/images/JPG.png";
                    break;
                case "rar":
                case "RAR":
                    ImgSrc = "/home/web/images/m-zip.png";
                    break;
                case "zip":
                case "ZIP":
                    ImgSrc = "/home/web/images/m-zip.png";
                    break;
                case "mp4":
                case "MP4":
                    ImgSrc = "/home/web/images/MP4.png";
                    break;
                case "3gb":
                case "3GB":
                    ImgSrc = "/home/web/images/3gb.png";
                    break;
                case "rmvb":
                case "RMVB":
                    ImgSrc = "/home/web/images/rmvb.png";
                    break;
                case "avi":
                case "AVI":
                    ImgSrc = "/home/web/images/avi.png";
                    break;
                default:
                    ImgSrc="/home/images/no_img.png";
                    break;
            };
            return ImgSrc;
        }
    }
    //获取当前时间
    function  _thisDate() {
        var _thisDate = new Date();
        var _thisYear = _thisDate.getFullYear();    //获取完整的年份(4位,1970-????)
        var _thisMonth = _thisDate.getMonth() +1;       //获取当前月份(0-11,0代表1月)
        var _thisDate = _thisDate.getDate();        //获取当前日(1-31)
        var _thisTime = _thisYear +"-"+_thisMonth+"-"+_thisDate;
        return _thisTime;
    }
</script>