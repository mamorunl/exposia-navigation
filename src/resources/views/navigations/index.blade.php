@extends('exposia::index')

@section('title')
    @choice('exposia-navigation::navigations.index.title', count($navigations)) <a href="{{ route('admin.navigations.create') }}" class="btn btn-primary pull-right">@lang('exposia::global.create')</a>
@stop

@section('content')
    <div class="row">
    @foreach($navigations as $nav)
        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
            <div class="panel panel-default image-panel">
                <a href="#">
                    <span></span>
                </a>
                <ul class="list-group">
                    <li class="list-group-item">
                        <i class="fa fa-cube"></i>
                        {{ $nav->name }}
                    </li>
                </ul>
                <div class="panel-footer">
                    <a href="{{ route('admin.navigations.show', $nav->id) }}" class="btn btn-default">@lang('exposia-navigation::navigations.select')</a>
                    <a class="btn btn-primary pull-right" href="{{ route('admin.navigations.edit', $nav->id) }}">@lang('exposia::global.edit')</a>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@stop
