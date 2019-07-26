@extends("layout")
@section("content")
<body>

<section id="redist" data-role="page">
	<div data-role="header">
		<h1>商户管理</h1>
	</div>
	<a href="#popup" data-rel="popup" title="注册商户" class="ui-btn ui-btn-b ui-corner-all" data-icon="check" style="margin:10px" >注册商户</a>
	<div data-role="popup" id="popup" data-theme="a" data-overlay-theme="b" class="ui-content" style="width:280px; padding-bottom:2em;">
		<h1>商户入驻</h1>
		<label for="name">商 铺 名：</label>
		<input type="text" name="name" id="name">		
		<fieldset class="ui-grid-a">
			<div class="ui-block-a"><a href="" data-rel="back" class="ui-shadow ui-btn ui-btn-b ui-corner-all "  id="regist">注册</a></div>
			<div class="ui-block-b"><a href="" data-rel="back" class="ui-shadow ui-btn ui-btn-a ui-corner-all ">取消</a></div>
		</fieldset>
	</div>
</section>

<script>
	$('#regist').on("click",function() {
		post = {'name':$('#name').val(),'id':'{{$id}}'};
		$.post(
			'/user/regist',
			post,
				function(data) {
					console.log(data);
				}
		);

	});
</script>
@endsection