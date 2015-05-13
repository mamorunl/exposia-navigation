@extends('admincms::index')

@section('title')
    Nieuwe pagina
@stop

@section('content')
    <section class="content paddingleft_right15">
        <div class="alert alert-success alert-dismissable visible-xs visible-md">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            May not work properly in touch enabled devices as it as requires drag and drop.
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> <i class="livicon" data-name="map" data-size="14" data-loop="true" data-c="white" data-hc="white"></i>
                    Page Builder
                </h3>
            <span class="pull-right clickable">
                <i class="glyphicon glyphicon-chevron-up"></i>
            </span>
            </div>
            <div class="panel-body">
                <div class="row" style="padding:30px;">
                    {!! Form::open(['method' => 'post', 'route' => 'admin.pages.store']) !!}
                    <div id="canvas" class="canvas">

                    </div>
                    <input type="hidden" value="" name="serialized_template" id="serialized_template">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('admincms::global.save')</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </section>

    <div class="modal fade" id="set-template-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Select template</h4>
                </div>
                <div class="modal-body" id="template_picker">
                    <div class="row">
                        @foreach($templates as $template_name => $image)
                        <div class="col-md-4">
                            <a href="#" data-templatename="{{ $template_name }}" class="text-center" style="display:block;">
                                <h2>{{ ucwords($template_name) }}</h2>
                                <img src="{{ $image }}" alt="" class="img-responsive">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('backend/assets/js/jquery.rapidgrid.js') }}"></script>
    <script src="{{ asset('backend/assets/js/grid_manager.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
    <script>


    </script>
@stop

@section('styles')
    <style>
        /* vertical alignment styles */

        .col-top {
            vertical-align: top;
        }
        .col-middle {
            vertical-align: middle;
        }
        .col-bottom {
            vertical-align: bottom;
        }

        /* columns of same height styles */

        #canvas .canvas-wrapper .row { border-right: 20px solid black; margin-bottom: 2px; }

        #canvas .canvas-wrapper .row-full-height {
            height: 100%;
        }
        #canvas .canvas-wrapper .col-full-height {
            height: 100%;
            vertical-align: middle;
        }
        #canvas .canvas-wrapper .row-same-height {
            display: table;
            width: 100%;
            /* fix overflow */
            table-layout: fixed;
        }
        #canvas .canvas-wrapper .col-xs-height {
            display: table-cell;
            float: none !important;
        }


        #canvas .canvas-wrapper [class*="col-"] {
            padding-top: 0;
            padding-bottom: 0;
            border: 1px solid #80aa00;
            background: #d6ec94;
        }
        #canvas .canvas-wrapper [class*="col-"]:before {
            display: block;
            position: relative;
            content: "";
            margin-bottom: 8px;
            font-family: sans-serif;
            font-size: 10px;
            letter-spacing: 1px;
            color: #658600;
            text-align: left;
        }
        #canvas .canvas-wrapper .col-full-height:before {
            content:"";
        }
    </style>
@stop