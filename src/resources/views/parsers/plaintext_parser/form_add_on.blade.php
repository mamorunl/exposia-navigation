@include('exposia-navigation::parsers.partials.modal_start', ['modal_type' => 'plaintext', 'key' => $key])
    <div class="form-group">
        <label for="plaintext_input_{{ $key }}">@lang('exposia-navigation::parsers.plaintext.fields.content')</label>
        <textarea name="{{ $key }}[content]" class="form-control" rows="{{ $rows }}" id="plaintext_input_{{ $key }}">{{ $values['content'] }}</textarea>
    </div>
@include('exposia-navigation::parsers.partials.modal_stop')

@include('exposia-navigation::parsers.partials.script', ['modal_type' => 'plaintext', 'key' => $key])