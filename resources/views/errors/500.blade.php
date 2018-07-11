<style type="text/css">
    a { color:#555}
    html { height: 100%; width: 100%; background: url( {{asset('home/images/bj.png')}} ) repeat; }
    body {margin: 0px auto;}
    .cw404 { width:755px; margin: 0px auto; }
    .cw404_nr { height: 284px; width: 750px; background: #e5e5e5; border: 1px solid #aaaaaa; margin: 0px auto; }
    .cw404_top { height: 200px; width: 750px; margin: 0px auto; }
    .top_left { float: left; height: 150px; width: 150px; }
    .top_right { font-size: 100px; line-height: 150px; text-align: center; float: left; height: 150px; width: 600px; color: #3f8bc7; font-family: "微软雅黑"; font-weight: bold; }
    .nr_top { font-size: 25px; line-height: 40px; height: 40px; margin-right: 5px; margin-left: 5px; border-bottom: 1px solid #aaaaaa; text-align: center; font-weight: bold; color: #555555; }
    .nr_min { height: 200px; border-top: 1px solid #FFFFFF; margin-right: 5px; margin-left: 5px; border-bottom: 1px solid #aaaaaa; }
    .nr_foot { font-size: 12px; line-height: 40px; background: #eaeaea; height: 40px; border-top: 1px solid #FFFFFF; color: #555; margin-right: 5px; margin-left: 5px; }
    .min_top { font-size: 14px; line-height: 30px; height: 30px; }
    .min_choose { height: 30px; width: 100px; border: 1px solid #aaa; font-size: 12px; line-height: 30px; text-align: center; background: #eaeaea; }
    .else { height: 30px;  }
    .else li{ width:100px; float:left; margin-left:10px; font-size:12px; line-height:30px; display:inline}
    a:link { text-decoration: none; }
    a:visited { text-decoration: none; }
    a:hover { text-decoration: none; }
    a:active { text-decoration: none; }
</style>
<div class="cw404">
    <div class="cw404_top">
        <div class="top_left"><img src="{{asset('home/images/cw4.png')}}"></div>

        <div class="top_right">500</div>
    </div>
    <div class="cw404_nr">
        <div class="nr_top">Ooops:the pcman has eaten this page</div>

        <div class="nr_min">
            <div class="min_top">You can choose:</div>

            <div class="min_choose"><a href="/">返回首页</a></div>

            <div class="min_top">else:</div>

            <div class="else">
                <li><a href="#">白衣社区</a></li>
                <li><a href="#">白衣报道</a></li>
                <li><a href="#">白衣赛事</a></li>
            </div>

            <div class="min_top">other:</div>

            <div class="else">
                <li><a href="http://www.baidu.com" target="_blank">百度一下</a></li>
                <li><a href="http://www.php.cn/course/283.html" target="_blank">php社区</a></li>
                <li><a href="http://laravelacademy.org" target="_blank">Laravel学院</a></li>
                <li><a href="#">网站动态</a></li>
            </div>


        </div>

        <div class="nr_foot">Copy right by 白衣少侠,All rights reserved!</div>
    </div>
</div>

