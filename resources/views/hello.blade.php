@extends("layout")
@section("content")
@foreach($list as $product)
<div class="row">
	<div class="col-sm-3 col-3">
		<img src="{{$product['product_base']['main_img']}}" alt="" class="img-responsive img-thumbnail">
	</div>
	<div class="col-sm-3 col-3"></div>
	<div class="col-sm-3 col-3">
		<span >{{$product['product_base']['name']}}</span>
	</div>
	<div class="col-sm-3 col-3"><a href="express" title="发货" class="btn btn-primary">发货</a></div>
</div>
<hr>
@endforeach
@endsection