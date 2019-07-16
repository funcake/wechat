<!DOCTYPE html>
<html>
<head>
	<title> </title>
	<meta  charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="referrer" content="never">
<link href="https://cdn.bootcss.com/jquery-mobile/1.4.5/jquery.mobile.min.css" rel="stylesheet">
</head>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/jquery-mobile/1.4.5/jquery.mobile.min.js"></script>
	<style type="text/css">
		wx.config({
		    <?php echo $config ?>
		});
	</style>
	@yield('content')


</html>