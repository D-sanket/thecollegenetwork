@extends('includes.friends.base')

@section('panel-title')
	Friend requests
@endsection

@section('panel-users')
	{{ $users = \App\User::all() }}
@endsection