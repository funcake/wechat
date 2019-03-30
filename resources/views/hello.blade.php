@extends("layout")
@section("content")
@foreach($list as $key =>$product)
<div class="row"  id="{{$key}}">
	<div class="col-sm-5 col-5">
		<img src="{{chop($product['product_base']['main_img'],'?wx_fmt=jpeg')}}" alt="" class="img-thumbnail">
	</div>
	<div class="col-sm-4 col-4">
  <input type="text" class="form-control" name="name" value="{{$product['product_base']['name']}}" >
<br>
  <input type="text" class="form-control" name="price" value="{{$product['sku_list'][0]['price']}}" aria-describedby="basic-addon2">
	
			<br class="slider" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="{{$product['sku_list'][0]['price']}}" />			
	</div>
	<div class="col-sm-2 col-2 btn btn-primary" id="$product['product_id']">发货</div>
</div>
<hr>
@endforeach
<script src="https://cdn.bootcss.com/bootstrap-slider/10.6.1/bootstrap-slider.min.js"></script>
<script type="text/javascript" charset="utf-8" async defer>
	var slider = $('.slider');

	slider.slider();
	slider.on('slide',function(slideEvt) {
		$(this).prev().prev().val(slideEvt.value);
	});

	$('.btn').click(function() {
		var posts = $(this).prev().children('input');
		$.ajax({
			type : 'POST',
			url : 'http://fljy.shop',
			data:
			{	
				"product_id" : $(this).attr('id'),
				// name: posts.filter('[name = "name"]').attr('value');
				"product_base" : {

				},

				"sku_list": [
					{
						"price": posts.filter('[name = "price"]').val()
					}
				],

			},
		});
	});
</script>
@endsection
