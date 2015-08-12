@include('exposia-navigation::parsers.partials.modal_start', ['modal_type' => 'string', 'key' => $key])
<div class="form-group">
    <label for="string_input_{{ $key }}">@lang('exposia-navigation::parsers.string.fields.content')</label>
    <input type="text" name="{{ $key }}[value]" class="form-control" value="{{ $values['value'] }}" id="string_input_{{ $key }}">
</div>
@include('exposia-navigation::parsers.partials.modal_stop')
@include('exposia-navigation::parsers.partials.script', ['modal_type' => 'string', 'key' => $key])