@extends("layout")
@section("content")
@foreach($list as $user)
<div class="row">
	<div class="col-sm-3 col-3">
		<img src="{{$user['headimgurl']}}" alt="" class="img-responsive">
	</div>
	<div class="col-sm-3 col-3"></div>
	<div class="col-sm-3 col-3">
		<span >{{$user['nickname']}}</span>
	</div>
	<div class="col-sm-3 col-3"><a href="express" title="发货" class="btn btn-primary">发货</a></div>
</div>
<hr>
@endforeach
@endsection