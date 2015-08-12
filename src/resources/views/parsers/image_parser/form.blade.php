<input type="hidden" value="{{ $xpo_id }}" name="{{ $key }}[xpo_id]">
<input type="hidden" value="{{ $values['src'] }}" name="{{ $key }}[old_src]" />
<div style="overflow: hidden; display: block;">
    <a href="#modal_{{ $key }}" data-toggle="modal" data-target="#image_modal_{{ $key }}" style="display: block;{{ $attributes }}">
        <img src="{{ $values['src'] }}" alt="" id="{{ $key }}">
    </a>
</div>