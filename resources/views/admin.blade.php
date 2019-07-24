@extends("layout")

@section("content")

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
@foreach($photo as $group => $amount)
	<div>{{$group}} <button>$amount</button></div>
@endforeach
	</div>

	<form class="ui-filterable">
		<input id="orders" data-type="search">
	</form>
	<div data-role="collapsiblesest" data-filter="true" data-input="#orders">
@foreach($groupOrders as $group => $orders)
	<div data-role="collapsible">
		<h3>{{$users[$group]['name']}}</h3>
			@foreach($orders as $order)
			<div data-role="collapsible">
				<h3>
					@foreach($order['products'] as $img => $price)
						<img src="{{$img}}" alt=""><p>{{$price}}</p>
					@endforeach
				<p>{{$order['price']}}</p>
				</h3>
				<p>{{$order['product_name']}}</p>
				<p>{{$order['address']}}</p>
				<input type="button" name="$order['order_id']">
			</div>
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
