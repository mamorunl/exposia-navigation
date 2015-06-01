<div class="row">
    <div class="col-md-8">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    @lang('admincms-navigation::pages.create.page_settings')
                </h3>
                <span class="pull-right clickable">
                    <i class="fa fa-minus"></i>
                </span>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{!! ($errors->has('name')) ? " has-error" : "" !!}">
                        {!! Form::label('name', trans('admincms-navigation::pages.fields.name')) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        @if($errors->has('name'))
                            <div class="help-block">
                                {!! $errors->first('name') !!}
                            </div>
                        @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group{!! ($errors->has('slug')) ? " has-error" : "" !!}">
                            {!! Form::label('slug', trans('admincms-navigation::pages.fields.slug')) !!}
                            {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                            @if($errors->has('slug'))
                            <div class="help-block">
                                {!! $errors->first('slug') !!}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    @lang('admincms-navigation::pages.create.seo_settings')
                </h3>
                <span class="pull-right clickable">
                    <i class="fa fa-minus"></i>
                </span>
            </div>
            <div class="panel-body">
                <div class="form-group{!! ($errors->has('meta_description')) ? " has-error" : "" !!}">
                    {!! Form::label('meta_description', trans('admincms-navigation::pages.fields.meta_description')) !!}
                    {!! Form::text('meta_description', null, ['class' => 'form-control']) !!}
                    @if($errors->has('meta_description'))
                    <div class="help-block">
                        {!! $errors->first('meta_description') !!}
                    </div>
                    @endif
                </div>

                <div class="form-group{!! ($errors->has('meta_keywords')) ? " has-error" : "" !!}">
                    {!! Form::label('meta_keywords', trans('admincms-navigation::pages.fields.meta_keywords')) !!}
                    {!! Form::text('meta_keywords', null, ['class' => 'form-control']) !!}
                    @if($errors->has('meta_keywords'))
                    <div class="help-block">
                        {!! $errors->first('meta_keywords') !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<section class="content paddingleft_right15">
    <div class="alert alert-success alert-dismissable visible-xs visible-md">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @lang('admincms-navigation::pages.warning_drag_drop')
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"> <i class="livicon" data-name="map" data-size="14" data-loop="true" data-c="white" data-hc="white"></i>
                @lang('admincms-navigation::pages.editor_title')
            </h3>
            <span class="pull-right clickable">
                <i class="fa fa-chevron-up"></i>
            </span>
        </div>
        <div class="panel-body">
            <div class="row" style="padding:30px;">
                <div id="canvas" class="canvas-wrapper">

                </div>
                <input type="hidden" value="" name="serialized_template" id="serialized_template">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('admincms::global.save')</button>
            </div>
        </div>
    </div>

</section>

<div class="modal fade" id="set-template-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">@lang('admincms-navigation::pages.select_template.title')</h4>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admincms::global.cancel')</button>
            </div>
        </div>
    </div>
</div>