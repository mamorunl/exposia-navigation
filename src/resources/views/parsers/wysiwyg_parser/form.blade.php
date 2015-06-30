<input type="hidden" value="{{ $xpo_id }}" name="{{ $key }}[xpo_id]">
<textarea name="{{ $key }}[content]" class="form-control wysiwyg" rows="{{ $rows }}" id="{{ $key }}">
    {{ $values['content'] }}
</textarea>

<script>
    tinymce.init({
        selector: "#{{ $key }}",
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
            {title: 'Knop (primary)', value: 'btn btn-primary'},
            {title: 'Knop (warning)', value: 'btn btn-warning'},
            {title: 'Knop (info)', value: 'btn btn-info'},
            {title: 'Knop (danger)', value: 'btn btn-danger'},
            {title: 'Knop (success)', value: 'btn btn-success'}
        ]
    });
</script>