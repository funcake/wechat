@extends("layout")

@section("content")
<body>
<section id="admin" data-role="page">
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


	<form class="ui-filterable">
		<input id="orders" data-type="search">
	</form>
	<div data-role="collapsiblesest" data-filter="true" data-input="#orders">
@foreach($photo as $group_id => $amount)
	<div>{{$users[$group_id]['name']}} 有 {{$amount}} 件 <form method="post" action="/admin/createProduct"><input type="hidden" name="group_id" value="{{$group_id}}" ><input type="hidden" name="amount" value="{{$amount}}"><input type="submit" name="" value="创建"></form></div>
@endforeach
	</div>

	<form class="ui-filterable">
		<input id="orders" data-type="search">
	</form>
	<div data-role="collapsiblesest" data-filter="true" data-input="#orders">
@foreach($products as $group => $orders)
	<div data-role="collapsible">
		<h3>{{$users[$group]['name']}}</h3>
			@foreach($orders as $order)
					@foreach($order['products'] as $product)
					<div style="display: inline-block" >
						
						<img src="{{$product['product_img']}}" alt="" width="100px" height="100px">
						<p>{{$product['product_name']}}</p>
						<p>￥{{$product['product_price']/100}}</p>
					</div>
					@endforeach
				<input type="text" name="" value="{{$order['receiver_name'].' '.$order['receiver_province']}}">
				<form action="delivery" method="post" accept-charset="utf-8">
				<input type="hidden" name="order_id" value="{{$order['order_id']}}">
				<input type="submit" name="" value="寄出">
				</form>
			@endforeach
		</div>
@endforeach
	</div>

	<form class="ui-filterable">
		<input id="groups" data-type="search">
	</form>
	<div id="groups">
	<div data-role="collapsiblesest" data-filter="true" data-input="#groups">
@foreach($users as $key => $user)
		<div data-role="collapsible" class="copy">
			<h3>{{$user['name']}}</h3>
			<p>{{$key}}</p>
		</div>
@endforeach
	</div>
	</div>
	<!-- <input class="copy" value="123 sdfdfg sdfgsdf "> -->
</section>
</body>
<script>
	$('#regist').on("click",function() {
		post = {'name':$('#name').val()};
		$.post(
			'regist',
			post,
				function(data) {
					console.log(data);
				}
		);

	});
	$('.copy').on('click',function() {
		$(this).select();
		document.execCommand('copy');
		alert('已经复制');
	});
</script>
@endsection
