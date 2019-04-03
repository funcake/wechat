@extends("layout")
@section("content")
<section id="home" data-role="page">
	<header data-role="header">
		<h1>上架商品管理</h1>
	</header><!-- /header -->

	<ul data-role="listview" data-split-icon="gear" data-inset="true">
		@foreach($list as $key =>$product)
		<li><a href="#">
			<img src="{{chop($product['product_base']['main_img'],'?wx_fmt=jpeg')}}" alt="" >
			<h2>{{$product['product_base']['name']}}</h2>
			<p>{{$product['sku_list'][0]['price']}}</p>
			<a href="#{{$key}}" data-rel="popup" data-position-to="window" data-transition="pop">Purchase album</a>
		</a></li>
		<div data-role="popup" id="{{$key}}" data-theme="a" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">
			<form method="post" id="post{{$key}}">
				<label for="id{{$key}}">id</label>
				<input type="text" name="id" value="{{$product['product_id']}}" id="id{{$key}}" class="ui-hidden">

				        <label for="name{{$key}}" class="ui-hidden-accessible">Text Input:</label>
				            <input type="text" name="name" id="name{{$key}}" value="{{$product['product_base']['name']}}" data-clear-btn="true">

							<label for="price{{$key}}" class="ui-hidden-accessible">Text Input:</label>
				            <input type="range" name="price" id="price{{$key}}" value="{{$product['sku_list'][0]['price']}}" min="0" max="100" data-highlight="true" data-clear-btn="true">

				            <label for="limit{{$key}}">Slider:</label>
				            <input type="range" name="limit" id="limit{{$key}}" value="0" min="0" max="100" data-highlight="true">
				
				            <label for="select-choice-1" class="select">Choose shipping method:</label>
				            <select name="select-choice-1" id="select-choice-1">
					                <option value="standard">Standard: 7 day</option>
					                <option value="rush">Rush: 3 days</option>
					                <option value="express">Express: next day</option>
					                <option value="overnight">Overnight</option>
				            </select>
				            <fieldset class="ui-grid-a">
							<a href="" data-role="button"  class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini submit"  key="{{$key}}">button</a>
					    <a href="" data-rel="back" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">Cancel</a>
				            </fieldset>
				     
			</form>

		</div>

		@endforeach
	</ul>
	<footer data-role="footer">
		<h1>Footer</h1>
	</footer><!-- /footer -->
</section><!-- /page -->

<script type="text/javascript" charset="utf-8" async defer>

	$('.submit').on("click",function() {
		var key = $(this).attr("key");
		$.post('',
		 $('#post'+key).serialize(),
		function(data) {
		       console.log(data);
	        }
		)
	},

	)
</script>
@endsection
