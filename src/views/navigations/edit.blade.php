@extends('exposia::index')

@section('title')
    @lang('exposia-navigation::navigations.edit.title')
@stop

@section('content')
    {!! Form::model($nav, ['method' => 'put', 'route' => ['admin.navigations.update', $nav->id]]) !!}
    @include('exposia-navigation::navigations._form')
    {!! Form::close() !!}
@stop