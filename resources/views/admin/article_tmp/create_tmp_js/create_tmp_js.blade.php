<script>
    //默认的J模板列表的JSON
    var SiteJson = [
        {"text":"活动简介","index":1,"cont":"","isDH":true,"isShow":false,"listIndex":0,"canDelete":"false"},
        {"text":"活动目的","index":2,"cont":"","isDH":true,"isShow":false,"listIndex":1,"canDelete":"false"},
        {"text":"活动内容","index":3,"cont":"","isDH":true,"isShow":false,"listIndex":2,"canDelete":"false"},
        {"text":"活动安排","index":4,"cont":"","isDH":true,"isShow":false,"listIndex":3,"canDelete":"false"},
        {"text":"活动规则","index":5,"cont":"","isDH":true,"isShow":false,"listIndex":4,"canDelete":"false"},
        {"text":"活动设置","index":6,"cont":"","isDH":true,"isShow":false,"listIndex":5,"canDelete":"false"},
        {"text":"活动奖励","index":7,"cont":"","isDH":true,"isShow":false,"listIndex":6,"canDelete":"false"},
        {"text":"活动意义","index":8,"cont":"","isDH":true,"isShow":false,"listIndex":7,"canDelete":"false"},
        {"text":"活动方式","index":9,"cont":"","isDH":true,"isShow":false,"listIndex":8,"canDelete":"false"},
        {"text":"活动补充","index":10,"cont":"","isDH":true,"isShow":false,"listIndex":9,"canDelete":"false"}
    ];
    //显示、两个显示影藏的JSON数组
    var All_Modulelist = [], Show_ModuleList = [], Hide_moduleList = [] ,Delete_moduleList = [],AddOrEdit = -1; //一个是，显示的列表，一个是隐藏的列表
    /*
     * @description    根据某个字段实现对json数组的排序
     * @param   array  要排序的json数组对象
     * @param   field  排序字段（此参数必须为字符串）
     * @param   reverse 是否倒序（默认为false）
     * @return  array  返回排序后的json数组
    */
    function jsonSort(arrayinfos, field, reverse) {
        //数组长度小于2 或 没有指定排序字段 或 不是json格式数据
        if(arrayinfos.length < 2 || !field ||typeof arrayinfos[0] !=="object") return arrayinfos;
        //数字类型排序
        if(typeof arrayinfos[0][field] === "number") {
            arrayinfos.sort(function(x, y) {return x[field] - y[field]});
        }
        //字符串类型排序
        if(typeof arrayinfos[0][field] === "string") {
            arrayinfos.sort(function(x, y) {return x[field].localeCompare(y[field])});
        }
        //倒序
        if(reverse) {
            arrayinfos.reverse();
        }
        return arrayinfos;
    }

    function InitModuleList(){
        All_Modulelist = [], Show_ModuleList = [], Hide_moduleList = [],Delete_moduleList=[];
        if($(".templateItem ul li").length>0){
            //如果默认里面有值，重新遍历获取，数据结构，组合成基础数据
            $(".templateItem ul li").each(function(){
                var _theItemJSon = $(this).attr("datang");
                var _thisCont = $(this).find(".contvalue").html();
                try{
                    _theItemJSon = JSON.parse(_theItemJSon);
                }catch(e){
                    _theItemJSon = _theItemJSon.replace(/[\n]/g,"");
                    _theItemJSon = JSON.parse(_theItemJSon);
                }
                _theItemJSon.cont = _thisCont;

                if($(this).find(".canDelete").val()==1){
                    _theItemJSon.canDelete = "true";
                }else{
                    _theItemJSon.canDelete = "false";
                }

                _theItemJSon.listIndex = $(this).index();
                if(_theItemJSon.isDH){
                    Show_ModuleList.push(_theItemJSon);
                }else{
                    Hide_moduleList.push(_theItemJSon);
                }

                All_Modulelist.push(_theItemJSon);
            });
        }else{
            var InitDataJson =  JSON.stringify(SiteJson);
            All_Modulelist = JSON.parse(InitDataJson);
            Show_ModuleList = JSON.parse(InitDataJson);
            Delete_moduleList = JSON.parse(InitDataJson); //创建新菜单带删除
            Hide_moduleList = [];
            Delete_moduleList=[];
        }
        createShow_Module();
        createHide_Module();
        showAll_Modulelist();
    }
    //通过数据创建，顶部的显示模块
    function createShow_Module(){
        $(".templateItem>ul").empty();
        //遍历创建显示的导航Html
        var show_templateItemHtml = "";
        Show_ModuleList = jsonSort(Show_ModuleList,"index",false);
        for(var i = 0 ; i < Show_ModuleList.length; i++){
            var ItemValue = "";
            ItemValue += "<li allindex='"+Show_ModuleList[i].listIndex+"' listindex='"+i+"'>";
            ItemValue += "  <a href=\"javascript:void(0);\" name=\"editItem\">"+Show_ModuleList[i].text+"<\/a>";
            ItemValue += "  <div class=\"contvalue\" style='display:none;'><\/div>";
            if(Show_ModuleList[i].canDelete == 'true'){
                ItemValue += "  <div class=\"deleteItem\">\n";
                ItemValue += "	    <a href=\"javascript:void(0);\">删除<\/a>\n";
                ItemValue += "  <\/div>\n";
            }else{
                ItemValue += "  <div class=\"hideItem\">\n";
                ItemValue += "	    <a href=\"javascript:void(0);\">隐藏<\/a>\n";
                ItemValue += "  <\/div>\n";
            }
            ItemValue += "<\/li>\n";
            $(".templateItem>ul").append($(ItemValue));
            $(".templateItem>ul>li:last").find(".contvalue").html(Show_ModuleList[i].cont);
        }
    }
    //通过数据创建，不展示的模块
    function createHide_Module(){
        $(".templateScend>ul").empty();
        //遍历创建显示的导航Html
        var show_templateItemHtml = "";
        Hide_moduleList = jsonSort(Hide_moduleList,"index",false);
        for(var i = 0 ; i < Hide_moduleList.length; i++){
            var ItemValue = "";
            ItemValue += "<li listindex='"+i+"'>";
            ItemValue += "  <a href=\"javascript:void(0);\" name=\"editItem\">"+Hide_moduleList[i].text+"<\/a>";
            ItemValue += "  <div class=\"contvalue\" style='display:none;'>"+Hide_moduleList[i].cont+"<\/div>";
            ItemValue += "  <div class=\"hideItem\">\n";
            ItemValue += "	    <a href=\"javascript:void(0);\">取消隐藏<\/a>\n";
            ItemValue += "  <\/div>\n";
            ItemValue += "<\/li>\n";
            show_templateItemHtml+= ItemValue;
        }
        $(".templateScend>ul").html(show_templateItemHtml);
    }
    /**
     * 显示所有的，导航列表管理
     */
    function showAll_Modulelist(){
        var _InnerHtmlInfos = "";
        $(".navShow tbody").empty();
        for(var i = 0 ; i < All_Modulelist.length; i++){
            var strVar = "";
            strVar += "<tr candelete='"+All_Modulelist[i].canDelete+"'>\n";
            strVar += "	<td>\n";
            strVar += "		<input type=\"text\" value=\""+All_Modulelist[i].text+"\" class=\"txt_in\" name=\"template["+(i+1)+"][title]\" autocomplete=\"off\">\n";
            strVar += "	<\/td>\n";
            strVar += "	<input class=\"is_show_text\" name=\"template["+(i+1)+"][is_show_text]\" type=\"hidden\" value=\"\" autocomplete=\"off\">\n";
            if(All_Modulelist[i].canDelete == "true"){
                strVar += "	<input class=\"is_new_add\" name=\"template["+(i+1)+"][is_new_add]\" type=\"hidden\" value=\"1\" autocomplete=\"off\">\n";
            }else{
                strVar += "	<input class=\"is_new_add\" name=\"template["+(i+1)+"][is_new_add]\" type=\"hidden\" value=\"0\" autocomplete=\"off\">\n";
            }
            strVar += "	<td>\n";
            strVar += "	<textarea class=\"template_text\" style='display:none;' name=\"template["+(i+1)+"][template_text]\" >"+All_Modulelist[i].cont+"<\/textarea>";
            strVar += "      导航排序：\n";
            strVar += "		<input type=\"text\" class=\"txt_in txt\" value=\""+All_Modulelist[i].index+"\" name=\"template["+(i+1)+"][sort]\" autocomplete=\"off\">\n";
            strVar += "	<\/td>\n";
            strVar += "	<td>\n";
            strVar += "      是否在导航显示：\n";
            strVar += "		<select class=\"sel\" name=\"template["+(i+1)+"][is_show_menu]\">\n";
            if(All_Modulelist[i].isDH){
                strVar += "			<option value=\"1\" selected >是<\/option>\n";
                strVar += "			<option value=\"0\">否<\/option>\n";
            }else{
                strVar += "			<option value=\"1\">是<\/option>\n";
                strVar += "			<option value=\"0\" selected >否<\/option>\n";
            }
            strVar += "		<\/select>\n";
            strVar += "	<\/td>\n";
            strVar += "<\/tr>\n";
            $(".navShow tbody").append($(strVar));
        }
    }
    /**
     * 更改导航顺序管理中的值
     */
    function changeListDataStatue(state,iteminfos){
        if(typeof iteminfos == "undefined") return true;
        var _thisIndex =  iteminfos.listIndex;
        if(All_Modulelist.length>_thisIndex){
            All_Modulelist[_thisIndex] = iteminfos;
            var CheckItem = $(".navShow tbody tr:eq("+_thisIndex+")");
            CheckItem.find("input.txt_in").eq(0).val(iteminfos.text); //标题
            CheckItem.find("input.txt_in").eq(1).val(iteminfos.index); //排序
            CheckItem.find(".template_text").eq(0).val(iteminfos.cont);//内容
            if(state){
                CheckItem.find("select.sel").eq(0).val(1);
            }else{
                CheckItem.find("select.sel").eq(0).val(0);
            }
        }
    }

    //从不影藏到隐藏的状态
    $(".templateItem>ul").on("click","li .hideItem",function(){
        //$(".releaseEvents input[name='column']").trigger("click"); //栏目名称
        //$(".releaseEvents input[name='sort']").trigger("click"); //导航排序
        var _thisIndex = $(this).parents("li").eq(0).attr("listindex") || 0;
        _thisIndex = parseInt(_thisIndex);
        var _thehideItem = Show_ModuleList[_thisIndex];
        _thehideItem.isDH = false;
        if(Hide_moduleList.length>0){
            // var NewHideModuleList = [];
            // for(var i = 0 ; i < Hide_moduleList.length;i++){
            //     if(Hide_moduleList[i].index > _thehideItem.index){
            //         NewHideModuleList.push(Hide_moduleList[i]);
            //     }
            // }
            Hide_moduleList.unshift(_thehideItem);
        }else{
            Hide_moduleList.push(_thehideItem);
        }

        Show_ModuleList.splice(_thisIndex,1);

        createShow_Module();
        createHide_Module();
        changeListDataStatue(false,_thehideItem);
    })

    // 从不隐藏到删除的状态处理
    $(".templateItem>ul").on("click","li .deleteItem",function(){
        var _thisIndex = $(this).parents("li").eq(0).attr("listindex") || 0;
        _thisIndex = parseInt(_thisIndex);
        var _thehideItem = Show_ModuleList[_thisIndex];
        _thehideItem.isDH = false;
        Show_ModuleList.splice(_thisIndex,1);

        createShow_Module();
        for(var i = 0 ; i < All_Modulelist.length; i++){
            if(All_Modulelist[i].listIndex == _thehideItem.listIndex){
                All_Modulelist.splice(i,1);
                i =  All_Modulelist.length;
            }
        }
        showAll_Modulelist();
        //createdeleteShow_Module();
        changeListDataStatue(false,_thehideItem);
    })

    //从隐藏状态跳转到不隐藏的状态
    $(".templateScend>ul").on("click","li .hideItem",function(event){
        var _thisIndex = $(this).parents("li").eq(0).attr("listindex") || 0;
        _thisIndex = parseInt(_thisIndex);
        var _thehideItem = Hide_moduleList[_thisIndex];
        _thehideItem.isDH = true;
        if(Show_ModuleList.length>0){
            Show_ModuleList.unshift(_thehideItem);
        }else{
            Show_ModuleList.push(_thehideItem);
        }
        Hide_moduleList.splice(_thisIndex,1);
        createShow_Module();
        createHide_Module();
        changeListDataStatue(true,_thehideItem);
        event.stopPropagation();
        return true;
    })

    /**
     * 添加新的编模块
     */
    $(".AddSubitem").click(function(){
        AddOrEdit = -1;
        $(".templateItem ul li").removeClass("active");
        $(".releaseEvents input[type=checkbox]").prop('checked');
        $(".releaseEvents input[name=checkbox2]").removeAttr('checked');
        $(".is_show_text").val('');
        $(".releaseEvents input[type=text],.releaseEvents textarea").val('');
        $("#markText").val('');
        $('#content_editor').summernote('reset');
        $('.releaseEvents .btn-red').removeAttr('textsign');
        $(".releaseEvents").show();
        $(".releaseEvents dl dd span").removeClass("Validform_right");
        $(".releaseEvents dl dd span").text('');
    })

    /**
     * 显示选中的内容
     */
    $(".templateItem>ul").on("click","li a[name='editItem']",function(){
        var _theIndex = $(this).parents("li").eq(0).attr("listindex") || "";
        _theIndex = parseInt(_theIndex);
        AddOrEdit = _theIndex;
        var _theItemInfos = Show_ModuleList[_theIndex];
        $(".releaseEvents input[name='column']").val(_theItemInfos.text);
        $(".releaseEvents input[name='sort']").val(_theItemInfos.index);
        var NewContent = $(this).parents("li").eq(0).find(".contvalue").html();
        //NewContent = eval(NewContent);
        $('#content_editor').summernote('code',NewContent);
        $(".releaseEvents input[name='checkbox']").prop("checked",_theItemInfos.isDH);
        $(this).parents("li").siblings().removeClass("active");
        $(this).parents("li").eq(0).addClass("active");
        $(".releaseEvents").show();
    })
    //添加新的赛事模板
    $("#navSort").click(function(){
        $(".releaseEvents input[name='checkbox']").is(":checked");
        var NewItem = {"text":"","index":0,"cont":"","isDH":true,"isShow":false};
        var _title = $(".releaseEvents input[name='column']").val();
        var _DH = false;
        if($(".releaseEvents input[name='checkbox']").is(":checked")){
            _DH = true;
        }
        var _sort = $(".releaseEvents input[name='sort']").val();
        var _cont = $('#content_editor').summernote('code'); // || $(".releaseEvents #markText").val();
        if(_DH==false){
            layer.msg("属性必选");
            return
        }
        if (_title == ""|| _title=="undefined") {
            layer.msg("请输入栏目名称");
            return
        }
        if(_sort==""|| _sort=="undefined"){
            layer.msg("请输入导航排序");
            return
        }
        if(AddOrEdit>=0){
            //编辑
            Show_ModuleList[AddOrEdit].text = _title
            Show_ModuleList[AddOrEdit].index = parseInt(_sort) || 1;
            Show_ModuleList[AddOrEdit].cont = _cont;
            Show_ModuleList[AddOrEdit].isDH = _DH;
            var _thisListIndex = Show_ModuleList[AddOrEdit].listIndex;
            changeListDataStatue(_DH,Show_ModuleList[AddOrEdit],AddOrEdit);
            createShow_Module();
            $(".templateItem li").each(function(){
                var _theListIndex = $(this).attr("allindex");
                if(_thisListIndex == _theListIndex){
                    $(this).addClass("active");
                }else{
                    $(this).removeClass("active");
                }
            });
            layer.msg("保存成功")
        }else{
            //创建
            var errorMsg = "";
            $(".navShow tbody tr").each(function(){
                var _theText = $(this).find("input.txt_in").eq(0).val(); //获取当前行的，文本
                var _theSort = $(this).find("input.txt_in").eq(1).val(); //获取当前行的，排序
                if(_theText == _title){
                    errorMsg = "存在相同名称的模板板块";
                }
                if(_theSort == _sort){
                    errorMsg = "导航排序不能重复";
                }
            });
            if(errorMsg==""){
                NewItem.text = _title;
                NewItem.index = parseInt(_sort) || 1;
                NewItem.cont = _cont;
                NewItem.isDH = _DH;
                NewItem.canDelete = 'true';
                NewItem.listIndex = All_Modulelist.length;
                All_Modulelist.push(NewItem);
                All_Modulelist = jsonSort(All_Modulelist,"index",false);
                Show_ModuleList.push(NewItem);
                createShow_Module();
                showAll_Modulelist();
                layer.msg("保存成功")
            }else{
                layer.msg(errorMsg);
            }
        }
        return true;
    });
    //点击确认 "导航展示顺序管理"
    $(".sortNav").click(function(){
        All_Modulelist = [],Show_ModuleList=[],Hide_moduleList = [];
        var _checkTitle = [],_checkSort = [] , errormsg = "";
        $(".navShow tbody tr").each(function(){
            var ItemJson = {"text":"","index":0,"cont":"","isDH":true,"isShow":false};
            var _theText = $(this).find("input.txt_in").eq(0).val(); //标题
            var _theIndex = $(this).find("input.txt_in").eq(1).val(); //排序
            var _theCont = $(this).find(".template_text").eq(0).val();//内容
            var _theCanDelete = $(this).attr("candelete") || false;
            var _title = $(".releaseEvents input[name='column']").val(); //栏目名称
            var _sort = $(".releaseEvents input[name='sort']").val(); //导航排序
            _theCont = _theCont.replace(/[\n]/g,"");
            var _theDH =  $(this).find("select.sel").eq(0).val() == "1" ? true : false; //是否显示导航
            ItemJson.text = _theText;
            ItemJson.index = parseInt(_theIndex) || 1;
            ItemJson.listIndex = $(this).index();
            ItemJson.cont = _theCont;
            ItemJson.isDH = _theDH;
            // if(_theText == _title){
            //     layer.msg("存在相同名称的模板板块");
            // }
            // if(_theIndex == _sort){
            //     layer.msg("导航排序不能重复");
            // }
            if(errormsg==""){
                if(_checkTitle.length<1){
                    _checkTitle.push(_theText);
                    _checkSort.push(_theIndex);
                }else{
                    var _checkTitleInfos = "__"+_checkTitle.join("__");
                    _checkTitleInfos += "__";
                    if(_checkTitleInfos.indexOf("__"+_theText+"__")>=0){
                        errormsg = "存在重复的导航名称，请修改后再进行确认";
                    }
                    _checkTitle.push(_theText);
                    var _checkSortInfos = "__"+_checkSort.join("__");
                    _checkSortInfos += "__";
                    if(_checkSortInfos.indexOf("__"+_theIndex+"__")>=0){
                        errormsg = "导航排序有重复，请修改后再进行确认";
                    }
                    _checkSort.push(_theIndex);
                }
                ItemJson.canDelete = _theCanDelete;
                All_Modulelist.push(ItemJson);
                if(_theDH){
                    Show_ModuleList.push(ItemJson);
                }else{
                    Hide_moduleList.push(ItemJson);
                }
            }
        });
        if(errormsg!=""){
            layer.msg(errormsg);
            return false;
        }
        All_Modulelist = jsonSort(All_Modulelist,"index",false);
        createShow_Module();
        createHide_Module();
        showAll_Modulelist();
    });
    layui.use("layedit", function(){
        var layedit = layui.layedit;
        //构建一个默认的编辑器
        var index = layedit.build("editor2",{
            tool: ["Bold","italic","underline","strikeThrough","|","face", "link", "unlink", "|", "left", "center", "right"]
        });
    });
    //初始化文本编辑器
    $('#content_editor').summernote({
        height: 200,
        lang: 'zh-CN'
    });
    //一键设置
    $(".setBtn").click(function () {
        $(this).hide();
        $(".sortNav").show();
        $(".navShow").show();
    });
    //一键设置确认的切换
    $(".sortNav").click(function(){
        $(this).hide();
        $(".setBtn").show();
        $(".navShow").hide();
    });
    //logo图的删除
    $("body").on("click", ".tournBan .delete", function () {
        $(this).parents(".tournBan").remove();
        removeFile($(this).parents(".tournBan").find(".fileId").attr("value"));
    })
    //初始化
    InitModuleList();
</script>

<script>
    //自定义字段
    $(".moreChoos-Iitem span").click(function () {
        var _index=parseInt(Math.random()*10000);//生成随机数
        //获取文本框类型
        var type = $(this).attr("type");
        //获取文本名称
        var addItem = $(this).attr('data-name');
        var singleShow= $(".moreChoose span[data-name=" + addItem + "]").eq(0).attr("draggable");
        var addSex="性别";
        switch (type) {
            case 'text':
                if(singleShow===undefined){
                    var strVar = "";
                    strVar += "<dl data-name='"+ addItem+"'>\n";
                    strVar += "<input type=\"hidden\" name=\"field["+_index+"][id]\" value=\"\">\n";
                    strVar += "    <dt><label><input type=\"checkbox\" class=\"chk\" name=\"field["+_index+"][is_required]\"/> 必填</label>" + addItem + "：<\/dt>\n";
                    strVar += "     <input type=\"hidden\" name=\"field["+_index+"][field_type]\" value=\"text\">\n";
                    strVar += "  <dd>\n";
                    strVar += "    <input type=\"text\" maxlength=\"9\" class=\"text_in\" value='" + addItem + "' name=\"field["+_index+"][title]\">\n";
                    strVar += "    <i class=\"delete iconfont\" val_id=\"\">&#xe68e;<\/i>\n";
                    strVar += "  <\/dd>\n";
                    strVar += "<\/dl>\n";
                    $(".definedTem").append(strVar)
                }
                break;
            case 'upload':
                if(singleShow===undefined){
                    var strVar = "";
                    strVar += "<dl data-name='"+ addItem+"'>\n";
                    strVar += "<input type=\"hidden\" name=\"field["+_index+"][id]\" value=\"\">\n";
                    strVar += "    <dt><label><input type=\"checkbox\" class=\"chk\" name=\"field["+_index+"][is_required]\"/> 必填</label>" + addItem + "：<\/dt>\n";
                    strVar += "<input type=\"hidden\" name=\"field["+_index+"][field_type]\" value=\"upload\">\n";
                    strVar += "  <dd>\n";
                    strVar += "    <input type=\"text\" maxlength=\"9\" class=\"text_in\" value='" + addItem + "' name=\"field["+_index+"][title]\">\n";
                    strVar += "    <i class=\"delete iconfont\" val_id=\"\">&#xe68e;<\/i>\n";
                    strVar += "  <\/dd>\n";
                    strVar += "<\/dl>\n";
                    $(".definedTem").append(strVar)
                }
                break;
            case 'radio':
                if(singleShow===undefined){
                    var strVarD = "";
                    strVarD += "<dl data-name='"+ addItem+"'>\n";
                    strVarD += "<input type=\"hidden\" name=\"field["+_index+"][id]\" value=\"\">\n";
                    strVarD += "                                        <dt>\n";
                    strVarD += "                                            <label><input type=\"checkbox\" class=\"chk\" name=\"field["+_index+"][is_required]\"/> 必填</label>" + addItem + "：\n";
                    strVarD += "                                        <\/dt>\n";
                    strVarD += "<input type=\"hidden\" name=\"field["+_index+"][field_type]\" value=\"radio\">\n";
                    strVarD += "                                        <dd>\n";
                    strVarD += "                                            <input type=\"text\" maxlength=\"9\" class=\"text_in\" value='" + addItem + "' name=\"field["+_index+"][title]\"/>\n";
                    strVarD += "                                              <i class=\"delete iconfont\" val_id=\"\">&#xe68e;<\/i>\n";
                    strVarD += "                                            <div class=\"addOption\">\n";
                    strVarD += "                                                <label>\n";
                    strVarD += "                                                    <input type=\"radio\" name=\"radio\" class=\"radioBtn\" />\n";
                    strVarD += "                                                    <input type=\"text\" maxlength=\"9\" class=\"txt\" name=\"field["+_index+"][value][]\"/>\n";
                    strVarD += "                                                    <i class=\"deleteAdd iconfont\" title=\"删除\"><\/i>\n";
                    strVarD += "                                                <\/label>\n";
                    strVarD += "                                                <label>\n";
                    strVarD += "                                                    <input type=\"radio\"name=\"radio\" class=\"radioBtn\" />\n";
                    strVarD += "                                                    <input type=\"text\" maxlength=\"9\" class=\"txt\" name=\"field["+_index+"][value][]\"/>\n";
                    strVarD += "                                                    <i class=\"deleteAdd iconfont\" title=\"删除\"><\/i>\n";
                    strVarD += "                                                <\/label>\n";
                    strVarD += "                                            <\/div>\n";
                    strVarD += "                                        <\/dd>\n";
                    strVarD += "                                    <\/dl>\n";
                    $(".definedTem").append(strVarD);
                }
                break;
        }
    });
    $(".moreChoos-Iitem1 span").click(function () {
        var _index=parseInt(Math.random()*10000);//生成随机数
        //获取文本框类型
        var type = $(this).attr("type");
        //获取文本名称
        var addItem = $(this).attr('data-name');
        switch (type) {
            case 'text':
                var strVar = "";
                strVar += "<dl data-name='"+ addItem+"'>\n";
                strVar += "<input type=\"hidden\" name=\"field["+_index+"][id]\" value=\"\">\n";
                strVar += "    <dt><label><input type=\"checkbox\" class=\"chk\" name=\"field["+_index+"][is_required]\"/> 必填</label>" + addItem + "：<\/dt>\n";
                strVar += "     <input type=\"hidden\" name=\"field["+_index+"][field_type]\" value=\"text\">\n";
                strVar += "  <dd>\n";
                strVar += "    <input type=\"text\" maxlength=\"9\" class=\"text_in\" value='" + addItem + "' name=\"field["+_index+"][title]\">\n";
                strVar += "    <i class=\"delete iconfont\" val_id=\"\">&#xe68e;<\/i>\n";
                strVar += "  <\/dd>\n";
                strVar += "<\/dl>\n";
                $(".definedTem").append(strVar);
                break;
            case 'upload':
                var strVar = "";
                strVar += "<dl data-name='"+ addItem+"'>\n";
                strVar += "<input type=\"hidden\" name=\"field["+_index+"][id]\" value=\"\">\n";
                strVar += "    <dt><label><input type=\"checkbox\" class=\"chk\" name=\"field["+_index+"][is_required]\"/> 必填</label>" + addItem + "：<\/dt>\n";
                strVar += "<input type=\"hidden\" name=\"field["+_index+"][field_type]\" value=\"upload\">\n";
                strVar += "  <dd>\n";
                strVar += "    <input type=\"text\" maxlength=\"9\" class=\"text_in\" value='" + addItem + "' name=\"field["+_index+"][title]\">\n";
                strVar += "    <i class=\"delete iconfont\" val_id=\"\">&#xe68e;<\/i>\n";
                strVar += "  <\/dd>\n";
                strVar += "<\/dl>\n";
                $(".definedTem").append(strVar);
                break;
            case 'textarea':
                var strVar = "";
                strVar += "<dl data-name='"+ addItem+"'>\n";
                strVar += "<input type=\"hidden\" name=\"field["+_index+"][id]\" value=\"\">\n";
                strVar += "    <dt><label><input type=\"checkbox\" class=\"chk\" name=\"field["+_index+"][is_required]\"/> 必填</label>" + addItem + "：<\/dt>\n";
                strVar += "<input type=\"hidden\" name=\"field["+_index+"][field_type]\" value=\"textarea\">\n";
                strVar += "  <dd>\n";
                strVar += "    <input type=\"text\" maxlength=\"9\" class=\"text_in\" value='" + addItem + "' name=\"field["+_index+"][title]\">\n";
                strVar += "    <i class=\"delete iconfont\" val_id=\"\">&#xe68e;<\/i>\n";
                strVar += "  <\/dd>\n";
                strVar += "<\/dl>\n";
                $(".definedTem").append(strVar);
                break;
            case 'radio':
                var strVarD = "";
                strVarD += "<dl data-name='"+ addItem+"'>\n";
                strVarD += "<input type=\"hidden\" name=\"field["+_index+"][id]\" value=\"\">\n";
                strVarD += "                                        <dt>\n";
                strVarD += "                                            <label><input type=\"checkbox\" class=\"chk\" name=\"field["+_index+"][is_required]\"/> 必填</label>" + addItem + "：\n";
                strVarD += "                                        <\/dt>\n";
                strVarD += "<input type=\"hidden\" name=\"field["+_index+"][field_type]\" value=\"radio\">\n";
                strVarD += "                                        <dd>\n";
                strVarD += "                                            <input type=\"text\" maxlength=\"9\" class=\"text_in\" value='" + addItem + "' name=\"field["+_index+"][title]\"/>\n";
                strVarD += "                                              <i class=\"delete iconfont\" val_id=\"\">&#xe68e;<\/i>\n";
                strVarD += "                                            <div class=\"addOption\">\n";
                strVarD += "                                                <label>\n";
                strVarD += "                                                    <input type=\"radio\" name=\"radio\" class=\"radioBtn\" />\n";
                strVarD += "                                                    <input type=\"text\" maxlength=\"9\" class=\"txt\" name=\"field["+_index+"][value][]\"/>\n";
                strVarD += "                                                    <i class=\"deleteAdd iconfont\" title=\"删除\"><\/i>\n";
                strVarD += "                                                <\/label>\n";
                strVarD += "                                                <label>\n";
                strVarD += "                                                    <input type=\"radio\"name=\"radio\" class=\"radioBtn\" />\n";
                strVarD += "                                                    <input type=\"text\" maxlength=\"9\" class=\"txt\" name=\"field["+_index+"][value][]\"/>\n";
                strVarD += "                                                    <i class=\"deleteAdd iconfont\" title=\"删除\"><\/i>\n";
                strVarD += "                                                <\/label>\n";
                strVarD += "                                                <i class=\"iconfont addDMore\" the_index="+_index+">&#xe61c;<\/i>\n";
                strVarD += "                                            <\/div>\n";
                strVarD += "                                        <\/dd>\n";
                strVarD += "                                    <\/dl>\n";
                $(".definedTem").append(strVarD);
                break;
            case 'checkbox':
                var strVarM = "";
                strVarM += "<dl data-name='"+ addItem+"'>\n";
                strVarM += "        <input type=\"hidden\" name=\"field["+_index+"][id]\" value=\"\">\n";
                strVarM += "        <dt>\n";
                strVarM += "               <label><input type=\"checkbox\" class=\"chk\" name=\"field["+_index+"][is_required]\"/> 必填</label>" + addItem + "：\n";
                strVarM += "        <\/dt>\n";
                strVarM += "        <input type=\"hidden\" name=\"field["+_index+"][field_type]\" value=\"checkbox\">\n";
                strVarM += "        <dd>\n";
                strVarM += "            <input type=\"text\" maxlength=\"9\" class=\"text_in\" name=\"field["+_index+"][title]\" value='" + addItem + "'/>\n";
                strVarM += "            <i class=\"delete iconfont\" val_id=\"\">&#xe68e;<\/i>\n";
                strVarM += "                 <div class=\"addOption\">\n";
                strVarM += "                     <label>\n";
                strVarM += "                           <input type=\"checkbox\" />\n";
                strVarM += "                           <input type=\"text\" maxlength=\"9\" class=\"txt\" name=\"field["+_index+"][value][]\"/>\n";
                strVarM += "                           <i class=\"deleteAdd iconfont\" title=\"删除\"><\/i>\n";
                strVarM += "                     <\/label>\n";
                strVarM += "                     <label>\n";
                strVarM += "                          <input type=\"checkbox\" />\n";
                strVarM += "                          <input type=\"text\" maxlength=\"9\" class=\"txt\" name=\"field["+_index+"][value][]\"/>\n";
                strVarM += "                              <i class=\"deleteAdd iconfont\" title=\"删除\"><\/i>\n";
                strVarM += "                     <\/label>\n";
                strVarM += "                 <i class=\"iconfont addMore\" the_index="+_index+">&#xe61c;<\/i>\n";
                strVarM += "            <\/dd>\n";
                strVarM += " <\/dl>\n";
                $(".definedTem").append(strVarM);
                break;
        }
    });
    // 单项选择
    $("body").on("click", ".addOption .addDMore", function () {
        var _index =  $(this).attr('the_index');
        var strVarA = "";
        strVarA += "<label class=\"addSingle\">\n";
        strVarA += "      <input type=\"radio\"name=\"radio\" class=\"radioBtn\" />\n";
        strVarA += "      <input type=\"text\" maxlength=\"9\" class=\"txt\" name=\"field["+_index+"][value][]\"/>\n";
        strVarA += "      <i class=\"deleteAdd iconfont\" title=\"删除\"><\/i>\n";
        strVarA += "<\/label>\n";
        $(this).before(strVarA)
    })
    // 多项选择
    $("body").on("click", ".addOption .addMore", function () {
        var _index =  $(this).attr('the_index');
        var strVarA = "";
        strVarA += "<label class=\"multiterm\">\n";
        strVarA += "      <input type=\"checkbox\"name=\"checkbox\" class=\"checkBtn\" />\n";
        strVarA += "      <input type=\"text\" maxlength=\"9\" class=\"txt\" name=\"field["+_index+"][value][]\"/>\n";
        strVarA += "      <i class=\"deleteAdd iconfont\" title=\"删除\"><\/i>\n";
        strVarA += "<\/label>\n";
        $(this).before(strVarA)
    })

    // 删除添加单项元素
    $("body").on("click", ".addSingle .deleteAdd", function () {
        $(this).parents(".addSingle").remove();
    })

    // 删除添加单项元素
    $("body").on("click", ".multiterm .deleteAdd", function () {
        $(this).parents(".multiterm").remove();
    })

    // 报名信息js
    $(".moreChoos-Iitem").on("click", "span", function () {
        $(this).addClass("active");
        $(this).eq(0).attr("draggable","false");
    })
    $(".moreChoos-Iitem1").on("click", "span", function () {
        $(this).addClass("active");
    })
    // 第三步表单的显示隐藏
    $(".userDefined .upItem").click(function () {
        $(this).hide();
        $(".userDefined-Main").show();
        $(".userDefined .downItem").show();
    })
    $(".userDefined .downItem").click(function () {
        $(this).hide();
        $(".userDefined-Main").hide();
        $(".userDefined .upItem").show();
    })
    // 删除添加元素
    $(".definedTem").on("click", "dl .delete", function () {
        var addItem = $(this).parents('dl').eq(0).attr("data-name");
        //获取是否有字段id
        var field_id = $(this).attr('val_id');
        var _this = $(this)
        if(field_id == ''){
            //说明是新增的表单字段
            $(this).parents("dl").remove();
            $(".moreChoos-Iitem span[data-name=" + addItem + "],.moreChoos-Iitem1 span[data-name=" + addItem + "]").removeClass("active");
            $(".moreChoos-Iitem span[data-name=" + addItem + "]").removeAttr("draggable");
        }else{
            //说明是原有的表单字段
            layer.confirm('确定要删除该字段吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var tmp_id = "{{isset($id)?$id:''}}";//活动id
                var url = "{{URL::action('Admin\ArticleTmpController@isAbleDelField')}}";  //url路由
                var _token = "{{csrf_token()}}";
                //请求后台进行删除
                $.ajax({
                    url:url,
                    type:'get',
                    dataType:'json',
                    data:{'_token':_token,'tmp_id':tmp_id,'field_id':field_id },
                    success:function(data){
                        if(data.status == 1){
                            layer.msg(data.info);
                            //移除DOM
                            _this.parents("dl").remove();
                            $(".moreChoos-Iitem span[data-name=" + addItem + "],.moreChoos-Iitem1 span[data-name=" + addItem + "]").removeClass("active");
                            $(".moreChoos-Iitem span[data-name=" + addItem + "]").removeAttr("draggable");
                        }else{
                            layer.msg(data.info);
                        }
                    }
                })
            })
        }
    })
</script>
<script>
    //ajax提交 [创建 && 编辑]
    $(".ajax").click(function () {
        var the_form=$(this).parents('form').eq(0);
        var form_url = the_form.attr('action');
        $.post(form_url,$("#form1").serialize(),function (data) {
            if(data.status==201 || data.status==0){
                layer.msg(data.info);
                return
            }
            if(data.status==200){
                layer.msg(data.info);
                setTimeout(function () {
                    window.location.href=data.url
                },2000);
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