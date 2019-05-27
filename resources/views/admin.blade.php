@extends("layout")

@section("content")

@foreach($users as $user)

<div>
	{{$user['group']}}
</div>

@endforeach

@endsection
