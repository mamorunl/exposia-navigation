@extends('exposia::index')

@section('title')
    @lang('exposia-navigation::navigations.show.title') <em>{{ $nav->name }}</em>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-success">
                <h3 class="panel-heading">
                    @lang('exposia-navigation::navigations.show.select_page')
                </h3>
                <div class="panel-body">
                    <ul>
                        @foreach($pages as $page)
                            <li>
                                {{ $page->title }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <h3 class="panel-heading">
                    @lang('exposia-navigation::navigations.show.panel_heading')
                </h3>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
@stop