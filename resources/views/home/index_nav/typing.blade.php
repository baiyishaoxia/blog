﻿<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="打字训练游戏,打字训练"/>
    <meta name="description" content="My的打字训练小游戏"/>
    <title>Typing training - 打字训练小游戏</title>
    {{Html::style('home/default/static/css/typing.css')}}
    {{Html::script('home/default/static/js/typing.js')}}
</head>
<body onselectstart="return false">
    <div class="page" id="app">
        <h1 class="title"><span @click="route = 'index'">Typing training</span> <span @click="route = 'top'" class="top-link">排行榜</span></h1>
        <template v-if="route === 'index'">
            <p style="text-align: center;padding: 20px 0">
                请输入你的姓名：<input type="text" class="normal-input" v-model="form.name" :disabled="time > 0">
                <button @click="start" class="start-btn">
                    @{{ state ? '停止' : '开始' }}
                </button>
                已进行了 @{{ time }} 秒
            </p>
            <div class="line" v-for="(item, index) in line" :key="item.paraph">
                <div class="erro">@{{ error[index] }}</div>
                <div class="paraph" v-html="item.paraphDisplay"></div>
                <div class="paraph input">
                    @{{ item.paraph }}
                    <input type="text" class="input-box" v-model="item.input" @input="compareWords(item)" :autofocus="active === index" :ref="'input-' + index" @keyup.enter="nextLine(index)" :maxlength="item.paraph.length" onpaste="return false;" :disabled="!state" @keydown.tab.prevent>
                </div>
            </div>
            <div class="submit">
                <button class="btn" @click="saveScore" :disabled="submiting">
                    @{{ submiting ? '提交中...' : '提交成绩' }}
                </button>
            </div>
        </template>
        <template v-if="route === 'top'">
            <div style="padding: 40px 0;text-align: center" v-if="toplist.length === 0 && !loading">暂无数据</div>
            <ul class="top-list">
                <li v-if="loading">Loading...</li>
                <li v-for="(item, index) in toplist">
                    <span class="top">第@{{ index + 1 }}名: </span>
                    @{{ item.name }} <span class="time">时间: @{{ item.score }}s</span></li>
            </ul>
            <div class="submit">
                <button class="btn" @click="route='index'">开始训练</button>
            </div>
        </template>
    </div>
    {{Html::script('home/default/static/js/jquery.min.js')}}
    {{Html::script('home/default/static/js/main.js')}}
</body>
</html>
