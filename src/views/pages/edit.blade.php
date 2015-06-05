@extends('admincms::index')

@section('title')
    @lang('admincms-navigation::pages.edit.title')
@stop

@section('content')
    {!! Form::model($page, ['method' => 'put', 'route' => ['admin.pages.update', $page->id], 'files' => true]) !!}
        @include('admincms-navigation::pages._form')
    {!! Form::close() !!}
@stop

@section('scripts')
    <script src="{{ asset('backend/assets/js/jquery.rapidgrid.js') }}"></script>
    <script src="{{ asset('backend/assets/js/grid_manager.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
@stop

@section('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/rapidgrid.css') }}"/>
@stop