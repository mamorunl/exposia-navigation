$(document).ready(function () {

    $('#canvas').rapidgrid({
        controlButtons: [[12], [8, 4], [9, 3], [5, 2, 5], [6, 6], [4, 4, 4], [3, 3, 3, 3], [2, 2, 2, 2, 2, 2]]
    });



    $('button[type=submit]').click(function (e) {
        e.preventDefault();
        var arr = travelTroughArray($('#canvas > .canvas > .rg-row'), false);
        $('#serialized_template').val(JSON.stringify(arr));
        //console.log($('#serialized_template').val());
        $('form').submit();
    });

    function travelTroughArray(start, skipsubs) {
        var arr = [];
        start.each(function (i) { // .row
            var subarr = [];
            subarr[0] = $(this).children('.rg-row-controls').find('.class-row-input').val();
            subarr[1] = [];
            $(this).children('.row-same-height').children('.rg-col').each(function () { // .col-*
                var class_length = $(this).attr('class').replace("rg-col", "").replace("col-full-height", "").replace("col-xs-height", "").replace("ui-sortable-handle", "").replace("ui-sortable", "");
                var node = [];
                node[0] = class_length + $(this).children('.rg-col-controls').find('.class-col-input').val();
                node[1] = $(this).find('.xpo_data').children('xpodata').data('templatename');
                node[2] = [];
                node[3] = travelTroughArray($(this).find('.subcanvas').children('.rg-row'), true);
                $(this).find('.xpo_data input' + (skipsubs == false ? ':not(.subcanvas input)' : '')).each(function () { // input
                    var $name = $(this).attr('name');
                    if ($name.indexOf("[") > -1) {
                        $name = $name.split("[");
                        $name = $name[0];
                    }
                    if ($.inArray($name, node[2]) == -1) {
                        node[2].push($name);
                    }
                });
                subarr[1].push(node);
            });
            arr.push(subarr);
        });

        return arr;
    }
});

