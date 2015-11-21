@extends('exposia::index')

@section('title')
    @lang('exposia-navigation::navigations.show.title')
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">@lang('exposia-navigation::navigations.page_add_to_nav_widget.title')</h3>
                </div>
                <div class="panel-body">
                    <ul class="navigation draggable-list">
                        @foreach($pages as $page)
                            <li id="navigation-item-new-{{ $page->id }}" class="navigation-item" data-name="{{ $page->title }}" data-id="999{{ $page->id }}" data-navigationnodeid="{{ $page->node->id }}" data-slug="{{ $page->node->slug }}">
                                <div>{{ $page->node->name }}
                                    <div class="pull-right">
                                        @if(count(Config::get('website.languages')) > 0)
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    @lang('exposia-navigation::navigations.translations') <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    @foreach(Config::get('website.languages') as $abbr => $lang)
                                                        @if($abbr != Config::get('app.locale'))
                                                            <li><a href="{{ route('admin.translations.edit', [$page->id, $abbr]) }}" title="@lang('exposia-navigation::pages.index.edit_language')"><i class="fa fa-language"></i> {{ $lang['name'] }}</a></li>
                                                        @endif
                                                    @endforeach

                                                </ul>
                                            </div>
                                        @endif
                                        @if($page != null)
                                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-default btn-xs">
                                                @lang('exposia::global.edit')
                                            </a>
                                        @endif
                                        <a href="#" class="remove-navigation-node btn btn-danger btn-xs">@lang('exposia::global.destroy')</a>
                                    </div>
                                    <div>
                                        <em class="text-muted"><small>{{ $page->node->slug }}</small></em>
                                    </div>
                                </div>
                                <ol></ol>
                            </li>
                        @endforeach
                    </ul>

                    {!! $pages->render() !!}
                </div>
            </div>

            <div class="panel panel-default" id="panel-node">
                <div class="panel-heading">
                    <h3 class="panel-title">@lang('exposia-navigation::navigations.node_add_to_nav_widget.title')</h3>
                </div>
                <div class="panel-body">
                    <ul class="navigation draggable-list">
                        @foreach($nodes as $node)
                            <li id="navigation-item-new-{{ $node->id }}" class="navigation-item" data-navigationnodeid="{{ $node->id }}" data-slug="{{ $node->slug }}">
                                <div>{{ $node->name }}
                                    <div class="pull-right">
                                        <a href="#" class="btn-confirm-delete btn btn-danger btn-xs">@lang('exposia::global.destroy')</a>
                                        <a href="#" class="remove-navigation-node btn btn-danger btn-xs">@lang('exposia::global.destroy')</a>
                                        {!! Form::open(['method' => 'delete', 'route' => ['admin.navigationnodes.destroy', $node->id]]) !!}
                                        {!! Form::close() !!}
                                    </div>
                                    <div>
                                        <em class="text-muted"><small>{{ $node->slug }}</small></em>
                                    </div>
                                </div>
                                <ol></ol>
                            </li>
                        @endforeach
                    </ul>
                    <a href="#add-node-modal" data-toggle="modal" data-target="#add-node-modal" class="huge-button"><i class="material-icons">add</i></a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ $nav->name }}
                    </h3>
                </div>
                <div class="panel-body">
                    <p>
                        @lang('exposia-navigation::navigations.show.drag_to_rearrange')
                    </p>
                    {!! Form::open(['method' => 'post', 'route' => ['admin.navigations.save-sequence', $nav->id]]) !!}
                        <button type="submit" class="savesequence btn btn-primary">@lang('exposia::global.save')</button>
                        <div id="draggable-navigation">
                            <ul class="navigation draggable-list" id="navigation-edit-draggable">
                                @foreach($nav->nodes as $index => $node)
                                    @include('exposia-navigation::navigations._childLoop', ['node' => $node])
                                @endforeach
                            </ul>
                        </div>
                    <input id="sequencedata" name="sequencedata" type="hidden"/>
                    <button type="submit" class="savesequence btn btn-primary">@lang('exposia::global.save')</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <div class="modal fade" id="add-node-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['method' => 'post', 'route' => 'admin.navigationnodes.store']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('exposia-navigation::navigations.node_add_to_nav_widget.modal_title')</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {!! Form::label('name', trans('exposia-navigation::pages.fields.name')) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        @if($errors->has('name'))
                            <div class="help-block">
                                {!! $errors->first('name') !!}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                        {!! Form::label('slug', trans('exposia-navigation::pages.fields.slug')) !!}
                        {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                        @if($errors->has('slug'))
                            <div class="help-block">
                                {!! $errors->first('slug') !!}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('target') ? ' has-error' : '' }}">
                        {!! Form::label('target', trans('exposia-navigation::pages.fields.target')) !!}
                        {!! Form::select('target', Exposia\Navigation\Models\NavigationNode::getTargets(), null, ['class' => 'form-control']) !!}
                        @if($errors->has('target'))
                            <div class="help-block">
                                {!! $errors->first('target') !!}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">@lang('exposia::global.close')</button>
                    <button type="submit" class="btn btn-primary">@lang('exposia::global.save')</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script src="/backend/assets/vendor/jquery-sortable/jquery-sortable.js"></script>
    <script>
        $(document).ready(function() {
            $('.draggable-list').sortable({
                group: "draggable-list",
                delay: 5,
                placeholder: '<li class="placeholder"><div>&nbsp;</div></li>'
            });
            $('.savesequence').click(function(e) {
                e.preventDefault();
                var data = $('#navigation-edit-draggable').sortable("serialize").get();
                var jsonStr = JSON.stringify(data, null, '');
                $('#sequencedata').val(jsonStr);
                $(this).parent('form').submit();
            });
        });
        $('.remove-navigation-node').click(function(e) {
            e.preventDefault();
            $(this).closest('li').remove();
        });

        $('.btn-confirm-delete').click(function(e) {
            e.preventDefault();
            var $link = $(this);
            bootbox.confirm({
                message: "{{ trans('exposia::global.confirm_destroy', ['resource' => 'deze link']) }}",
                callback: function(result) {
                    if(result) {
                        $link.siblings('form').submit();
                    }
                }
            });
        });
    </script>
@stop

@section('style')
    <style type="text/css">
        #panel-node .remove-navigation-node, #draggable-navigation .btn-confirm-delete {
            display: none;
        }
    body.dragging, body.dragging * {
    cursor: move !important;
    }

    .dragged {
    position: absolute;
    opacity: 0.5;
    z-index: 2000;
    border: 1px dotted #37bc9b;
    }

    .draggable-list {
    list-style: none;
    margin: 0;
    padding: 0;
    }

    .draggable-list ul, .draggable-list ol {
    list-style: none;
    }

    .draggable-list li, .draggable-list .placeholder {
    line-height: 24px;
    margin-bottom: 10px;
    margin-top: 10px;
    }

    .draggable-list li > div, .draggable-list .placeholder > div {
    background-color: #3a3f51;
    color: #fff;
    padding: 7px 10px;
    }

    .draggable-list li:hover, .draggable-list .placeholder:hover {
    cursor: move;
    }

    .draggable-list .placeholder {
    position: relative;
    border: 1px dotted #7266ba;
    }

    .draggable-list .placeholder > div {
    background: transparent;
    }


    .draggable-table {
    border: none;
    }

    .draggable-table td {
    border: none !important;
    padding: 0 !important;
    }
    </style>
@stop