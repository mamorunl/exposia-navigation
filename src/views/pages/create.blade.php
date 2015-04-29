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
                    <div id="mycanvas">

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
                        <div class="col-md-4">
                            <a href="#" data-templateid="1">
                                <img src="/template_files/single/template.jpg" alt="" class="img-responsive">
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="#" data-templateid="2">
                                <img src="/template_files/single/template.jpg" alt="" class="img-responsive">
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="#" data-templateid="3">
                                <img src="/template_files/single/template.jpg" alt="" class="img-responsive">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('backend/assets/vendor/gridmanager/dist/js/jquery.gridmanager.js') }}"></script>
    <script src="{{ asset('backend/assets/js/grid_manager.js') }}"></script>
@stop