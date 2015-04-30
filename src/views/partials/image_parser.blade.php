<input type="hidden" value="{{ $xpo_id }}" name="{{ $key }}[xpo_id]">
<div style="overflow: hidden; display: block;">
    <a href="#modal_{{ $key }}" data-toggle="modal" data-target="#modal_{{ $key }}" style="display: block;{{ $attributes }}">
        <img src="{{ $values['src'] }}" alt="" id="{{ $key }}">
    </a>
</div>

<div class="modal fade" id="modal_{{$key}}" tabindex="-1" role="dialog" aria-labelledby="modal_{{ $key }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="@lang('admincms::global.close')"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_{{ $key }}">@lang('admincms-navigation::parsers.image.title')</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="col-md-4">
                    <img src="{{ $values['src'] }}" alt="" class="img-responsive" id="preview_image_{{ $key }}">
                    <div class="file-select btn btn-primary btn-block">
                        @lang('admincms-navigation::parsers.image.select_file')
                        <input type="file" id="upload_{{ $key }}" class="form-control" name="{{ $key }}[file]" onchange="changepreview{{ $key }}();">
                    </div>
                </div>
                <div class="col-md-8">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#image-tab-for-{{ $key }}" data-toggle="tab" role="tab"><i class="fa fa-picture-o"></i> @lang('admincms-navigation::parsers.image.tabs.image')</a>
                            </li>
                            <li role="presentation">
                                <a href="#link-tab-for-{{ $key }}" data-toggle="tab" role="tab"><i class="fa fa-external-link"></i> @lang('admincms-navigation::parsers.image.tabs.link')</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="image-tab-for-{{ $key }}" role="tabpanel">
                                <div class="form-group">
                                    <label>@lang('admincms-navigation::parsers.image.fields.alt')</label>
                                    <input type="text" name="{{ $key }}[alt]" class="form-control" value="{{ $values['alt'] }}">
                                </div>
                            </div>

                            <div class="tab-pane" id="link-tab-for-{{ $key }}" role="tabpanel">
                                <div class="form-group">
                                    <label>@lang('admincms-navigation::parsers.image.fields.href')</label>
                                    <input type="text" name="{{ $key }}[href]" class="form-control" value="{{ $values['href'] }}">
                                </div>

                                <div class="form-group">
                                    <label>@lang('admincms-navigation::parsers.image.fields.target')</label>
                                    <select name="{{ $key }}[target]" class="form-control">
                                        <option value="_self"{{ ($values['target'] == "_self" || $values['target'] == "" ? " selected" : "") }}>@lang('admincms-navigation::parsers.image.fields.target_self')</option>
                                        <option value="_blank"{{ ($values['target'] == "_blank" ? " selected" : "") }}>@lang('admincms-navigation::parsers.image.fields.target_blank')</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('admincms-navigation::parsers.image.fields.title')</label>
                                    <input type="text" name="{{ $key }}[title]" class="form-control" value="{{ $values['title'] }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admincms::global.close')</button>
            </div>
        </div>
    </div>
</div>

<script>
    function changepreview{{ $key }}() {
        var gFileReader = new FileReader();
        gFileReader.readAsDataURL(document.getElementById("upload_{{ $key }}}").files[0]);

        gFileReader.onload = function(gFileReaderEvent) {
            document.getElementById("preview_image_{{ $key }}}").src = gFileReaderEvent.target.result;
            document.getElementById("{{ $key }}}").src = gFileReaderEvent.target.result;
        }
    }
</script>