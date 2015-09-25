@include('exposia-navigation::parsers.partials.modal_start', ['modal_type' => 'wysiwyg', 'key' => $key])
<div class="form-group">
    <label for="wysiwyg_input_{{ $key }}">@lang('exposia-navigation::parsers.wysiwyg.fields.content')</label>
    <textarea name="{{ $key }}[content]" class="form-control wysiwyg" rows="{{ $rows }}"
              id="wysiwyg_input_{{ $key }}">{{ $values['content'] }}</textarea>
</div>
@include('exposia-navigation::parsers.partials.modal_stop')
<script>
    $('#wysiwyg_modal_{{ $key }}').on('hide.bs.modal', function (e) {
        $('div[data-target=#wysiwyg_modal_{{ $key }}]').html(
                tinymce.activeEditor.getContent()
        );
    });
    tinymce.init({
        selector: "#wysiwyg_input_{{ $key }}",
        plugins: [
            "autolink link table"
        ],
        content_css: "",
        toolbar: "styleselect | bullist numlist | link | table",

        relative_urls: false,
        menubar: false,
        statusbar: false,
        extended_valid_elements: "table[*]",
        invalid_elements: "span",
        valid_styles: {
            "*": "text-align",
            "a": "",
            "strong": ""
        },
        link_class_list: [
            {title: 'Geen', value: ''},
            @foreach(Config::get('theme.custom_classes') as $class => $description)
                {title: '{{ $description }}', value: '{{ $class }}'},
            @endforeach
        ]
    });
    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });
</script>