������, composer.json�����¼������ã�

"require": {
...
"gregwar/captcha": "1.*"
},

��Ȼ��cmd��������Ŀ�ĸ�Ŀ¼��ִ���������

composer update

��������������������ɹ�������ᱨgregwar/captcha�����ڵ�

�۽������Ϳ�������ʹ���ˣ����ݾ���Ŀ������󣬿����кܶ��ַ�ʽȥʹ�á�

1�����Խ���֤��ͼƬ�����ļ���

<?php
$builder->save('out.jpg');
?>

2������ֱ�����ͼƬ����ҳ��

<?php
header('Content-type: image/jpeg');
$builder->output();


3��������������ͼƬ��

<img src="<?php echo $builder->inline(); ?>" />

��������ʾ������һ��ʹ�÷�ʽ��ֱ�����ͼƬ����ҳ��

�������У�

1��������֤��

2��չʾ��֤��

3�������֤�루�Ƿ���ȷ��

���ƴ�������

//�����Դ�����֤��

public function getVerify()
{
return view('Test.verify');
}

//������֤��
public function getCreateverify($tmp)
{
//������֤��ͼƬ��Builder����������Ӧ����
$builder = new CaptchaBuilder;
//��������ͼƬ��߼�����
$builder->build($width = 100, $height = 40, $font = null);
//��ȡ��֤�������
$phrase = $builder->getPhrase();
// var_dump($phrase);
//�����ݴ���session
Session::flash('milkcaptcha', $phrase);
//����ͼƬ
header("Cache-Control: no-cache, must-revalidate");
header('Content-Type: image/jpeg');
$builder->output();
}

//��֤����֤
public function getCode(Request $request)
{
	$userInput = $request->get('captcha');
	if (Session::get('milkcaptcha') == $userInput) {
	  //�û�������֤����ȷ
	  return '��������֤����ȷ';
	}else {
	  //�û�������֤�����
	  return '��������֤�����';
	}
}

�ޱ��ڲ�д�ıȽϼ򵥣��������ɣ�
��ͼ�㣺
<form action="code" method="get">
<table>
�û����� <input type="text" name="username"><br>
���룺 <input type="text" name="password"><br>
��֤��: <input type="text" name="captcha" style="width: 100px; height:20px "></br>
<a onclick="javascript:re_captcha();" >
<img src="{{ URL('test/createverify/1') }}" alt="��֤��" title="ˢ��ͼƬ" width="100" height="40" id="verify" border="0">
</a><br>
<input type="submit" value="�ύ">
</table>
</form>

<script>
function re_captcha() {
$url = "{{ URL('test/createverify') }}";
$url = $url + "/" + Math.random();
document.getElementById('verify').src=$url;
}
</script>

���������ǿ���������Ӧ��router���������֤��ͼƬ

����������form�ύҳ����֤��Ӧ��֤�룬����ҲΪ�����ṩ����Ӧ������

����һ��
$userInput = $request->get('captcha');
if($builder->testPhrase($userInput)) {
//�û�������֤����ȷ
  return '��������֤����ȷ';
}else {
//�û�������֤�����
  return '��������֤�����';
}

��������
//��֤����֤
public function getCode(Request $request)
{
	$userInput = $request->get('captcha');
	if (Session::get('milkcaptcha') == $userInput) {
	  //�û�������֤����ȷ
	  return '��������֤����ȷ';
	}else {
	  //�û�������֤�����
	  return '��������֤�����';
	}
}

���䣺
��form���ύ��������֤�뷽��һд�ıȽϲ��ʣ������ߴ��������壬�ڴ��и�����
$builder->testPhrase($userInput) �����$builder��������֤���$builderΪͬһ�����������new����һֱ����֤ʧ�ܡ����ǿ��Դ�Դ���п����������Ƽ���������

public function testPhrase($phrase)
{
return ($this->builder->niceize($phrase) == $this->builder->niceize($this->getPhrase()));
}