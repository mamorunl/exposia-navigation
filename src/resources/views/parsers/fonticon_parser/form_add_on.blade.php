@include('exposia-navigation::parsers.partials.modal_start', ['modal_type' => 'fonticon', 'key' => $key])
<div class="form-group">
    <label for="{{ $key }}">@lang('exposia-navigation::parsers.fonticon.fields.value')</label>
    <select class="selectpicker form-control" name="{{ $key }}[value]" id="{{ $key }}">
        @foreach($icons as $name => $hex)
            <option value="fa {{ $name }}" @if($values['value'] == "fa " . $name)selected
                    @endif data-icon="fa {{ $name }}"> {{ $name }}</option>
        @endforeach
    </select>
</div>
@include('exposia-navigation::parsers.partials.modal_stop')

@include('exposia-navigation::parsers.partials.script', ['modal_type' => 'fonticon', 'key' => $key])

<script>
    $('#{{ $key }}').selectpicker();
</script>