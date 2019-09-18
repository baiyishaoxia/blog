<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keyword" content="前端开发，源码演示，前端演示demo">
    <meta name="description" content="My前端演示demo列表">
    <title>我的前端开发demo-前端开发源码演示</title>
    {{Html::style('home/default/static/css/main.css')}}
</head>
<body>
<div class="container" id="app" v-cloak>
    <input type="text" class="search" v-model="keyword" :class="keyword === '' || 'active'">
    <ul class="item-list">
        <li v-for="item in result">
            <a :href="item.url" target="_blank" :title="item.title">
                <img :src="item.icon" alt="icon" class="icon" style="margin: 0 auto">@{{item.title}}
            </a>
        </li>
    </ul>
</div>
{{Html::script('home/default/static/js/vue.js')}}
<script>
    new Vue({
        el: '#app',
        data: {
            keyword: '',
            links: [{
                icon: '{{asset('home/default/static/images/package.png')}}',
                title: '首页',
                url: '{{URL::action('Home\IndexController@getIndex')}}'
            },{
                icon: '{{asset('home/default/static/images/tt.png')}}',
                title: '打字训练',
                url: './typing'
            }, {
                icon: '{{asset('home/default/static/images/logo.png')}}',
                title: '密码生成器',
                url: './'
            }, {
                icon: '{{asset('home/default/static/images/package.png')}}',
                title: 'demo1',
                url: './'
            }, {
                icon: '{{asset('home/default/static/images/package.png')}}',
                title: 'demo2',
                url: './'
            }, {
                icon: '{{asset('home/default/static/images/package.png')}}',
                title: 'demo3',
                url: './'
            },  {
                icon: '{{asset('home/default/static/images/package.png')}}',
                title: 'demo4',
                url: './'
            }, {
                icon: '{{asset('home/default/static/images/package.png')}}',
                title: 'demo5',
                url: './'
            }]
        },
        computed: {
            result: function () {
                var keyword = this.keyword
                return this.links.filter(function (p1) {
                    if (p1.title.indexOf(keyword) !== -1) {
                        return true
                    }
                })
            }
        }
    })
</script>
</body>
</html>
