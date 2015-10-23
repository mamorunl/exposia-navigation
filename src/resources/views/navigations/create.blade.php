@extends('exposia::index')

@section('title')
    @lang('exposia-navigation::navigations.create.title')
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6">
            {!! Form::open(['method' => 'post', 'route' => 'admin.navigations.store']) !!}
            @include('exposia-navigation::navigations._form')
            {!! Form::close() !!}
        </div>
    </div>
@stop