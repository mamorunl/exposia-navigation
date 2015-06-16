@extends('exposia::index')

@section('title')
    @lang('exposia-navigation::navigations.create.title')
@stop

@section('content')
    {!! Form::open(['method' => 'post', 'route' => 'admin.navigations.store']) !!}
        @include('exposia-navigation::navigations._form')
    {!! Form::close() !!}
@stop