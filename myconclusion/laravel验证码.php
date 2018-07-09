①首先, composer.json中如下加入配置：

"require": {
...
"gregwar/captcha": "1.*"
},

②然后，cmd进入你项目的根目录中执行以下命令：

composer update

当出现以下情况，则代表成功。否则会报gregwar/captcha不存在的

③接下来就可以正常使用了，根据具体的开发需求，可以有很多种方式去使用。

1、可以将验证码图片保存文件：

<?php
$builder->save('out.jpg');
?>

2、可以直接输出图片到网页：

<?php
header('Content-type: image/jpeg');
$builder->output();


3、可以生成内联图片：

<img src="<?php echo $builder->inline(); ?>" />

④以下演示了其中一种使用方式，直接输出图片到网页。

控制器中：

1、生成验证码

2、展示验证码

3、检测验证码（是否正确）

复制代码区：

//测试自带的验证码

public function getVerify()
{
return view('Test.verify');
}

//生成验证码
public function getCreateverify($tmp)
{
//生成验证码图片的Builder对象，配置相应属性
$builder = new CaptchaBuilder;
//可以设置图片宽高及字体
$builder->build($width = 100, $height = 40, $font = null);
//获取验证码的内容
$phrase = $builder->getPhrase();
// var_dump($phrase);
//把内容存入session
Session::flash('milkcaptcha', $phrase);
//生成图片
header("Cache-Control: no-cache, must-revalidate");
header('Content-Type: image/jpeg');
$builder->output();
}

//验证码验证
public function getCode(Request $request)
{
	$userInput = $request->get('captcha');
	if (Session::get('milkcaptcha') == $userInput) {
	  //用户输入验证码正确
	  return '您输入验证码正确';
	}else {
	  //用户输入验证码错误
	  return '您输入验证码错误';
	}
}

⑥表单内部写的比较简单，看看即可：
视图层：
<form action="code" method="get">
<table>
用户名： <input type="text" name="username"><br>
密码： <input type="text" name="password"><br>
验证码: <input type="text" name="captcha" style="width: 100px; height:20px "></br>
<a onclick="javascript:re_captcha();" >
<img src="{{ URL('test/createverify/1') }}" alt="验证码" title="刷新图片" width="100" height="40" id="verify" border="0">
</a><br>
<input type="submit" value="提交">
</table>
</form>

<script>
function re_captcha() {
$url = "{{ URL('test/createverify') }}";
$url = $url + "/" + Math.random();
document.getElementById('verify').src=$url;
}
</script>

⑤下面我们可以设置相应的router访问这个验证码图片

⑦最后就是在form提交页面验证相应验证码，库中也为我们提供了相应方法：

方法一：
$userInput = $request->get('captcha');
if($builder->testPhrase($userInput)) {
//用户输入验证码正确
  return '您输入验证码正确';
}else {
//用户输入验证码错误
  return '您输入验证码错误';
}

方法二：
//验证码验证
public function getCode(Request $request)
{
	$userInput = $request->get('captcha');
	if (Session::get('milkcaptcha') == $userInput) {
	  //用户输入验证码正确
	  return '您输入验证码正确';
	}else {
	  //用户输入验证码错误
	  return '您输入验证码错误';
	}
}

补充：
在form表单提交，检验验证码方法一写的比较草率，给读者带来了歧义，在此有个补充
$builder->testPhrase($userInput) 这里的$builder与生成验证码的$builder为同一个，如果重新new，则一直会验证失败。我们可以从源码中看到：所以推荐方法二；

public function testPhrase($phrase)
{
return ($this->builder->niceize($phrase) == $this->builder->niceize($this->getPhrase()));
}