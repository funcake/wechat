@extends("layout")
@section("content")
@foreach($list as $product)
<div class="row">
	<div class="col-sm-5 col-5">
		<img src="{{chop($product['product_base']['main_img'],'?wx_fmt=jpeg')}}" alt="" class="img-thumbnail">
	</div>
	<div class="col-sm-4 col-4">
		<span >{{$product['product_base']['name']}}</span>
	</div>
	<div class="col-sm-3 col-3"><a href="express" title="发货" class="btn btn-primary">发货</a></div>
</div>
<hr>
@endforeach
@endsection