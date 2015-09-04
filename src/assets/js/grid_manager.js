$(document).ready(function () {

    $('#canvas').rapidgrid({
        controlButtons: [[12], [8, 4], [9, 3], [5, 2, 5], [6, 6], [4, 4, 4], [3, 3, 3, 3], [2, 2, 2, 2, 2, 2]]
    });



    $('button[type=submit]').click(function (e) {
        e.preventDefault();
        var arr = traverseTemplate($('#canvas'));
        $('#serialized_template').val(JSON.stringify(arr));
        $('form').submit();
    });

    function traverseTemplate(start) {
        var $rows = start.children('.row:not(.rg-select-row)');
        var rows = [];
        $rows.each(function() {
            rows.push(readRow($(this)));
        });
        return rows;
    }

    function readRow($row) {
        var row_data = [];
        row_data[0] = $row.data('has-container');
        row_data[1] = $row.data('custom-class');
        row_data[2] = [];
        $row.children('.rg-col').each(function() {
            var col_result = readCol($(this));
            row_data[2].push(col_result);
        });

        return row_data;
    }

    function readCol($col) {
        var col_data = [];
        col_data[0] = $col.attr('class').replace("rg-col", "").replace("ui-sortable-handle", "").replace("ui-sortable", "");
        col_data[1] = $col.children('.xpo_data').children('xpodata').data('templatename');
        col_data[2] = $col.children('.xpo_data').data('custom-class');
        col_data[3] = readInputs($col);
        col_data[4] = [];
        var col_children = [];
        var canvas = $col.children('.canvas');
        canvas.children('.row:not(.rg-select-row)').each(function() {
            col_children.push(readRow($(this)));
        });
        col_data[4].push(col_children);

        return col_data;
    }

    function readInputs($col) {
        var inputs = [];
        $col.find('.xpo_data input:not(.xpo_data .canvas input)').each(function() {
            var $name = $(this).attr('name');
            if ($name.indexOf("[") > -1) {
                $name = $name.split("[");
                $name = $name[0];
            }
            if ($.inArray($name, inputs) == -1) {
                inputs.push($name);
            }
        });

        return inputs;
    }
});

