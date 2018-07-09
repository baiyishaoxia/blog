/*
* @Author: tangzhifu <2273465837@qq.com>
* @Date:   2018-06-16 13:11:36
* @Last Modified by:   tangzhifu
* @Last Modified time: 2018-06-16 19:21:15
*/

//刷新当前页面
function load() {
    location.reload();
}

//全选取消按钮函数
function checkAll(chkobj) {
    if ($(chkobj).text() == "全选") {
        $(chkobj).children("span").text("取消");
        $(".checkall input:enabled").prop("checked", true);
    } else {
        $(chkobj).children("span").text("全选");
        $(".checkall input:enabled").prop("checked", false);
    }
}

