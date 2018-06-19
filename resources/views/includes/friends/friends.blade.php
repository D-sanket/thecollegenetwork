@extends('includes.friends.base')

@section('panel-title')
	Friends
@endsection

@section('panel-users')
	{{ $users = \App\User::all() }}
@endsection