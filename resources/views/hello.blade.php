@extends("layout")
@section("content")
<section id="home" data-role="page">
	<header data-role="header">
		<h1>上架商品管理</h1>
	</header><!-- /header -->
	<form action="" method="post" accept-charset="utf-8">
		<input type="text" name="" value="asd">
		<input type="submit" name="submit" value="sub" class="update">
	</form>
	<footer data-role="footer">
		<h1>Footer</h1>
	</footer><!-- /footer -->
</section><!-- /page -->
@foreach($list as $key =>$product)
<!-- <div class="row update"   >
	<div class="col-sm-5 col-5">
		<img src="{{chop($product['product_base']['main_img'],'?wx_fmt=jpeg')}}" alt="" class="img-thumbnail">
	</div>

	<div class="col-sm-4 col-4">
			<input type="text" class="form-control" name="name" value="{{$product['product_base']['name']}}" >
			<br>
		<div class="input-group">
			<span class="input-group-addon">￥</span><input type="text" class="form-control {{$key}}" name="price" value="{{$product['sku_list'][0]['price']}}" aria-describedby="basic-addon2">
			 <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
 
      </div>
		</div>
	</div>
	<input class="col-sm-2 col-2 btn btn-primary" name="submit" id="{{$product['product_id']}}" type="submit"  value="发货">

	<div>

		<input id="{{$key}}" class="slider" name="slider" type="text"   data-slider-min="0" data-slider-max="1000" data-slider-step="10" data-slider-value="{{$product['sku_list'][0]['price']}}" />			
	</div>
</div> -->
<hr>
@endforeach
<script type="text/javascript" charset="utf-8" async defer>
	$('.update').on('click',function(e){
		e.preventDefault();
			$.post(
				"https://api.weixin.qq.com/merchant/getbystatus?access_token={{$token}}",
				{	
					"product_id" : 123,
							// name: posts.filter('[name = "name"]').attr('value');
							"product_base" : {

							},

							"sku_list": [
							{
								"price": 123
							}
							],
					},
					function(data) {
						console.log(data);
					}
			);
		});


</script>
@endsection
