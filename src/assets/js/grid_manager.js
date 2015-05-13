$(document).ready(function () {

    $('#canvas').rapidgrid({
        controlButtons: [[12], [8, 4], [9, 3], [5, 2, 5], [6, 6], [4, 4, 4], [3, 3, 3, 3], [2, 2, 2, 2, 2, 2]]
    });
    /*
    var gmEditholder;
    $("#mycanvas").gridmanager({
        debug: 0,
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
        colButtonsAppend: [{
            title: "Add canvas",
            element: "a",
            btnClass: "gm-addCanvas pull-right",
            iconClass: "fa fa-plus "
        },
            {
                title: "Reset",
                element: "a",
                btnClass: "gm-resetColData pull-right",
                iconClass: "fa fa-repeat "
            }
        ],
        controlAppend: ""
    });

    $('body').on('click', '.btn-select-template', function (e) {
        gmEditholder = $(this);
        $('#set-template-modal').modal();
    });

    $('#template_picker a').click(function (e) {
        e.preventDefault();
        var template_name = $(this).data('templatename');

        $.get("/ajax/gettemplate/" + template_name, function (data) {
            gmEditholder.parent().append('<xpodata data-templatename="' + template_name + '"></xpodata>');
            gmEditholder.replaceWith('<div class="xpo_data">' + data + '</div>');
            $('#set-template-modal').modal('hide');
        });
    });

    $('button[type=submit]').click(function (e) {
        e.preventDefault();
        var arr = travelTroughArray($('#gm-canvas > .row.gm-editing'), false);
        $('#serialized_template').val(JSON.stringify(arr));
        console.log($('#serialized_template').val());
        $('form').submit();
    });

    function travelTroughArray(start, skipsubs) {
        var arr = [];
        start.each(function (i) {
            var subarr = [];
            $(this).children('.gm-editing').each(function () {
                var class_length = $(this).attr('class').replace("gm-editing", "").replace("column", "").replace("ui-sortable", "");
                var node = [];
                node[0] = class_length;
                node[1] = $(this).find('xpodata').data('templatename');
                node[2] = [];
                node[3] = travelTroughArray($(this).find('.subcanvas').children('.row.gm-editing'), true);
                $(this).find('input' + (skipsubs == false ? ':not(.subcanvas input)' : '')).each(function () {
                    var $name = $(this).attr('name');
                    if ($name.indexOf("[") > -1) {
                        $name = $name.split("[");
                        $name = $name[0];
                    }
                    if ($.inArray($name, node[2]) == -1) {
                        node[2].push($name);
                    }
                });
                subarr.push(node);
            });
            arr.push(subarr);
        });

        return arr;
    }

    $('body').on('click', '.gm-resetColData', function (e) {
        e.preventDefault();
        $(this).parent().siblings('.xpo_data').replaceWith("<div class='xpo_data'><button type='button' class='btn btn-primary btn-block btn-select-template'>Select template</button></div>");
    });

    $('body').on('click', '.gm-addCanvas', function(e) {
        e.preventDefault();
        var t = (new Date).getTime();
        $(this).parent().before('<div id="inserted_canvas_wrap_' + t + '" class="canvas-wrapper"><div id="gm-addnew" class="btn-group pull-left" style="display: block;"><a title="Add Row -12" class="btn  btn-xs  btn-primary add-12"><span class="fa fa-plus-circle"></span> -12</a><a title="Add Row -8-4" class="btn  btn-xs  btn-primary add-8-4"><span class="fa fa-plus-circle"></span> -8-4</a><a title="Add Row -9-3" class="btn  btn-xs  btn-primary add-9-3"><span class="fa fa-plus-circle"></span> -9-3</a><a title="Add Row -5-2-5" class="btn  btn-xs  btn-primary add-5-2-5"><span class="fa fa-plus-circle"></span> -5-2-5</a><a title="Add Row -6-6" class="btn  btn-xs  btn-primary add-6-6"><span class="fa fa-plus-circle"></span> -6-6</a><a title="Add Row -4-4-4" class="btn  btn-xs  btn-primary add-4-4-4"><span class="fa fa-plus-circle"></span> -4-4-4</a><a title="Add Row -3-3-3-3" class="btn  btn-xs  btn-primary add-3-3-3-3"><span class="fa fa-plus-circle"></span> -3-3-3-3</a><a title="Add Row -2-2-2-2-2-2" class="btn  btn-xs  btn-primary add-2-2-2-2-2-2"><span class="fa fa-plus-circle"></span> -2-2-2-2-2-2</a></div><div id="cvs_' + t + '" class="canvas subcanvas"></div></div>');
    });

    $('.gm-addCanvas').each(function() {
        if($(this).closest('.gm-editing').find('.canvas-wrapper').length) {
            $(this).hide();
        }
    });*/
});

