/**
 * Created by heppi_000 on 13-5-2015.
 */

(function ($) {

    /**
     * Main function
     * @param el
     * @param options
     */
    $.rapidgrid = function (el, options) {
        var rg = this;
        rg.$el = $(el);
        rg.options = options;

        rg.init = function () {
            rg.options = $.extend({}, $.rapidgrid.defaultOptions, options);
            rg.initCanvas();
        };

        rg.initCanvas = function () {
            rg.initControls();
            rg.$el.append("<div class='canvas-wrapper'></div>");
            //rg.$el.prepend('<div id="rg-addnew" class="btn-group clearfix" style="display: block;"><a title="Add Row -12" class="btn  btn-xs  btn-primary add-12"><span class="fa fa-plus-circle"></span> -12</a><a title="Add Row -8-4" class="btn  btn-xs  btn-primary add-8-4"><span class="fa fa-plus-circle"></span> -8-4</a><a title="Add Row -9-3" class="btn  btn-xs  btn-primary add-9-3"><span class="fa fa-plus-circle"></span> -9-3</a><a title="Add Row -5-2-5" class="btn  btn-xs  btn-primary add-5-2-5"><span class="fa fa-plus-circle"></span> -5-2-5</a><a title="Add Row -6-6" class="btn  btn-xs  btn-primary add-6-6"><span class="fa fa-plus-circle"></span> -6-6</a><a title="Add Row -4-4-4" class="btn  btn-xs  btn-primary add-4-4-4"><span class="fa fa-plus-circle"></span> -4-4-4</a><a title="Add Row -3-3-3-3" class="btn  btn-xs  btn-primary add-3-3-3-3"><span class="fa fa-plus-circle"></span> -3-3-3-3</a><a title="Add Row -2-2-2-2-2-2" class="btn  btn-xs  btn-primary add-2-2-2-2-2-2"><span class="fa fa-plus-circle"></span> -2-2-2-2-2-2</a></div>');
        };

        rg.initControls = function () {
            var buttons = [];
            // Dynamically generated row template buttons
            $.each(rg.options.controlButtons, function (i, val) {
                var _class = rg.generateButtonClass(val);
                buttons.push("<a title='Add Row " + _class + "' class='" + rg.options.controlButtonClass + " add" + _class + "' href='#'><span class='" + rg.options.controlButtonSpanClass + "'></span> " + _class + "</a>");
                rg.generateClickHandler(val);
            });

            rg.$el.prepend(
                $('<div/>',
                    {'class': rg.options.rgClearClass}
                ).prepend(
                    $('<div/>', {"class": rg.options.rowClass}).html(
                        $('<div/>', {"class": rg.options.colDesktopClass + rg.options.colMax}).addClass(rg.options.colAdditionalClass).html(
                            $('<div/>', {'id': 'rg-addnew'})
                                .addClass(rg.options.rgBtnGroup).html(
                                buttons.join("")
                            )
                        ).append(rg.options.controlAppend)
                    )
                )
            );
        };

        /**
         * Basically just turns [2,4,6] into 2-4-6
         * @method generateButtonClass
         * @param {array} arr - An array of widths
         * @return string
         */
        rg.generateButtonClass = function (arr) {
            var string = "";
            $.each(arr, function (i, val) {
                string = string + "-" + val;
            });
            return string;
        };

        /**
         * click handlers for dynamic row template buttons
         * @method generateClickHandler
         * @param {array} colWidths - array of column widths, i.e [2,3,2]
         * @returns null
         */
        rg.generateClickHandler = function (colWidths) {
            var string = "a.add" + rg.generateButtonClass(colWidths);
            //var canvas=rg.$el.find("#" + rg.options.canvasId);
            rg.$el.on("click", string, function (e) {
                var canvas = rg.$el.find('.canvas-wrapper');
                canvas.prepend(rg.createRow(colWidths));
                rg.reset();
                e.preventDefault();
            });
        };

        rg.createRow = function (widths) {
            var row = '<div class="row">';
            $.each(widths, function (i, value) {
                row += rg.createColumn(value);
            });

            return row + '</div>';
        };

        rg.createColumn = function(width) {
            return '<div class="col-md-' + width + '">BUTTON</div>';
        };

        rg.reset = function() {
           /* $('#canvas .canvas-wrapper .container, #canvas .canvas-wrapper div[class*=col-md-]').sortable({
                start: function(e, ui){
                    ui.placeholder.height(ui.item.height());
                },
                cancel: '.handle',
                axis: 'y'
            });*/

            $('#canvas .canvas-wrapper .row').sortable({
                start: function(e, ui){
                    ui.placeholder.height(ui.item.height());
                },
                axis: 'x'
            });
        };

        rg.init();
    };

    $.rapidgrid.defaultOptions = {
        controlButtons: [[12], [8, 4], [9, 3], [5, 2, 5], [6, 6], [4, 4, 4], [3, 3, 3, 3], [2, 2, 2, 2, 2, 2]],
        rgClearClass: "clearfix",
        rgBtnGroup: "btn-group",
        rgFloatLeft: "pull-left",
        // Default control button class
        controlButtonClass: "btn btn-xs btn-primary",

        // Default control button icon
        controlButtonSpanClass: "fa fa-plus-circle",

        // Row
        rowClass: "row",

        // Desktop class
        colDesktopClass: "col-md-",

        // Max cols
        colMax: 12
    };

    $.fn.rapidgrid = function (options) {
        var element = $(this);
        var rapidgrid = new $.rapidgrid(this, options);
        element.data('rapidgrid', rapidgrid);
        return this;
    }
}(jQuery));