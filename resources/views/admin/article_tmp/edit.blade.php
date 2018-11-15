@extends('background.layouts.main')
@section('css')
    {{Html::style('admin/tmp/summernote/bootstrap.css')}}
    {{Html::style('admin/tmp/css/common.css')}}
@endsection
@section('js')
    @include('background.layouts.btnsave')
    @include('admin.article_tmp.create_tmp_js.create_tmp_js')
    <script type="text/javascript">
        //初始化上传控件
        $(function () {
            $('#form1').initValidform();
            $(".upload-album").InitUploader({ btntext: "批量上传", multiple: true, sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('background/script/webuploader/uploader.swf')}}"});
            //创建上传附件
            $(".attach-btn").click(function () {
                showAttachDialog();
            });
        });
        //初始化附件窗口
        var attachDialog;
        function showAttachDialog(obj) {
            var objNum = arguments.length;
            var index=layer.open({
                type: 2,
                title: '上传附件',
                area: '500px',
                content: ['{{URL::action('Background\ToolsController@getFile')}}','no'], //iframe的url
                btn: ['确定', '取消'], //按钮
                btn1:function(){
                    btn1function();
                }
            });
            if (objNum == 1) {
                attachDialog = obj;
            }
        }
        //删除附件节点
        function delAttachNode(obj) {
            $(obj).parent().remove();
        }
        //时间日期插件
        layui.use('laydate', function() {
            var laydate = layui.laydate;
            //执行一个laydate实例
            laydate.render({
                elem: '#start_time', //指定元素
                type: 'datetime'
            });
            laydate.render({
                elem: '#end_time', //指定元素
                type: 'datetime'
            });
            $(document).ready(function () {
                $("#form1").bind("submit", function () {
                    var start_time = document.getElementById("start_time").value;
                    var end_time = document.getElementById("end_time").value;
                    if (start_time > end_time) {
                        layer.msg('结束时间小于开始时间!');
                        return false;
                    }
                })
            });
        });
    </script>
    <script>
        $(function () {
            layui.use("layedit", function(){
                var layedit = layui.layedit;
                //构建一个默认的编辑器
                var index = layedit.build("editor",{
                    tool: ["Bold","italic","underline","strikeThrough","|","face", "link", "unlink", "|", "left", "center", "right"],
                });
                var template_id = $('#change-mode').val();
                $('.btn').click(function () {
                    var define_template = layedit.getContent(index); //自定义模板内容
                    if(template_id == '4'){
                        if(define_template == '' || define_template == "undefined"){
                            // layer.msg("请填写自定义模板内容");
                            // return
                        }
                        $('#define_template').attr('value',define_template); //将模板内容赋值给隐藏域
                    }
                });
            });
        });
        $("#change-mode").change(function () {
            var _val=$(this).val();
            if(_val=="4"){
                $(".mode-hidden").show();
                $(".templateWapper").hide();
                //给预览添加链接
                var url = "{{URL::action('Admin\ArticleTmpController@getTemplatePage')}}"+'/'+_val;
                $('.hrefYL').attr('href',url);
            }else{
                $(".mode-hidden").hide();
                $(".templateWapper").show();
                //给预览添加链接
                var url = "{{URL::action('Admin\ArticleTmpController@getTemplatePage')}}"+'/'+_val;
                $('.hrefYL').attr('href',url);
                $('.hrefYL').show();
            }
            $(".text_ww").change(function () {
                $('.hrefYL').attr('sign', $(this).val());
            });
        });
    </script>
@endsection
@section('content')
    {{Form::model($data,['url'=>URL::action('Admin\ArticleTmpController@postEdit'),'id'=>'form1'])}}
    {{Form::hidden('id',$data['id'])}}
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href=""><span>活动管理</span></a>

        <i class="arrow"></i>
        <span>编辑活动</span>
    </div>
    <div class="line10"></div>
    <!--/导航栏-->

        <!--内容-->
        <div id="floatHead" class="content-tab-wrap">
            <div class="content-tab">
                <div class="content-tab-ul-wrap">
                    <ul>
                        <li><a class="selected" href="javascript:;">基本信息</a></li>
                        <li><a href="javascript:;">扩展选项</a></li>
                        <li><a href="javascript:;">其它信息</a></li>
                        <li><a href="javascript:;">自定义信息</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <dl>
                <dt>活动名称</dt>
                <dd>
                    {{Form::text('title',null,['class'=>'input normal','datatype'=>'*'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
            <dl>
                <dt>活动管理员</dt>
                <dd>
                    {{Form::text('tmp_title',null,['class'=>'input normal','datatype'=>'*'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
            <dl>
                <dt>活动Logo</dt>
                <dd>
                    <div class="upload-box upload-album"></div>
                    <div class="photo-list">
                        @if($data['logo'])
                            @foreach(\App\Http\Model\Admin\ArticleTmpImages::get_file($data['logo']) as $k=>$v)
                                <div class="tournBan">
                                    <input class="filename" name="{{'logo[0.'.$k.'][filename]'}}" type="hidden" value="{{$v->file_name}}">
                                    <input class="filepath" name="{{'logo[0.'.$k.'][filepath]'}}"  type="hidden" value="{{$v->file_url}}">
                                    <input class="filesize" name= "{{'logo[0.'.$k.'][filesize]'}}"  type="hidden" value="{{$v->file_size}}">
                                    <input class="filesize" name="{{'logo[0.'.$k.'][filetime]'}}" type="hidden" value="{{date('Y-m-d',strtotime($v->created_at))}}">
                                    <img src="{{Storage::url($v->file_url)}}" height="100px">
                                    <label class="iconfont delete">&#xe64d;</label>
                                </div>
                            @endforeach
                        @endif
                        <ul></ul>
                    </div>
                    <div class="logo-list"><ul></ul></div>
                </dd>
            </dl>
            <dl>
                <dt>活动模板</dt>
                <dd>
                    <div class="rule-single-select">
                        {{Form::select('article_template',\App\Http\Model\Admin\ArticleTmp::select_template(),null,['class'=>'text_ww','id'=>'change-mode','datatype'=>"*",'nullmsg'=>'请选择大赛模版'])}}
                    </div>
                    @if($data['article_template'] == 1)
                        <a href="{{URL::action('Admin\ArticleTmpController@getTemplatePage').'/'.$data['article_template']}}" class="hrefYL" sign="1" target="_blank">预览</a>
                    @elseif($data['article_template'] == 2)
                        <a href="{{URL::action('Admin\ArticleTmpController@getTemplatePage').'/'.$data['article_template']}}" class="hrefYL" sign="2" target="_blank">预览</a>
                    @elseif($data['article_template'] == 3)
                        <a href="{{URL::action('Admin\ArticleTmpController@getTemplatePage').'/'.$data['article_template']}}" class="hrefYL" sign="3" target="_blank">预览</a>
                    @elseif($data['article_template'] == 5)
                        <a href="{{URL::action('Admin\ArticleTmpController@getTemplatePage').'/'.$data['article_template']}}" class="hrefYL" sign="5" target="_blank">预览</a>
                    @else
                        <a href="{{URL::action('Admin\ArticleTmpController@getTemplatePage').'/'.$data['article_template']}}" class="hrefYL" sign="4" target="_blank">预览</a>
                    @endif
                </dd>
            </dl>
            @if($data['article_template'] == 4)
                {{--自定义模板--}}
                <dl class="mode-hidden">
                    <dt>&nbsp;</dt>
                    <dd>
                        <textarea class="define_template" id="editor">{!! $data['tmp_detail'] !!}</textarea>
                    </dd>
                </dl>
            @else
                <dl class="mode-hidden" style="display: none">
                    <dt>&nbsp;</dt>
                    <dd>
                        <div class="define_template" id="editor"></div>
                    </dd>
                </dl>
            @endif
            {{Form::hidden('define_template',null,['id'=>'define_template'])}}
            <dl>
                <dt>
                    <sup>*</sup>限制人数：</dt>
                <dd>
                    {{Form::text('number',null,['class'=>'input normal','placeholder'=>'请填写人数','onkeyup'=>'keyUpisInt(this)','maxlength'=>9,'datatype'=>'n','nullmsg'=>'请填写人数','errormsg'=>'人数请填写数字'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
            <dl>
                <dt>点击次数</dt>
                <dd>
                    {{Form::text('click',0,['class'=>'input normal','readOnly'=>'readOnly'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
        </div>

        <div class="tab-content" style="display: none">
            <dl>
                <dt>活动开始时间</dt>
                <dd>
                    {{Form::text('start_time',null,['class'=>'input normal','datatype'=>'*','id'=>'start_time'])}}
                </dd>
            </dl>
            <dl>
                <dt>活动结束时间</dt>
                <dd>
                    {{Form::text('end_time',null,['class'=>'input normal','datatype'=>'*','id'=>'end_time'])}}
                </dd>
            </dl>
        </div>


        <div class="tab-content" style="display: none">
            <div class="templateWapper">
                <div class="templateBox templateTop">
                    <div class="templateTitle templateNav">
                        <div class="templateItem">
                            <ul>
                                {{--如果用户选择了自定义模板，则模板即不显示--}}
                                @if($data['article_template'] != 4)
                                    @if($data['tmp_detail'])
                                        @foreach($data['tmp_detail'] as $key=>$val)
                                            <li dataNg='{"text":"{{$val->title}}","index":{{$val->sort}},"cont":"","isDH":{{$val->is_show_menu?'true':'false'}},"isShow":{{$val->is_show_text?'true':'false'}}}'>
                                                <div class="contvalue" style="display:none;">{!!$val->template_text!!}</div>
                                                <a href="javascript:void(0);" name="editItem">{{$val->title}}</a>
                                                @if(isset($val->is_new_add))
                                                    @if($val->is_new_add == "1")
                                                        <input type="hidden" value="1" class='canDelete' />
                                                        <div class="deleteItem">
                                                            <a href="javascript:void(0);">删除</a>
                                                        </div>
                                                    @else
                                                        <input type="hidden" value="0" class='canDelete' />
                                                        <div class="hideItem">
                                                            <a href="javascript:void(0);">隐藏</a>
                                                        </div>
                                                    @endif
                                                @else
                                                    <input type="hidden" value="0" class='canDelete' />
                                                    <div class="hideItem">
                                                        <a href="javascript:void(0);">隐藏</a>
                                                    </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                @endif
                            </ul>
                        </div>
                        <label><a href="javascript:void(0);" class="iconfont AddSubitem">添加</a></label>
                    </div>
                    <div class="templateForm">
                        <div class="create-form releaseEvents">
                            <dl>
                                <dt><sup>*</sup>属性：</dt>
                                <dd class="dd-item radioBox">
                                    <label><input type="checkbox" name="checkbox" value="1" checked="checked" class="isShow isNav normal">是否显示导航</label>
                                </dd>
                            </dl>
                            <dl>
                                <dt>栏目名称：</dt>
                                <dd class="dd-item">
                                    <input type="text" class="text_in input normal" name="column" placeholder="" datatype="*" maxlength="6" id="userName" nullmsg="请输入栏目名称">
                                    <span class="Validform_checktip"></span>
                                </dd>
                            </dl>
                            <dl>
                                <dt>导航排序：</dt>
                                <dd class="dd-item work-style">
                                    <input type="text" class="text_in input normal" onkeyup="keyUpisInt(this);" datatype="n" maxlength="2" name="sort" class="text_in" nullmsg="请输入导航排序">
                                    <span class="Validform_checktip"></span>
                                </dd>
                            </dl>
                            <dl>
                                <dt>内容：</dt>
                                <dd class="dd-item work-style" nullmsg="请输入模板内容">
                                    <div class="markTextBox" style="height:auto;">
                                        {{--<textarea name="markText" id="markText" class="txtare input normal"></textarea>--}}
                                        <div class="content_editor txtare" id="content_editor"></div>
                                        <i id="num" class="numShow" style="display:none;" value="0/200">200字符</i>
                                    </div>
                                    <input type="hidden" name="markText" id="markText" />
                                    <span class="Validform_checktip"></span>
                                </dd>
                            </dl>
                            <dl>
                                <dt>&nbsp;</dt>
                                <dd class="dd-item">
                                    <input type="button" class="btn-red btn" id="navSort" name="editItem" value="保存">
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="templateTitle templateScend">
                    <ul>

                    </ul>
                </div>
                <div class="templateTBox templateBottom">
                    <div class="templateTitle templateThird">
                        <label>
                            导航展示顺序管理
                            <a href="javascript:void(0);" class="setBtn">一键设置</a>
                            <a href="javascript:void(0);" class="sortNav" style="display:none;">确认</a>
                        </label>
                    </div>
                    <div class="templateTab navShow" style="display:none;">
                        <table class="Tab">
                            <colgroup>
                                <col width="33%" />
                                <col width="33%" />
                                <col width="33%" />
                            </colgroup>
                            <tbody>
                                {{--如果用户选择了自定义模板，则模板即不显示--}}
                                @if($data['article_template'] != 4)
                                    @if($data['tmp_detail'])
                                        @foreach($data['tmp_detail'] as $key=>$val)
                                            <tr dataNg='{"text":"{{$val->title}}","index":{{$val->sort}},"cont":"{{$val->template_text}}","isDH":{{$val->is_show_menu?'true':'false'}},"isShow":{{$val->is_show_text?'true':'false'}}}'>
                                                <td>
                                                    <input type="text" value="{{$val->title}}" class="txt_in" name="template[{{$key}}][title]"/>
                                                </td>
                                                {{Form::hidden('template['.$key.'][is_show_text]',$val->is_show_text?true:false,['class'=>'is_show_text'])}}
                                                {{Form::hidden('template['.$key.'][template_text]',$val->template_text,['class'=>'template_text'])}}
                                                {{Form::hidden('template['.$key.'][is_new_add]',isset($val->is_new_add)?$val->is_new_add:"0",['class'=>'is_new_add'])}}
                                                <td>
                                                    导航排序：<input type="text" class="txt_in txt" value="{{$val->sort}}" name="template[{{$key}}][sort]"/>
                                                </td>
                                                <td>
                                                    是否在导航显示：
                                                    <select class="sel" name="template[{{$key}}][is_show_menu]">
                                                        <option value="1" {{$val->is_show_menu?'selected':""}}>是</option>
                                                        <option value="0" {{$val->is_show_menu?'':"selected"}}>否</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" style="display: none">
            <div class="userDefined">
                <label class="upItem"><i class="note-icon-font"></i>如果您需要增加必要的字段信息，请添加；若没有则跳过</label>
                <div class="userDefined-Main" style="display:none;">
                    <div class="userDefined-box">
                        <div class="userDefined-form">
                            <div class="create-form definedTem">
                                @if($data['extra_field'])
                                    @foreach($data['extra_field'] as $key=>$val)
                                        @if($val['field_type'] == "text")
                                            <dl>
                                                {{Form::hidden('field['.$key.'][id]',$val['id'])}}
                                                <dt>
                                                    <label><input type="checkbox" class="chk" name="field[{{$key}}][is_required]" {{$val['is_required']?"checked":""}}/>必填</label>{{$val['title']}}：
                                                </dt>
                                                {{Form::hidden('field['.$key.'][field_type]','text')}}
                                                <dd>
                                                    <input type="text" class="text_in" datatype="*" name="field[{{$key}}][title]" nullmsg="请填写{{$val['title']}}" value="{{$val['title']}}"/>
                                                    <i class="delete iconfont" title="删除" val_id="{{$val['id']}}"></i>
                                                </dd>
                                            </dl>
                                        @endif
                                        @if($val['field_type'] == 'textarea')
                                            <dl>
                                                {{Form::hidden('field['.$key.'][id]',$val['id'])}}
                                                <dt>
                                                    <label><input type="checkbox" class="chk" name="field[{{$key}}][is_required]" {{$val['is_required']?"checked":""}}/>必填</label>{{$val['title']}}：
                                                </dt>
                                                {{Form::hidden('field['.$key.'][field_type]','textarea')}}
                                                <dd>
                                                    <input type="text" class="text_in" datatype="*" name="field[{{$key}}][title]" nullmsg="请填写{{$val['title']}}" value="{{$val['title']}}"/>
                                                    <i class="delete iconfont" title="删除" val_id="{{$val['id']}}"></i>
                                                </dd>
                                            </dl>
                                        @endif
                                        @if($val['field_type'] == 'radio')
                                            <dl>
                                                {{Form::hidden('field['.$key.'][id]',$val['id'])}}
                                                <dt>
                                                    <label><input type="checkbox" class="chk" name="field[{{$key}}][is_required]" {{$val['is_required']?"checked":""}}> 必填</label>{{$val['title']}}：
                                                </dt>
                                                {{Form::hidden('field['.$key.'][field_type]','radio')}}
                                                <dd>
                                                    <input type="text" class="text_in" value="{{$val['title']}}" name="field[{{$key}}][title]">
                                                    <i class="delete iconfont" val_id="{{$val['id']}}"></i>
                                                    <div class="addOption">
                                                        @foreach($val['child'] as $kk=>$vv)
                                                            <label>
                                                                <input type="radio" name="radio" class="radioBtn">
                                                                <input type="text" class="txt" name="field[{{$key}}][value][]" value="{{$vv}}">
                                                                {{--<i class="deleteAdd iconfont" title="删除" val_id="{{$val['id']}}"></i>--}}
                                                            </label>
                                                        @endforeach
                                                        <i class="iconfont addDMore" the_index="{{$key}}"></i>
                                                    </div>
                                                </dd>
                                            </dl>
                                        @endif
                                        @if($val['field_type'] == 'checkbox')
                                            <dl>
                                                {{Form::hidden('field['.$key.'][id]',$val['id'])}}
                                                <dt>
                                                    <label><input type="checkbox" class="chk" name="field[{{$key}}][is_required]" {{$val['is_required']?"checked":""}}> 必填</label>{{$val['title']}}：
                                                </dt>
                                                {{Form::hidden('field['.$key.'][field_type]','checkbox')}}
                                                <dd>
                                                    <input type="text" class="text_in" name="field[{{$key}}][title]" value="{{$val['title']}}">
                                                    <i class="delete iconfont" val_id="{{$val['id']}}"></i>
                                                    <div class="addOption">
                                                        @foreach($val['child'] as $kk=>$vv)
                                                            <label>
                                                                <input type="checkbox">
                                                                <input type="text" class="txt" name="field[{{$key}}][value][]" value="{{$vv}}">
                                                                {{--<i class="deleteAdd iconfont" title="删除" val_id="{{$val['id']}}"></i>--}}
                                                            </label>
                                                        @endforeach
                                                        <i class="iconfont addMore" the_index="{{$key}}"></i>
                                                    </div>
                                                </dd>
                                            </dl>
                                        @endif
                                        @if($val['field_type'] == 'upload')
                                            <dl>
                                                {{Form::hidden('field['.$key.'][id]',$val['id'])}}
                                                <dt>
                                                    <label><input type="checkbox" class="chk" name="field[{{$key}}][is_required]" {{$val['is_required']?"checked":""}}/>必填</label>{{$val['title']}}：
                                                </dt>
                                                {{Form::hidden('field['.$key.'][field_type]','upload')}}
                                                <dd>
                                                    <input type="text" class="text_in" datatype="*" name="field[{{$key}}][title]" nullmsg="请填写{{$val['title']}}" value="{{$val['title']}}"/>
                                                    <i class="delete iconfont" title="删除" val_id="{{$val['id']}}"></i>
                                                </dd>
                                            </dl>
                                        @endif
                                    @endforeach
                                @else
                                    <dl>
                                        {{Form::hidden('field['.$key.'][id]',null)}}
                                        <dt>
                                            <label><input type="checkbox" class="chk" name="field[0][is_required]"/>必填</label>姓名：
                                        </dt>
                                        {{Form::hidden('field[0][field_type]','text')}}
                                        <dd>
                                            <input type="text" class="text_in" datatype="*" name="field[0][title]" nullmsg="请填写姓名" value="姓名"/>
                                        </dd>
                                    </dl>
                                @endif
                            </div>
                            <div class="create-form moreCh"></div>
                            <div class="create-form moreInfor">
                                <p>更多信息</p>
                                <dl>
                                    <dt>
                                        未设置可从右边选择
                                    </dt>
                                    <dd>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="moreChoose">
                            <h3>常用字段项：</h3>
                            <div class="moreChoos-Iitem">
                                <span data-name="微信" type="text"><i class="iconfont">&#xe61c;</i>微信</span>
                                <span data-name="公司" type="text"><i class="iconfont">&#xe61c;</i>公司</span>
                                <span data-name="职位" type="text"><i class="iconfont">&#xe61c;</i>职位</span>
                                <span data-name="行业" type="text"><i class="iconfont">&#xe61c;</i>行业</span>
                                <span data-name="QQ" type="text"><i class="iconfont">&#xe61c;</i>QQ</span>
                                <span data-name="邮件" type="text"><i class="iconfont">&#xe61c;</i>邮件</span>
                                <span data-name="附件" type="upload"><i class="iconfont">&#xe61c;</i>附件</span>
                                <span data-name="性别" type="radio"><i class="iconfont">&#xe61c;</i>性别</span>
                            </div>
                            <h3>自定义字段项：</h3>
                            <div class="moreChoos-Iitem1">
                                <span data-name="单行文本" type="text"><i class="iconfont">&#xe61c;</i>单行文本</span>
                                <span data-name="多行文本" type="textarea"><i class="iconfont">&#xe61c;</i>多行文本</span>
                                <span data-name="单项选择" type="radio"><i class="iconfont">&#xe61c;</i>单项选择</span>
                                <span data-name="多项选择" type="checkbox"><i class="iconfont">&#xe61c;</i>多项选择</span>
                            </div>
                        </div>
                    </div>
                    <label class="downItem" style="display:none;"><i class="iconfont">&#xe899;</i>收起表单</label>
                </div>
            </div>
        </div>
        <!--/内容-->
        <!--工具栏-->
        <div class="page-footer">
            <div class="btn-wrap">
                {{Form::submit('提交保存',['class'=>'btn ajax'])}}
                {{Form::button('返回上一页',['class'=>'btn yellow','onclick'=>'javascript:history.back(-1);'])}}
            </div>
        </div>
        <!--/工具栏-->
    {{Form::close()}}
@endsection