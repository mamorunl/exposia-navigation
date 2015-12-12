@include('exposia-navigation::parsers.partials.modal_start', ['modal_type' => 'wysiwyg', 'key' => $key])
<div class="form-group">
    <label for="wysiwyg_input_{{ $key }}">@lang('exposia-navigation::parsers.wysiwyg.fields.content')</label>
    <textarea name="{{ $key }}[content]" class="form-control wysiwyg" rows="{{ $rows }}"
              id="wysiwyg_input_{{ $key }}">{{ $values['content'] }}</textarea>
</div>
@include('exposia-navigation::parsers.partials.modal_stop')
@include('exposia::static.wysiwyg', ['selector' => '#wysiwyg_input_' . $key])
<script>
    load_tinymce();
    $('#wysiwyg_modal_{{ $key }}').on('hide.bs.modal', function (e) {
        $('div[data-target=#wysiwyg_modal_{{ $key }}]').html(
                tinymce.activeEditor.getContent()
        );
    });

    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });
</script>