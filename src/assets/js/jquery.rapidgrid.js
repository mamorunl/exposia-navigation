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

        /**
         *
         */
        rg.init = function () {
            rg.options = $.extend({}, $.rapidgrid.defaultOptions, options);
            rg.initCanvas();
            rg.reset();

            // Add the custom row classes to the input field
            rg.$el.find(".rg-row").each(function() {
                var $userclasses = $(this).data('userclasses');
                $(this).children('.rg-row-controls').find('.class-row-input').val($userclasses);
            });

            // Add the custom col classes to the input field
            rg.$el.find(".rg-col").each(function() {
                var $userclasses = $(this).data('userclasses');
                $(this).children('.rg-col-controls').find('.class-col-input').val($userclasses);
            });
        };

        /**
         *
         */
        rg.initCanvas = function () {
            rg.$el.prepend(rg.initControls(true));
            if(rg.$el.children('.canvas').length == 0) {
                rg.$el.append("<div class='canvas'></div>");
            }

            rg.$el.find(".xpo_data").each(function() {
                if($(this).siblings('.old_xpo_data').length == 0) {
                    $(this).after(rg.generateTemporaryXpoData());
                }
            });
        };

        /**
         *
         */
        rg.initControls = function (init) {
            var buttons = [];
            // Dynamically generated row template buttons
            $.each(rg.options.controlButtons, function (i, val) {
                var _class = rg.generateButtonClass(val);
                buttons.push("<a title='Add Row " + _class + "' class='" + rg.options.controlButtonClass + " add" + _class + "' href='#'><span class='" + rg.options.controlButtonSpanClass + "'></span> " + _class + "</a>");
                if(init === true) {
                    rg.generateClickHandler(val);
                }
            });

            return $('<div/>',
                    {'class': rg.options.rgClearClass}
                ).prepend(
                    $('<div/>', {"class": rg.options.rowClass}).html(
                        $('<div/>', {"class": rg.options.colDesktopClass + rg.options.colMax}).addClass(rg.options.colAdditionalClass).addClass("text-center").addClass("rg-btn-group-cols").html(
                            $('<div/>')
                                .addClass(rg.options.rgBtnGroup).html(
                                buttons.join("")
                            )
                        ).append(rg.options.controlAppend)
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
            rg.$el.on("click", string, function (e) {
                var canvas = $(this).closest('.canvas-wrapper').children('.canvas');
                canvas.prepend(rg.createRow(colWidths));
                rg.reset();
                e.preventDefault();
            });
        };

        /**
         *
         * @param widths
         * @returns {string}
         */
        rg.createRow = function (widths) {
            var row = '<div class="row rg-row"><div class="row-same-height row-full-height">';
            $.each(widths, function (i, value) {
                row += rg.createColumn(value);
            });

            return row + '</div></div>';
        };

        /**
         *
         * @param width
         * @returns {string}
         */
        rg.createColumn = function (width) {
            return '<div class="rg-col col-full-height col-xs-height col-md-' + width + '"><div class="xpo_data normal-state">' + rg.generateTemplateButton() + '</div>' + rg.generateTemporaryXpoData() + rg.generateSubCanvas() + '</div>';
        };

        /**
         * Generate the temporary placeholder for xpo_data
         * @returns {string}
         */
        rg.generateTemporaryXpoData = function() {
            return '<div class="old_xpo_data">' + rg.generateTemplateButton() + '</div>';
        };

        /**
         * Generate the 'select template' button
         * @returns {string}
         */
        rg.generateTemplateButton = function() {
            rg.$el.on('click', '.btn-select-template', function(e) {
                rg.editHolder = $(this);
                $('#set-template-modal').modal();
            });

            return '<button type="button" class="btn btn-primary btn-block btn-select-template">Select template</button>';
        };

        /**
         * Reset function to re-init various components
         */
        rg.reset = function () {
            $('#canvas .canvas, #canvas .canvas .rg-col').sortable({
                start: function (e, ui) {
                    ui.placeholder.height(ui.item.height());
                },
                items: '> .rg-row',
                handle: '.move-row',
                axis: 'y'
            });

            $('#canvas .canvas .rg-row').sortable({
                start: function (e, ui) {
                    ui.placeholder.height(ui.item.height());
                },
                items: '> .row-same-height .rg-col',
                handle: '.move-col',
                axis: 'x'
            });

            $('#canvas .rg-row').each(function() {
                $(this).children('.rg-row-controls').remove();
                $(this).prepend('<div class="rg-row-controls btn-group pull-right"><a href="#" class="move-row btn btn-default btn-xs"><i class="fa fa-arrows-v"></i></a><a href="#" class="remove-row btn btn-default btn-xs"><i class="fa fa-trash-o"></i></a><a href="#" class="class-row btn btn-default btn-xs"><i class="fa fa-code"></i></a> <input type="text" value="" class="class-row-input" style="display: none" /></div>');

                $(this).find('.rg-col').children('.rg-col-controls').remove();
                $(this).find('.rg-col').each(function() {
                    $(this).prepend('<div class="rg-col-controls btn-group pull-right"><a href="#" class="move-col btn btn-default btn-xs"><i class="fa fa-arrows-h"></i></a><a href="#" class="reset-col btn btn-default btn-xs"><i class="fa fa-refresh"></i></a><a href="#" class="class-col btn btn-default btn-xs"><i class="fa fa-code"></i></a> <input type="text" value="" class="class-col-input" style="display: none" /></div>');
                });
            });
        };

        /**
         * Generate a subcanvas for nested rows
         * @returns {string}
         */
        rg.generateSubCanvas = function() {
            var $controls = rg.initControls(false);
            return '<div class="canvas-wrapper">' + $controls.html() + '<div class="subcanvas canvas"></div></div>';
        };

        /**
         * Insert the template picked
         */
        $('#template_picker a').click(function (e) {
            e.preventDefault();
            var template_name = $(this).data('templatename');

            $.get("/ajax/gettemplate/" + template_name, function (data) {
                rg.editHolder.parent().append('<xpodata data-templatename="' + template_name + '"></xpodata>');
                rg.editHolder.replaceWith(data);
                $('#set-template-modal').modal('hide');
            });
        });

        /**
         * Set the custom classes for a column
         */
        rg.$el.on('click', '.class-col', function(e) {
            e.preventDefault();
            if($(this).siblings('.class-col-input').css('display') == 'none') {
                $(this).siblings('.class-col-input').show().focus();
            } else {
                $(this).siblings('.class-col-input').hide();
            }
        });

        /**
         * Set the custom classes for a row
         */
        rg.$el.on('click', '.class-row', function(e) {
            e.preventDefault();
            if($(this).siblings('.class-row-input').css('display') == 'none') {
                $(this).siblings('.class-row-input').show().focus();
            } else {
                $(this).siblings('.class-row-input').hide();
            }
        });

        /**
         * Delete a row from the view
         */
        rg.$el.on('click', '.remove-row', function(e) {
            e.preventDefault();
            $(this).closest('.rg-row').fadeOut(400, function() {
                $(this).remove();
            });
        });

        /**
         * Reset the column to the template selector
         */
        rg.$el.on('click', '.reset-col', function(e) {
            e.preventDefault();
            var $xpo_data = $(this).closest('.rg-col').children('.xpo_data');
            var $old_xpo_data = $xpo_data.siblings('.old_xpo_data');
            $xpo_data.removeClass('normal-state').addClass('rotated-state');
            $old_xpo_data.removeClass('rotated-state').addClass('normal-state');
            $xpo_data.removeClass('xpo_data').addClass('old_xpo_data');
            $old_xpo_data.removeClass('old_xpo_data').addClass('xpo_data');
        });

        rg.init();
    };

    /**
     * Default options
     *
     */
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