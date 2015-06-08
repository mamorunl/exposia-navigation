@extends('exposia::index')

@section('title')
    @lang('admincms-navigation::pages.edit.title')
@stop

@section('content')
    {!! Form::model($page, ['method' => 'put', 'route' => ['admin.pages.update', $page->id], 'files' => true]) !!}
        @include('admincms-navigation::pages._form')
    {!! Form::close() !!}
@stop