@extends("layout")
@section("content")
<section id="home" data-role="page">
	<header data-role="header">
		<h1>商品管理</h1>
	</header><!-- /header -->

	<ul data-role="listview" id="status0"  data-split-icon="gear" data-inset="true" data-filter="true" data-filter-placeholder = "查找">

	</ul>
	<div data-role="popup" id="popup" data-theme="a" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">

		<form>
				<ul data-role="listview" data-inset="true">
					<li class="ui-field-contain">
			        <label for="name" class="ui-hidden-accessible"></label>
			            <input type="text" name="name" id="name" value="" data-clear-btn="true" placeholder="名" >
						
					</li>
				<li class="ui-field-contain">
			        <label for="price" class="ui-hidden-accessible">价:</label>
			            <input type="range" name="price" id="price" value="" min="0" max="100" step="" data-highlight="true" data-popup-enable="true" >
			<div class="ui-field-contain">
					<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
						        <input type="radio" name="pricefield" id="primary" value="1000" checked="checked" onclick="$('#price').attr({'step':20,'max':1000});">
						        <label for="primary">千元</label>
						        <input type="radio" name="pricefield" id="advance" value="5000" onclick="	$('#price').attr({'step':100,'min':100,'max':5000});">
						        <label for="advance">五千</label>
						        <input type="radio" name="pricefield" id="master" value="10000" onclick="$('#price').attr({'step':200,'min':5000,'max':10000});">
						        <label for="master">万元</label>
					</fieldset>
			</div>	
					
				</li>
				<li class="ui-field-contain">
					
			            <label for="material" class="select" data-inline='true'>料：</label>
						<select id="material" name="material" key="{{$material['id']}}" class='select' data-inline='true' >
						@foreach($material['property_value'] as $p)
							<option value="{{$p['id']}}">{{$p['name']}}</option>
						@endforeach
						</select>
				</li>

					<li class="ui-field-contain">
					<fieldset data-role = "controlgroup" data-type="horizontal" >
						<legend >属性:</legend>
						<label for="usage" class="select" data-inline='true'>适用场景</label>
						<select id="usage" name="usage" key="{{$usage['id']}}" class='select' data-inline='true' >
						@foreach($usage['property_value'] as $p)
							<option value="{{$p['id']}}">{{$p['name']}}</option>
						@endforeach
						</select>
						<label for="style" class="select" data-inline='true'>款式</label>
						<select id="style" name="style" key="{{$style['id']}}"  class='select' data-inline='true' >
						@foreach($style['property_value'] as $p)
							<option value="{{$p['id']}}">{{$p['name']}}</option>
						@endforeach
						</select>
					</fieldset>
						
					</li>
					<li class="ui-body ui-body-a">
						    <fieldset class="ui-grid-a">
							<div class="ui-block-a">
								
								<a href="" data-rel="back" class="ui-shadow ui-btn  ui-btn-a ui-corner-all   ui-icon-action ui-btn-icon-left"  key="" id="submit">提交</a>
							</div>
							<div class="ui-block-b">
								
								    <a href="" data-rel="back" class="ui-shadow ui-btn ui-btn-b ui-corner-all ">取消</a>
							</div>
						            </fieldset>
						
					</li>
				</ul>

		</form>

	</div>

	<div data-role="popup" id="popup1" data-theme="a" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">
		<form method="post">

			        <label for="price" class="ui-hidden-accessible">价:</label>
			        <input type="range" name="price" id="price" value="" min="0" max="100" step="" data-highlight="true" data-clear-btn="true" >

			<div class="ui-field-contain">
						<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
							        <input type="radio" name="pricefield" id="primary" value="1000" checked="checked" onclick="$('#price').attr({'step':20,'max':1000});">
							        <label for="primary">千元</label>
							        <input type="radio" name="pricefield" id="advance" value="5000" onclick="	$('#price').attr({'step':100,'min':100,'max':5000});">
							        <label for="advance">五千</label>
							        <input type="radio" name="pricefield" id="master" value="10000" onclick="$('#price').attr({'step':200,'min':5000,'max':10000});">
							        <label for="master">万元</label>
						</fieldset>
				</div>	

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


	$('#submit').on("click",function() {
		var key = $(this).attr("key");
		post = data[key];
		post.product_base.name=$('#name').val();
		post.sku_list[0].price=$('#price').val()*100;

		post.product_base.property = [
			{
				"id": {{$material['id']}},
				"vid": $('#material').val(),
			},
			{
				"id": {{$style['id']}},
				"vid": $('#style').val(),
			},
			{
				"id": {{$usage['id']}},
				"vid": $('#usage').val(),
			}
		];		
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
			$('#status0').html(html);
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
