@extends("layout")
@section("content")

@foreach($users as $user)

<img src="{{$user['avator']}}" alt="">

@endforeach

@endsection
