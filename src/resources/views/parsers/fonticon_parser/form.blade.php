<input type="hidden" value="{{ $xpo_id }}" name="{{ $key }}[xpo_id]">
<select class="selectpicker" name="{{ $key }}[value]" id="{{ $key }}">
    @foreach($icons as $name => $hex)
        <option value="fa {{ $name }}" @if($values['value'] == "fa " . $name)selected @endif data-icon="fa {{ $name }}"> {{ $name }}</option>
    @endforeach
</select>

<script>
    $('#{{ $key }}').selectpicker();
</script>