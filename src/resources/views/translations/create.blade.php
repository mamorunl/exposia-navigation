@extends('exposia::index')

@section('title')
    @lang('exposia-navigation::translations.create.title') (<img src="{{ asset('backend/assets/img/flags/' . $language . '.png') }}" alt="{{ $language }}" />)
@stop

@section('content')
    {!! Form::model($page, ['method' => 'put', 'route' => ['admin.translations.update', $page->id, $language], 'files' => true]) !!}
    @include('exposia-navigation::translations._form')
    {!! Form::close() !!}
@stop