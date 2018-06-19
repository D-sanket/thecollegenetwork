@extends('includes.friends.base')

@section('panel-title')
	Sent requests
@endsection

@section('panel-users')
	{{ $users = \App\User::where('course_year', 3)->get() }}
@endsection