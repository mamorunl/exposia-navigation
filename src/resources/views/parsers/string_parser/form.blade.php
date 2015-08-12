<input type="hidden" value="{{ $xpo_id }}" name="{{ $key }}[xpo_id]">

<div id="string_{{ $key }}" class="visual-editor-field" data-field="content" data-toggle="modal"
     data-target="#string_modal_{{ $key }}">
    {{ $values['value'] }}
</div>