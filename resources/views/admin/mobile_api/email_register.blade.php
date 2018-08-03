<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
邮箱验证----模板吧<br/>
尊敬的 {{ $m3_email->to }} 用户，{{$m3_email->content}}
<br>
请点击此处激活账号<br/>
<a href="{!! $m3_email->url  !!}" target="_blank">
    {!! $m3_email->url  !!}
</a>
</body>
</html>
