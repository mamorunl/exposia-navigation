@extends('exposia::index')

@section('title')
    @lang('exposia-navigation::translations.create.title') <small>{{ $language['name'] }}</small>
@stop

@section('content')
    {!! Form::model($page, ['method' => 'put', 'route' => ['admin.translations.update', $page->id, key($language)], 'files' => true]) !!}
    @include('exposia-navigation::translations._form')
    {!! Form::close() !!}
@stop