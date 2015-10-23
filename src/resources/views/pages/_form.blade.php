<style>
    /* Only temporarily! */
    .p7 {
        padding: 7px;
    }

    .visual-editor-field {
        min-height: 32px;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .visual-editor-field-inline {
        display: inline-block;
    }

    .visual-editor-field:hover {
        border: 1px dotted #ccc;
    }

    .btn-group-settings {
        display: none;
        position: absolute;
    }

    .rg-col {
        position: relative;
    }

    .rg-col:hover > .btn-group-settings {
        display: inline-block;
    }

    .canvas-wrapper .canvas .canvas {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    @lang('exposia-navigation::pages.create.page_settings')
                </h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group{!! ($errors->has('title')) ? " has-error" : "" !!}">
                            {!! Form::label('title', trans('exposia-navigation::pages.fields.title')) !!}
                            {!! Form::text('title', null, ['class' => 'form-control']) !!}
                            @if($errors->has('title'))
                                <div class="help-block">
                                    {!! $errors->first('title') !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group{!! ($errors->has('name')) ? " has-error" : "" !!}">
                            {!! Form::label('name', trans('exposia-navigation::pages.fields.name')) !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            @if($errors->has('name'))
                                <div class="help-block">
                                    {!! $errors->first('name') !!}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group{!! ($errors->has('slug')) ? " has-error" : "" !!}">
                            {!! Form::label('slug', trans('exposia-navigation::pages.fields.slug')) !!}
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

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="livicon" data-name="map" data-size="14" data-loop="true"
                                           data-c="white" data-hc="white"></i>
                    @lang('exposia-navigation::pages.editor_title')
                </h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-success alert-dismissable visible-xs visible-md">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    @lang('exposia-navigation::pages.warning_drag_drop')
                </div>
                <div class="row" style="padding:30px;">
                    <div id="canvas" class="canvas-wrapper canvas">
                        {!! isset($template_data) ? $template_data : "" !!}
                    </div>
                    <input type="hidden" value="" name="serialized_template" id="serialized_template">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3" id="extra-settings-sidebar">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        @lang('exposia-navigation::pages.create.advanced_settings')
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="form-group{!! ($errors->has('main_template')) ? " has-error" : "" !!}">
                        {!! Form::label('main_template', trans('exposia-navigation::pages.fields.main_template')) !!}
                        {!! Form::select('main_template', $main_templates, (isset($page) ? $page->main_template : 'index'), ['class' => 'form-control']) !!}
                        @if($errors->has('main_template'))
                            <div class="help-block">
                                {!! $errors->first('main_template') !!}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" class="btn btn-primary"><i
                                class="material-icons">done</i> @lang('exposia::global.save')</button>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        @lang('exposia-navigation::pages.create.seo_settings')
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="form-group{!! ($errors->has('seo_title')) ? " has-error" : "" !!}">
                        {!! Form::label('seo_title', trans('exposia-navigation::pages.fields.seo_title')) !!}
                        {!! Form::text('seo_title', null, ['class' => 'form-control']) !!}
                        @if($errors->has('seo_title'))
                            <div class="help-block">
                                {!! $errors->first('seo_title') !!}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{!! ($errors->has('meta_description')) ? " has-error" : "" !!}">
                        {!! Form::label('meta_description', trans('exposia-navigation::pages.fields.meta_description')) !!}
                        {!! Form::textarea('meta_description', null, ['class' => 'form-control', 'rows' => 3]) !!}
                        @if($errors->has('meta_description'))
                            <div class="help-block">
                                {!! $errors->first('meta_description') !!}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{!! ($errors->has('meta_keywords')) ? " has-error" : "" !!}">
                        {!! Form::label('meta_keywords', trans('exposia-navigation::pages.fields.meta_keywords')) !!}
                        {!! Form::text('meta_keywords', null, ['class' => 'form-control']) !!}
                        @if($errors->has('meta_keywords'))
                            <div class="help-block">
                                {!! $errors->first('meta_keywords') !!}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{!! ($errors->has('include_in_sitemap')) ? " has-error" : "" !!}">
                        {!! Form::label('include_in_sitemap', trans('exposia-navigation::pages.fields.include_in_sitemap')) !!}
                        {!! Form::select('include_in_sitemap', [1 => trans('exposia::global.yes'), 0 => trans('exposia::global.no')], null, ['class' => 'form-control']) !!}
                        @if($errors->has('include_in_sitemap'))
                            <div class="help-block">
                                {!! $errors->first('include_in_sitemap') !!}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{!! ($errors->has('robots_index')) ? " has-error" : "" !!}">
                        {!! Form::label('robots_index', trans('exposia-navigation::pages.fields.robots_index')) !!}
                        {!! Form::select('robots_index', ['index' => 'index', 'noindex' => 'noindex'], null, ['class' => 'form-control']) !!}
                        @if($errors->has('robots_index'))
                            <div class="help-block">
                                {!! $errors->first('robots_index') !!}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{!! ($errors->has('robots_follow')) ? " has-error" : "" !!}">
                        {!! Form::label('robots_follow', trans('exposia-navigation::pages.fields.robots_follow')) !!}
                        {!! Form::select('robots_follow', ['follow' => 'follow', 'nofollow' => 'nofollow'], null, ['class' => 'form-control']) !!}
                        @if($errors->has('robots_follow'))
                            <div class="help-block">
                                {!! $errors->first('robots_follow') !!}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{!! ($errors->has('canonical_url')) ? " has-error" : "" !!}">
                        {!! Form::label('canonical_url', trans('exposia-navigation::pages.fields.canonical_url')) !!}
                        {!! Form::text('canonical_url', null, ['class' => 'form-control']) !!}
                        @if($errors->has('canonical_url'))
                            <div class="help-block">
                                {!! $errors->first('canonical_url') !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="set-template-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">@lang('exposia-navigation::pages.select_template.title')</h4>
            </div>
            <div class="modal-body" id="template_picker">
                <div class="row">
                    @foreach($templates as $template_name => $image)
                        <div class="col-md-3">
                            <a href="#" data-templatename="{{ $template_name }}" class="text-center"
                               style="display:block;">
                                <img src="{{ $image }}" alt="" class="img-responsive">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">@lang('exposia::global.cancel')</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="settings-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('exposia-navigation::pages.settings_modal.title')</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#row-settings" data-toggle="tab">
                            @lang('exposia-navigation::pages.settings_modal.row_tab')
                        </a>
                    </li>
                    <li>
                        <a href="#col-settings" data-toggle="tab">
                            @lang('exposia-navigation::pages.settings_modal.column_tab')
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="row-settings">
                        <div class="form-group{!! ($errors->has('custom_class_row')) ? " has-error" : "" !!}">
                            {!! Form::label('custom_class_row', 'Extra class name') !!}
                            {!! Form::text('custom_class_row', null, ['class' => 'form-control']) !!}
                            @if($errors->has('custom_class_row'))
                                <div class="help-block">
                                    {!! $errors->first('custom_class_row') !!}
                                </div>
                            @endif
                        </div>

                        <div class="form-group{!! ($errors->has('has_container')) ? " has-error" : "" !!}">
                            {!! Form::label('has_container', 'Container') !!}
                            {!! Form::select('has_container', ['0' => trans('exposia-navigation::pages.settings_modal.fields.container_fluid'), 1 => trans('exposia-navigation::pages.settings_modal.fields.container')], null, ['class' => 'form-control']) !!}
                            @if($errors->has('has_container'))
                                <div class="help-block">
                                    {!! $errors->first('has_container') !!}
                                </div>
                            @endif
                        </div>

                        <div class="form-group{!! ($errors->has('background_image')) ? " has-error" : "" !!}">
                            {!! Form::label('background_image', 'Background image') !!}
                            {!! Form::text('background_image', null, ['class' => 'form-control']) !!}
                            @if($errors->has('background_image'))
                                <div class="help-block">
                                    {!! $errors->first('background_image') !!}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <button class="btn btn-danger btn-delete-row"><i class="fa fa-trash-o"></i> Delete row
                            </button>
                        </div>
                    </div>

                    <div class="tab-pane" id="col-settings">
                        <div class="form-group{!! ($errors->has('custom_class_col')) ? " has-error" : "" !!}">
                            {!! Form::label('custom_class_col', 'Extra class name') !!}
                            {!! Form::text('custom_class_col', null, ['class' => 'form-control']) !!}
                            @if($errors->has('custom_class_col'))
                                <div class="help-block">
                                    {!! $errors->first('custom_class_col') !!}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <button class="btn btn-danger btn-reset-col"><i class="fa fa-refresh"></i> Reset column
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">@lang('exposia::global.close')</button>
            </div>
        </div>
    </div>
</div>

<div id="output"></div>

@section('script')
    @parent
    <script src="{{ asset('backend/assets/js/jquery.rapidgrid.js') }}"></script>
    <script src="{{ asset('backend/assets/js/grid_manager.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/jquery-ui-custom/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $settings_bar = $('#extra-settings-sidebar > div');
            $settings_bar.width($settings_bar.width());
            $settings_bar.css({position: 'fixed', right: '30px'});

            $(window).resize(function() {
                $('#extra-settings-sidebar > div').width($('#extra-settings-sidebar > div').width());
            });

            $('#canvas').rapidgrid({
                controlButtons: [[12], [8, 4], [9, 3], [5, 2, 5], [6, 6], [4, 4, 4], [3, 3, 3, 3], [2, 2, 2, 2, 2, 2]],
                translations: {
                    close: '@lang('exposia::global.close')',
                    row_layout: '@lang('exposia-navigation::pages.settings_modal.select_row_layout')',
                    add: '@lang('exposia::global.add')'
                }
            });

            $('#name').blur(function () {
                var $slug = $('#slug');
                if ($slug.val().length <= 1) {
                    $slug.val("/" + $(this).val().toLowerCase()
                                    .replace(/\s+/g, '-')           // Replace spaces with -
                                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                                    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                                    .replace(/^-+/, '')             // Trim - from start of text
                                    .replace(/-+$/, ''));            // Trim - from end of text
                }
            });

            $('body').tooltip({
                'selector': '[data-toggle=tooltip]',
                'container': 'body'
            });

        });
    </script>
    <script src="{{ asset('backend/assets/vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
@stop

@section('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/rapidgrid.css') }}"/>
    <script src="/backend/assets/vendor/tinymce/tinymce.min.js"></script>
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/bootstrap-select/css/bootstrap-select.min.css') }}"/>
@stop