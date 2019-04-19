@extends("layout")
@section("content")
<section id="home" data-role="page">
	<header data-role="header">
		<h1>商品管理</h1>
	</header><!-- /header -->

	<ul data-role="listview" data-split-icon="gear" data-inset="true">

	</ul>
	<div data-role="popup" id="popup" data-theme="a" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">
		<form method="post">
			        <label for="name" class="ui-hidden-accessible"></label>
			            <input type="text" name="name" id="name" value="" data-clear-btn="true" placeholder="名" >

			<div class="ui-field-contain">
					<fieldset data-role="controlgroup" data-type="horizontal">
						        <legend>价域:</legend>
						        <input type="radio" name="pricefield" id="primary" value="1000" checked="checked" onclick="$('#price').attr({'step':20,'max':1000});">
						        <label for="primary">￥1000</label>
						        <input type="radio" name="pricefield" id="advance" value="5000" onclick="	$('#price').attr({'step':100,'min':100,'max':5000});
">
						        <label for="advance">￥5000</label>
						        <input type="radio" name="pricefield" id="master" value="10000" onclick="$('#price').attr({'step':200,'min':5000,'max':10000});">
						        <label for="master">￥10000</label>
					</fieldset>
			</div>	

			        <label for="price" class="ui-hidden-accessible">价:</label>
			            <input type="range" name="price" id="price" value="" min="0" max="100" step="" data-highlight="true" data-clear-btn="true" >

					<fieldset data-role = "controlgroup" data-type="horizontal" >
						<legend >产品属性</legend>
			            <label for="material" class="select" data-inline='true'>材料</label>
						<select id="material" name="material" class='select' data-inline='true' data-mini='true'>
						@foreach($material['property_value'] as $p)
							<option value="{{$p['id']}}">{{$p['name']}}</option>
						@endforeach
						</select>
						<label for="usage" class="select" data-inline='true'>适用场景</label>
						<select id="usage" name="usage" class='select' data-inline='true' data-mini='true'>
						@foreach($usage['property_value'] as $p)
							<option value="{{$p['id']}}">{{$p['name']}}</option>
						@endforeach
						</select>
						<label for="style" class="select" data-inline='true'>款式</label>
						<select id="style" name="style" class='select' data-inline='true' data-mini='true'>
						@foreach($style['property_value'] as $p)
							<option value="{{$p['id']}}">{{$p['name']}}</option>
						@endforeach
						</select>
					</fieldset>

			            <fieldset class="ui-grid-a">
					<a href="" data-rel="back" class="ui-shadow ui-btn ui-corner-all ui-btn-inline  submit"  key="">提交</a>
				    <a href="" data-rel="back" class="ui-shadow ui-btn ui-corner-all ui-btn-inline">取消</a>
			            </fieldset>
		</form>

	</div>
	<footer data-role="footer">
		<h1>Footer</h1>
	</footer><!-- /footer -->
</section><!-- /page -->

<script type="text/javascript" charset="utf-8" async defer>

	var data = [];


	$('.submit').on("click",function() {
		var key = $(this).attr("key");
		post = data[key];
		post.product_base.name=$('#name').val();
		post.sku_list[0].price=$('#price').val()*100;
		console.log(post);

		$("#"+key+' h2').html($('#name').val());
		$("#"+key+" p").html('￥'+$('#price').val());
		$.post('',
			post ,
			function(data) {
				console.log(data);
			}
		);
	});


	$.get(
		'0',
		function(d) {
			data = d;
			var html = "";
			data.forEach( function(e, i) {
				e['product_base']['main_img'] = e['product_base']['main_img'].replace(/https/,'http');
				e['product_base']['img'] = e['product_base']['img'].map(function(e){e.replace(/https/,'http')});
				html +=
				`
				<li id="${i}"><a href="#">
				<img src="${e['product_base']['main_img']}" alt="">
				<h2>${e['product_base']['name']}</h2>
				<p>￥${e['sku_list'][0]['price']/100}</p>
				<a href="#popup" class="pop" key='${i}' data-rel="popup" data-position-to="window" data-transition="pop">Purchase album</a>
				</a></li>
				`;});
			$('ul').html(html);
			$('#home').page();
			$('ul').listview("refresh");
			$('.pop').on('click',function() {
				var i = $(this).attr('key');
				$('#name').val(data[i].product_base.name);
				$price = data[i].sku_list[0].price/100;
				if ($price<1000) {
					$('#primary').click();
					$('#price').attr({'step':20,'max':1000});
				} else if($price<5000) {
					$('#advance').click();
					$('#price').attr({'step':100,'min':100,'max':5000});
				} else if($price<5000) {
					$('#master').click();
					$('#price').attr({'step':200,'min':5000,'max':10000});
				}
				$('#price').val($price);
				$('.submit').attr('key',i);
			});
		}
	);
	</script>
	@endsection
