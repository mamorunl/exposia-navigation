@extends('admincms::index')

@section('title')
    Pagina wijzigen
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
                <i class="fa fa-chevron-up"></i>
            </span>
            </div>
            <div class="panel-body">
                <div class="row" style="padding:30px;">
                    {!! Form::open(['method' => 'put', 'route' => ['admin.pages.update', $page->id]]) !!}
                    <div id="canvas" class="canvas-wrapper">
                        {!! $template_data !!}
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
@stop

@section('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/rapidgrid.css') }}"/>
@stop
