@extends("layout")
@section("content")
<section id="home" data-role="page">
	<header data-role="header">
		<h1>上架商品管理</h1>
	</header><!-- /header -->

	<ul data-role="listview" data-split-icon="gear" data-inset="true">

	</ul>
	<div data-role="popup" id="popup" data-theme="a" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">
		<form method="post">
			        <label for="name" class="ui-hidden-accessible"></label>
			            <input type="text" name="name" id="name" value="" data-clear-btn="true" placeholder="名" >
			<label for="price" class="ui-hidden-accessible">价:</label>
			            <input type="range" name="price" id="price" value="" min="0" max="100" data-highlight="true" data-clear-btn="true" >

			            <label for="select-choice-1" class="select">价域</label>
			            <select name="select-choice-1" id="select-choice-1">
				                <option value="standard">￥1000</option>
				                <option value="rush">￥5000</option>
				                <option value="express">￥10000</option>
			            </select>
			            <fieldset class="ui-grid-a">
				<a href="" data-rel="back" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini submit"  key="${i}">button</a>
				    <a href="" data-rel="back" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">Cancel</a>
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
			// console.log(data);
			data.forEach( function(e, i) {
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
				$('#price').val(data[i].sku_list[0].price/100);
				$('.submit').attr('key',i);
			});
		}
	);
	</script>
	@endsection
