<input type="hidden" value="{{ $xpo_id }}" name="{{ $key }}[xpo_id]">
<div id="wysiwyg_{{ $key }}" class="visual-editor-field" data-field="content" data-toggle="modal"
     data-target="#wysiwyg_modal_{{ $key }}">
    {!! $values['content'] !!}
</div>