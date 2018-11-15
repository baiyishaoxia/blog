
$(function(){
    //

    //入驻删除
    $(".fixed-left .close").click(function(){
        $(".fixed-left").remove();

    })
   //广告位导航删除
   $(".activeTop .closeds").click(function () {
       $(".activeTop").hide();
       $(".cch-header").css("top","0px")
   })
   //导航定位
   if ($(".cch-header").size() > 0) {
        $(window).scroll(function () {
            var _theScrollTop = $(window).scrollTop();
            if (_theScrollTop > 80) {
                $(".cch-header").addClass("curr");
                $(".cch-interval").css("height","80px");
            } else {
                $(".cch-header").removeClass("curr");
                $(".cch-interval").css("height","0px");
            }
        })
    }
    //会员中心左侧导航定位
    var _footer=$(".footer").outerHeight()+25;
    if ($(".m_wapper .m_side").length > 0) {
        $('.m_wapper .m_side ul').scrollFix({
            distanceTop:80,
            startTop: ".m_wapper",
            endPos: _footer,
            zIndex: 100
        })
    }
    if ($(".datetimepicker").length > 0) {
        $('.datetimepicker').datetimepicker({
            timepicker: false,
            scrollMonth: false,
            format: 'Y-m-d'
        })
    }
    //成立时间限制
    if ($(".team_time").length > 0) {
        var datenow = new Date();
            datenow = datenow.getFullYear() + "-" + (datenow.getMonth() + 1) + "-" + (datenow.getDate());
        $('.team_time').datetimepicker({
            timepicker: false,
            scrollMonth: false,
            format: 'Y-m-d',
            maxDate: datenow
        })
    }
    //赛程安排js
    $(".time-progre li").hover(function () {
        var index=$(this).index();
        $(this).addClass("curr").siblings("li").removeClass("curr");
        $(".arrange li").eq(index).addClass("curr").siblings("li").removeClass("curr");
    })



$(".is_match_apply").click(function () {
    var mach_url = $(".is_match_apply").attr('url');
    $.get(mach_url,function (request) {
            var obj = request;
            if (obj.state == '201'){
                //失败
                layer.open({
                    type:1,
                    title: "提示",
                    shadeClose:true,
                    area: ['500px', '260px'],
                    content: $('#error_tip')
                });
            }else if(obj.state == '203'){
                //失败
                layer.open({
                    type:1,
                    title: "提示",
                    shadeClose:true,
                    area: ['500px', '260px'],
                    content: $('#error_tip')
                });
            }
            else if(obj.state == '204'){
                //成功
                layer.open({
                    type:1,
                    title: "提示",
                    shadeClose:true,
                    area: ['500px', '260px'],
                    content: $('#success_tip')
                });
            }else if(obj.state == '205'){
                //失败
                layer.open({
                    type:1,
                    title: "提示",
                    shadeClose:true,
                    area: ['500px', '260px'],
                    content: $('#success_tip')
                });
            }
            else{
                    parent.window.location.href=obj.url;
            }
        });
});

        $(".click_product").click(function(){
            var _this=$(this);
            if(_this.attr("statue")=="true"){

            }else{
                _this.attr("statue","true")
                var url = $(this).attr('url');
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(data) {
                        data = jQuery.parseJSON(data)
                        if (data.status == '200') {
                            window.location.href = data.url;
                        }
                        if (data.status == '201'){
                            var strVar = "";
                                strVar += "<div class=\"layer_intro\">\n";
                                strVar += "    <p>\n";
                                strVar += "       为充分保障参赛选手的信息安全，因此每位用户只能查看个别项目成果\n";
                                strVar += "    <\/p><a href='"+data.url+"' class='yes iknow'>寻找投资机构</a>\n";
                                strVar += "<\/div>\n";
                            layer.open({
                                type: 1,
                                title: false,
                                area: ['500px', '250px'],
                                content: strVar,
                                end:function(){
                                    _this.attr("statue","false")
                                }
                            });
                            return
                        }
                        if (data.status == '204'){
                            var strVar = "";
                                strVar += "<div class=\"layer_intro\">\n";
                                strVar += "    <p>\n";
                                strVar += "        为充分保障参赛选手的信息安全，每个认证投资人最多只可以查看三个创新成果,如有疑问，请联系工作人员！\n";
                                strVar += "    <\/p><a href='javascript:void(0);' class='yes iknow'>我知道了</a>\n";
                                strVar += "<\/div>\n";
                            layer.open({
                                type: 1,
                                title: false,
                                area: ['500px', '250px'],
                                content: strVar,
                                end:function(){
                                    _this.attr("statue","false")
                                }
                            });
                            return
                        }
                        if (data.status == '202'){
                            layer.msg(data.respond);
                        }
                        if (data.status == '203'){
                            var html = '<div class="layer_intro" >'+
                                '    <p>'+
                                '        为充分保障参赛选手的信息安全，因此只有平台上的<br>'+
                                "        <a href='"+data.url+"'>认证投资人</a>才可以拥有创新成果的浏览权"+
                                '    </p>'+
                                '    <a href="'+data.url+'" class="yes">去认证投资人</a>'+
                                '</div>';
                            layer.open({
                                type: 1,
                                title: false,
                                area: ['500px', '250px'],
                                content: html,
                                end:function(){
                                    _this.attr("statue","false")
                                }
                            });
                            return
                        }
                    }
                });
            }
        
        });
        $("body").on("click",".layer_intro .iknow",function(){
            layer.closeAll()
        })
    // 五大赛区报名特效 
    $(".advert_bottom .colosed").click(function(){
        $(".advert_bottom").animate({
            "margin-left": "-100%"
        }, function() {
           $(".advert_bottom").hide();
           $(".bottom-warp").show();
        })
        setCookie("adverts", "false");
    })

   var adverts = getCookie("adverts");
   if(adverts=="false"){
       $(".advert_bottom").hide();
       $(".bottom-warp").show();
   }else{
    $(".advert_bottom").show();
    $(".bottom-warp").hide();
   }

    $(".bottom-warp").click(function(){
        $(".bottom-warp").hide();
        $(".advert_bottom").show();
        $(".advert_bottom").animate({
            "margin-left": "0"
        })
        clearCookie("adverts");
    })


	 $(window).scroll(function () {
	 	 //右侧悬浮窗
        if ($(this).scrollTop() > 200) {
            $('.moduleWrap .goto-top').show();
        } else {
            $('.moduleWrap .goto-top').hide();
        }
          //新闻详情定位
          var div_scroll=$(this).scrollTop();

        if($(".m_New_right").size()>0) {
            var m_New_item = $(".m_New_right").offsetTop;
            if (div_scroll > m_New_item) {
                $(".m_New_item").addClass("curr");
            } else {
                $(".m_New_item").removeClass("curr");
            }
        }
	 })
	
	 //滚动到顶部
    $('.moduleWrap .goto-top').click(function () {
        $('html,body').animate({ "scrollTop": "0" })
    })
	//赛区负责人弹框
	$(".leading_official").on("click",".yes",function(){
		$(".leading_official").removeClass("curr");
	})
	$(".footer .backingfor a.zone").click(function(){
		$(".leading_official1").addClass("curr");
	})
	
    //返回頂部
    $(".pendant_cont .bottom a").click(function(){
        $("html,body").animate({scrollTop:0},500);
    })

    //右侧挂件的点击事件
    if($(".pendant_cont").size()>0){
        var pendant_slideCover = [null,'/home/images/wx.png','/home/web/images/wxgzh.png','/home/images/kefu.png'];
        //大赛微信群
        $(".pendant_cont .cont_infos a").mouseenter(function(){
            var _theIndex = $(this).index();
            var _linkUrl = pendant_slideCover[_theIndex] || null;
            if(_linkUrl){
                if($(this).find(".code_img").length>0){
                    $(this).find(".code_img").fadeIn();
                }else{
                    var _theStr = $("<div class='code_img'><img src='"+_linkUrl+"' /></div>");
                    $(this).append(_theStr);
                    $(this).find(".code_img").fadeIn();
                }
            }
        }).mouseleave(function(){
            $(this).find(".code_img").hide();
        })
    }
	//首页大赛时间
	// var myDate = new Date();
	// var moth=myDate.getMonth()+1;
	// if(moth==6){
	// 	$(".time-progre li").eq(2).addClass("curr").siblings("li").removeClass("curr");
	// }else if(moth==7){
	// 	$(".time-progre li").eq(3).addClass("curr").siblings("li").removeClass("curr");
	// }else if(moth==8){
	// 	$(".time-progre li").eq(4).addClass("curr").siblings("li").removeClass("curr");
	// }
	
	//筛选点击更多
	 $(".m_type_list .m_type_more").click(function () {
        if ($(this).hasClass("curr")) {
            $(this).siblings(".m_type_mold_chose").css("height", "35px");
            $(this).removeClass("curr");
        } else {
            $(this).siblings(".m_type_mold_chose").css("height", "auto");
            $(this).addClass("curr");
        }
    })
	
	//筛选选中颜色
	$(".m_type_cont li .m_type_mold_chose a").click(function(){
		$(this).addClass("active");
		$(this).siblings().removeClass("active");
	})
	
	//点击城市区号切换
	$(".changeCity .dropdown-menu li").click(function(){
		var number=$(this).find("a").attr("value");
		var text=$(this).text();
		$(".citynumber").val(number);
		$(this).parents(".changeCity").find(".dropdown-toggle span").text(text);
	})
	
    //bootstrap下拉重定义
    $(".dropdown-toggle").click(function () {
        
        if ($(this).parent().hasClass("open")) {
            $(this).parent().removeClass("open");
        } else {
            $(this).parent().addClass("open");
        }
       
    })

    $(document).bind('click', function () {
        if ($(".dropdown-toggle").parent().hasClass("open")) {
            $(".dropdown-toggle").parent().removeClass("open");
        }
    });

    $(".dropdown-toggle").bind('click', function (e) {
        stopPropagation(e);
    });
   
	  /**
	 * @content 首页轮播图
	 */
	if($(".idx-banner .swiper-container").size()>0){
		var _WindowWidth = $(window).width();
		  var idxBanner = new Swiper(".idx-banner .swiper-container", {
	        paginationClickable: true,
	        loop: true,
	        autoplay: 3000,
	        width: _WindowWidth,
	        height: 570,
	        pagination: '.pagination2'

	    });
         $(".idx-banner .swiper-container").mouseenter(function () {
            idxBanner.stopAutoplay();//停止滚动
        }).mouseleave(function () {
            idxBanner.startAutoplay();//开始滚动
        })
	}
    if($(".swiper-container2").size()>0){
        var _WindowWidth = $(window).width();
        var idxBanner2 = new Swiper(".swiper-container2", {
            paginationClickable: true,
            loop: true,
            autoplay: 3000,
            width: _WindowWidth,
            height: 360,
            pagination: '.swiper-container2 .pagination2'

        });
        $(".swiper-container2").mouseenter(function () {
            idxBanner2.stopAutoplay();//停止滚动
        }).mouseleave(function () {
            idxBanner2.startAutoplay();//开始滚动
        })
    }
    /**
	 * @content 首页公告信息
	 */
	// if($(".noticlist .swiper-container").size()>0){
	//     var noticlist = new Swiper(".noticlist .swiper-container", {
	//         slidesPerView: 4,
	//         mode: "vertical",
	//         loop: true,
	//         autoplay: 2000,
	//         autoplayDisableOnInteraction:false //操作后不禁止自动
	//     });
	// 	 $(".noticlist .swiper-container").mouseenter(function () {
    //         noticlist.stopAutoplay();//停止滚动
    //     }).mouseleave(function () {
    //         noticlist.startAutoplay();//开始滚动
    //     })
	// }
    var timer1;
    if ($(".noticlist li").length > 4) {
        var listPanel2 = $(".noticlist ul");
        var z = 0;
        timer1 = setInterval(function () {
            listPanel2.animate({
                "top": (z - 35) + 'px'
            }, 1000, function () {
                listPanel2.css({ 'top': '0px' });
                listPanel2.find("li:first").appendTo(listPanel2);
            })
        }, 2000)
        $(".noticlist").hover(function () {
            clearInterval(timer1);
        }, function () {
            timer1 = setInterval(function () {
                listPanel2.animate({
                    "top": (z - 35) + 'px'
                }, 1000, function () {
                    listPanel2.css({ 'top': '0px' });
                    listPanel2.find("li:first").appendTo(listPanel2);
                })
            }, 2000)
        })

    }
	/**
	 * @content 专项赛轮播
	 */
    if($(".spe-banner .swiper-container").size()>0) {
        var _WindowWidth = $(window).width();
        var speBanner = new Swiper(".spe-banner .swiper-container", {
            paginationClickable: true,
	        loop: true,
	        autoplay: 3000,
	        width: _WindowWidth,
	        height: 570,
	        pagination: '.pagination'
        });
         $(".spe-banner .swiper-container").mouseenter(function () {
            speBanner.stopAutoplay();//停止滚动
        }).mouseleave(function () {
            speBanner.startAutoplay();//开始滚动
        })
    }

    
    /**
	 * @content 大赛简介地图
	 */
    if($('.arealist').size()>0){
        $(".arealist li").mouseover(function(){
            var area = $(this).attr('are');
            $(this).addClass('curr').siblings().removeClass('curr');
            $('.m-acrtive').attr('class','m-acrtive '+area).fadeIn();
            var currdot = $(".dot-pos .dot." + area);
            currdot.addClass('curr').siblings().removeClass('curr');
            currdot.find('.dot-cd').show().animate({
                opacity:1,
                left:'-285px'
            },400);
            currdot.siblings(".dot").find(".dot-cd").css({
                display:'none',
                left:'-300px'
            });
        })
        $(".dot-pos .dot").mouseover(function(){
           var cls = $(this).attr('class');
           cls = cls.replace("dot ",'');
           $('.m-acrtive').attr('class','m-acrtive '+cls).fadeIn();
        }).mouseout(function(){
            $(".m-acrtive").attr("class", "m-acrtive").hide();
        });
        $(".arealist").mouseout(function(){
            $(".dot.curr .dot-cd").css({ display: "none", left: "-300px" });
            $(".arealist li,.dot-pos .dot").removeClass('curr'); 
            $(".m-acrtive").attr("class", "m-acrtive").hide();
        });
    }
    /**
	 * @content 大赛简介 晋级流程
	 */
    $(".process-match .time_line_list li").mouseover(function(){
        $(this).addClass('curr').siblings('li').removeClass('curr');
        var idx = $(this).index();
        $(".cont-list").find('li').eq(idx).addClass('curr').siblings('li').removeClass('curr');
    });
    
     /**
	 * @content 赛事公告
	 */
    if($(".announcement_thumb").size()>0){
        
        setInterval(function(){
            $(".announcement_thumb ul li.last").click();
        },3500)

        var ClickState = true;
        $(".announcement_thumb li").click(function(){
            if(ClickState){
                ClickState = false;
                var _theIndex = $(this).index();
                var _theClass = $(this).attr("class");
                var _this = $(this);
                if(_theClass=="first"){
                    var lastEl = $(".announcement_thumb li.last").eq(0);
                    lastEl.addClass("lasttoend");
                    $(".announcement_thumb li.curr").addClass("currtolast");
                    $(this).addClass("firsttocurr");

                    if(_theIndex ==0){
                        $(".announcement_thumb li:last").removeAttr("class").addClass("litofirst");
                    }else{
                        $(".announcement_thumb li:eq("+(_theIndex-1)+")").removeAttr("class").addClass("litofirst");
                    }

                    setTimeout(function(){
                        $(".announcement_thumb li.currtolast").removeClass("curr").removeClass("currtolast").addClass("last");
                        $(".announcement_thumb li.lasttoend").removeClass("last").removeClass("lasttoend");
                        $(".announcement_thumb li.firsttocurr").addClass("curr").removeClass("first").removeClass("firsttocurr");
                        $(".announcement_thumb li.litofirst").addClass("first").removeClass("litofirst");
                        ClickState = true;
                    },1000);
                }else if(_theClass=="last"){

                    $(".announcement_thumb li.first").addClass("firsttoend");
                    $(".announcement_thumb li.curr").addClass("currtofirst");
                    $(".announcement_thumb li.last").addClass("lasttocurr");

                    var _theIndex = $(this).index();
                    if(_theIndex== ($(".announcement_thumb li").length - 1)){
                        $(".announcement_thumb li:eq(0)").addClass("litolast");
                    }else{
                        $(this).next().addClass("litolast");
                    }

                    setTimeout(function(){
                        $(".announcement_thumb li.currtofirst").addClass("first").removeClass("curr").removeClass("currtofirst");
                        $(".announcement_thumb li.lasttocurr").removeClass("last").addClass("curr").removeClass("lasttocurr");
                        $(".announcement_thumb li.firsttoend").removeClass("first").removeClass("firsttoend");
                        $(".announcement_thumb li.litolast").removeClass("litolast").addClass("last");
                        ClickState = true;
                    },1000)

                }else{
                    ClickState = true;
                }
            }
        });
    }
	
	/**
	 * @content 浏览器IE兼容版本
	 */
	Compatible_Prompt();


     //placeholder判断
    var userAgent = navigator.userAgent;
    var IsIE = userAgent.toLowerCase().indexOf("msie");
    var UserLowerJQuery = true;
    if (IsIE >= 0) {
        var s = userAgent.match(/msie ([\d.]+)/ig) || [10];
        var banben = s[0].replace(/[^\d|.]/g, "");
        banben = Number(banben) || 10;

        //IE8 才需要处理 placeholder
        if (banben <= 10) {
            placeholderfun();
        }
    }
})
	

//阻止冒泡
function stopPropagation(e) {
    if (e.stopPropagation)
        e.stopPropagation();
    else
        e.cancelBubble = true;
}



/**
 * @content 浏览器IE兼容版本 
 * @param MinSub 最低兼容版本数  
 */
function Compatible_Prompt(MinSub) {
    if (MinSub == undefined) {
        MinSub = 9;
    }
    var agent = navigator.userAgent.toLowerCase();
    var regStr_ie = /msie [\d.]+;/gi;
    var regStr_ff = /firefox\/[\d.]+/gi
    var regStr_chrome = /chrome\/[\d.]+/gi;
    var regStr_saf = /safari\/[\d.]+/gi;
    var _theBrowser = null;
    //IE
    if (agent.indexOf("msie") > 0) {
        _theBrowser = agent.match(regStr_ie);
    }
    //firefox
    if (agent.indexOf("firefox") > 0) {
        _theBrowser = agent.match(regStr_ff);
    }
    //Chrome
    if (agent.indexOf("chrome") > 0) {
        _theBrowser = agent.match(regStr_chrome);
    }
    //Safari
    if (agent.indexOf("safari") > 0 && agent.indexOf("chrome") < 0) {
        _theBrowser = agent.match(regStr_saf);
    }
    if (_theBrowser != null && _theBrowser != undefined) {
        _theBrowser = _theBrowser.toString();
        var theIeLengthLength = _theBrowser.indexOf("msie");  //判断是否为IE浏览器  
    }
    if (theIeLengthLength >= 0) {  //是否为IE浏览器
        //获取浏览器的版本 
        var theBanben = _theBrowser.replace(/[^0-9.]/ig, "");

        theBanben = isNaN(Number($.trim(theBanben))) ? 9 : Number($.trim(theBanben));
        if (theBanben < MinSub) {
            //显示兼容信息
            ShowCompatibleLoyout();
        }
    }
}

/**
 * @content 提示弹窗信息  
 */
function ShowCompatibleLoyout() {
    var defaults = {
        title: "\u4F60\u77E5\u9053\u4F60\u7684Internet Explorer\u662F\u8FC7\u65F6\u4E86\u5417?", // title text
        text: "\u4E3A\u4E86\u5F97\u5230\u6211\u4EEC\u7F51\u7AD9\u6700\u597D\u7684\u4F53\u9A8C\u6548\u679C,\u6211\u4EEC\u5EFA\u8BAE\u60A8\u5347\u7EA7\u5230\u6700\u65B0\u7248\u672C\u7684Internet Explorer\u6216\u9009\u62E9\u53E6\u4E00\u4E2Aweb\u6D4F\u89C8\u5668.\u4E00\u4E2A\u5217\u8868\u6700\u6D41\u884C\u7684web\u6D4F\u89C8\u5668\u5728\u4E0B\u9762\u53EF\u4EE5\u627E\u5230.<br /><br />"
    };
    var Cover_layout = "<div class='layout_cover'></div>";
    var Cover_Content = "<span>" + defaults.title + "</span>"
				  + "<p> " + defaults.text + "</p>"
			      + "<div class='browser'>"
			      + "<ul>"
			      + "<li><a class='chrome' href='https://www.google.com/chrome/' target='_blank'></a></li>"
			      + "<li><a class='firefox' href='http://www.mozilla.org/en-US/firefox/new/' target='_blank'></a></li>"
			      + "<li><a class='ie9' href='http://windows.microsoft.com/en-US/internet-explorer/downloads/ie/' target='_blank'></a></li>"
			      + "<li><a class='safari' href='http://www.apple.com/safari/download/' target='_blank'></a></li>"
			      + "<li><a class='opera' href='http://www.opera.com/download/' target='_blank'></a></li>"
			      + "<ul>"
			      + "</div>";
    var Cover_Container = "<div class='layout_Contianer'>" + Cover_Content + "</div>";
    var w_height = $(window).height(); //窗口的高度

    var CompatibleContainer = "<div class='CompatibleContainer'>" + Cover_layout + Cover_Container + "</div>";
    if ($(".CompatibleContainer").size() < 1) {
        $("body").append($(CompatibleContainer));
    }

    $("#go_continue").click(function () {
        $(".CompatibleContainer").hide();
    });
}



function forward(obj){
    var id=$(obj).attr("site_match_id");
    var url=$("#seare").attr("url");
    $.get(url,{site_id:id}, function(result){
        if(result){
            var strVar = "";
                strVar += "        <p style='color: #afb3c3;'>"+result.title+"<\/p>\n";
                strVar += "        <p>负责人："+result.company+"<\/p>\n";
                strVar += "        <p>"+result.tel+"<\/p>\n";
                strVar += "        <p>"+result.email+"<\/p>\n";
                strVar += "        <a href=\"javascript:void(0);\" class=\"yes\">我知道了<\/a >\n";
            $(".leading_official2 .text").empty().append(strVar);
            $(".leading_official2").addClass("curr");
        }
    });


    
//     layer.alert('即将上线，敬请期待！', {
//     skin: 'layui-layer-lan'
//     ,closeBtn: 0
//     ,anim: 4 //动画类型
//   });
}


//placeholder
function placeholderfun() {

    if (!('placeholder' in document.createElement('input'))) {
        function GetStringNumValue(pxstr) {
            return pxstr.substring(0, pxstr.length - 2);
        }

        $('input[placeholder],textarea[placeholder]').each(function () {
            
            var $element = $(this),
            $elementH=$(this).height(),
            placeholder = $element.attr('placeholder');
            $('input[placeholder],textarea[placeholder]').parent().css("position","relative");
            if ($element.attr('type') != 'password') {//非密码
                 if ($element.val() === "") {
                    $element.val(placeholder).addClass('placeholder');
                    $element.css('color', '#999');
                }
                $element.focus(function () {
                    if ($element.val() === placeholder) {
                        $element.val("").removeClass('placeholder');
                        $element.css('color', '#999');
                    }
                }).blur(function () {
                    if ($element.val() === "") {   //if($element.val()==="" &&  ($element.attr('type') != 'password')){  
                        $element.val(placeholder).addClass('placeholder');
                        $element.css('color', '#999');
                    } else if ($element.val() == placeholder) {
                        $element.css('color', '#999');
                    } else {
                        $element.css('color', '#999');
                    }
                }).closest('form').submit(function () {
                    if ($element.val() === placeholder) {
                        $element.val('');
                    }
                });
                
                
            } else {//密码框
                if (placeholder) {
                    // 文本框ID
                    var elementId = $element.attr('id');
                    if (!elementId) {
                        var now = new Date();
                        elementId = 'lbl_placeholder' + now.getSeconds() + now.getMilliseconds();
                        $element.attr('id', elementId);
                    }
                }//end of if (placeholder)
                // 添加label标签，用于显示placeholder的值
                var $label = $('<label>', {
                    html: $element.val() ? '' : placeholder,
                    'for': elementId,
                    css: {
                        position: 'absolute',
                        cursor: 'text',
                        color: '#999',
                        left:'0px',
                        fontSize: $element.css('fontSize'),
                        fontFamily: $element.css('fontFamily')
                    }
                }).insertAfter($element);
                // 绑定事件
                var _setPosition = function () {
                    $label.css({
                        "line-height": $elementH+'px',
                        marginLeft: '10px'
                    });
                };
                var _resetPlaceholder = function () {
                    if ($element.val()) { $label.html(null); }
                    else {
                        _setPosition();
                        $label.html(placeholder);
                    }
                };
                _setPosition();
                $element.on('focus blur input keyup propertychange resetplaceholder', _resetPlaceholder);
            }
            if($("#submit_btn").size()>0){
                $("#submit_btn").click(function(){
                    if ($element.val() === placeholder) {
                        $element.val('');
                    }
                })
            }
            
        });
    }


    $('body').on("focus", "input[placeholder],textarea[placeholder]", function () {
        var _theValue = $(this).val();
        var _thePlaceholder = $(this).attr("placeholder");
        if ($.trim(_theValue) == $.trim(_thePlaceholder)) {
            $(this).val("");
        }
    })



}

 //格式化金额
 function formatAmt(obj){
    obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符
    obj.value = obj.value.replace(/^\./g,"");  //验证第一个字符是数字而不是.
    obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的.
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
  }

  // 负责view的销毁
  function removeFile( fileId ) {
    uploader1.removeFile(fileId);
}

//取得cookie
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');    //把cookie分割成组
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];                      //取得字符串
        while (c.charAt(0) == ' ') {          //判断一下字符串有没有前导空格
            c = c.substring(1, c.length);      //有的话，从第二位开始取
        }
        if (c.indexOf(nameEQ) == 0) {       //如果含有我们要的name
            return unescape(c.substring(nameEQ.length, c.length));    //解码并截取我们要值
        }
    }
    return false;
}

//清除cookie
function clearCookie(name) {
    setCookie(name, "", -1);
}
//设置cookie
function setCookie(name, value, seconds) {
    seconds = seconds || 0;   //conds有值就直接赋值，没有为0，这个根php不一样。
    var expires = "";
    if (seconds != 0) {      //设置cookie生存时间
        var date = new Date();
        date.setTime(date.getTime() + (seconds * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    document.cookie = name + "=" + escape(value) + expires + "; path=/";   //转码并赋值
}

