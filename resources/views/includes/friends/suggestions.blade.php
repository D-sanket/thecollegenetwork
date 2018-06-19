@extends('includes.friends.base')

@section('panel-title')
	Friend suggestions
@endsection

@section('panel-users')
	{{ $users = \App\User::all() }}
@endsection