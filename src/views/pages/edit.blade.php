@extends('exposia::index')

@section('title')
    @lang('exposia-navigation::pages.edit.title')
@stop

@section('content')
    {!! Form::model($page, ['method' => 'put', 'route' => ['admin.pages.update', $page->id], 'files' => true]) !!}
        @include('exposia-navigation::pages._form')
    {!! Form::close() !!}
@stop