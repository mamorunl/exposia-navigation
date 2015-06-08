@extends('exposia::index')

@section('title')
    @lang('admincms-navigation::pages.create.title')
@stop

@section('content')
    {!! Form::open(['method' => 'post', 'route' => 'admin.pages.store', 'files' => true]) !!}
        @include('admincms-navigation::pages._form')
    {!! Form::close() !!}
@stop