@extends("layout")
@section("content")
@foreach($list as $user)
<div class="row">
	<div class="col-sm-3">
		<img src="{{$user['headimgurl']}}" alt="">
	</div>
	<div class="col-sm-3">
		<span class="text-success">{{$user['nickname']}}</span>
	</div>
	<div class="col-sm-3"><p class="btn btn-default">saldkfjslkdfj</p></div>
	<div class="col-sm-3"><p class="bg-danger"><a href="express" title="发货" class="btn btn-default">发货</a></p></div>
</div>
<hr>
@endforeach
@endsection