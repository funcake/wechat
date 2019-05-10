@extends("layout")
@section("content")

@foreach($users as $user)

<img src="{{$user['avatar']}}" alt="">

@endforeach

@endsection
