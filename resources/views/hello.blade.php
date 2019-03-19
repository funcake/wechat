<!DOCTYPE html>
<html>
<head>
	<meta name="referer" content="never">
	<title>hello</title>
</head>
<body>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
</script>

@foreach($list as $user)
	<div class="list">
	<img src="{{$user['headimgurl']}}" alt="">
	<span>{{$user['nickname']}}</span><a href="express" title="发货">发货</a>
	</div>
@endforeach

</form>
</body>
</html>