$(document).ready(function () {
    var gmEditholder;
    $("#mycanvas").gridmanager({
        debug: 1,
        colSelectEnabled: false,
        editableRegionEnabled: false,
        autoEdit: false,
        addDefaultColumnClass: false,
        addResponsiveClasses: false,
        controlButtons: [[12], [8, 4], [9, 3], [5, 2, 5], [6, 6], [4, 4, 4], [3, 3, 3, 3], [2, 2, 2, 2, 2, 2]],

        rowButtonsPrepend: [{
            title: "Move",
            element: "a",
            btnClass: "gm-moveRow pull-left",
            iconClass: "fa fa-arrows "
        },
            {
                title: "Row Settings",
                element: "a",
                btnClass: "pull-right gm-rowSettings",
                iconClass: "fa fa-cog"
            }],

        colButtonsPrepend: [{
            title: "Move",
            element: "a",
            btnClass: "gm-moveCol pull-left",
            iconClass: "fa fa-arrows "
        }],
        colButtonsAppend: {}
    });

    $('body').on('click', '.btn-select-template', function (e) {
        gmEditholder = $(this).parent();
        $('#set-template-modal').modal();
    });

    $('#template_picker a').click(function (e) {
        e.preventDefault();

        $.get("/ajax/gettemplate/" + $(this).data('templateid'), function (data) {
            gmEditholder.html(data);
            $('#set-template-modal').modal('hide');
        });
    });

    $('button[type=submit]').click(function(e) {
        e.preventDefault();
        var arr = [];
        $('#gm-canvas > .row.gm-editing').each(function(i) {
            var subarr = [];
            $(this).children('.gm-editing').each(function() {
                var class_length = $(this).attr('class').replace("gm-editing", "").replace("column", "").replace("ui-sortable", "");
                var node = [];
                node[0] = class_length;
                node[1] = "double";
                node[2] = [];
                $(this).find('input').each(function() {
                    var $name = $(this).attr('name');
                    if($name.indexOf("[") > -1) {
                        $name = $name.split("[");
                        $name = $name[0];
                    }
                    if($.inArray($name, node[2]) == -1) {
                        node[2].push($name);
                    }
                });
                subarr.push(node);
            });
            arr.push(subarr);
        });
        $('#serialized_template').val(JSON.stringify(arr));
        $('form').submit();
    });
});

