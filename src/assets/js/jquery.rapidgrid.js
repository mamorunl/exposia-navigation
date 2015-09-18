/**
 * Created by heppi_000 on 24-7-2015.
 */

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

        // Extra variables for internal use
        rg.xpodataForBtn = null;
        rg.currentCanvas = null;

        rg.init = function () {
            rg.$el.append(rg.createFirstRow());

            rg.initializeCanvas();
        };

        rg.initializeCanvas = function () {
            $('.canvas .rg-col').each(function () {
                $settingsGroupHtml = rg.createSettingsButton();
                $(this).prepend($settingsGroupHtml);
            });

            rg.$el.sortable({
                items: ".row:not(.rg-select-row)",
                axis: 'y',
                handle: ".rg-move-row",
                forcePlaceholderSize: true,
                opacity: 0.7,
                revert: true,
                tolerance: "pointer",
                cursor: "move"
            });

            rg.$el.find('.row:not(.rg-select-row)').sortable({
                items: '.rg-col',
                axis: 'x',
                handle: ".rg-move-col",
                forcePlaceholderSize: true,
                opacity: 0.7,  revert: true,
                tolerance: "pointer",
                cursor: "move"
            });
        };

        rg.createFirstRow = function () {
            return '<div class="row rg-select-row" style="border: 1px dotted #ccc;">' +
                '<div class="col-md-12 text-center">' +
                '<div class="p7">' +
                '<button type="button" class="btn btn-primary btn-select-layout" title="Add new row"><i class="fa fa-plus"></i></button>' +
                '</div>' +
                '</div>' +
                '</div>';
        };

        rg.createRow = function ($innerHTML) {
            return '<div class="row" data-custom-class="" data-has-container="0">' +
                $innerHTML +
                '</div>';
        };

        rg.createCol = function ($col_size, $innerHTML) {
            return '<div class="col-md-' + $col_size + ' rg-col">' +
                rg.createSettingsButton() +
                '<div class="text-center p7" data-custom-class="">' +
                $innerHTML +
                '</div>' +
                ($col_size != 12 ? rg.createCanvas() : "") +
                '</div>';
        };

        rg.createCanvas = function () {
            return '<div class="canvas">' + rg.createFirstRow() + '</div>';

        };

        rg.createSettingsButton = function () {
            return '<div class="btn-group btn-group-settings" role="group">' +
                '<a href="#" class="btn btn-primary rg-move-row"><i class="fa fa-arrows-v"></i> Move row</a>' +
                '<a href="#" class="btn btn-primary rg-move-col"><i class="fa fa-arrows-h"></i> Move column</a>' +
                '<a href="#" class="btn btn-primary btn-launch-settings"><i class="fa fa-cog"></i> Settings</a>' +
                '</div>';
        };

        $('body')
            .on('click', '.btn-select-layout', function (e) {
                e.preventDefault();
                var $button = $(this);
                var $modal = '<div class="modal fade" id="generated_modal" tabindex="-1" role="dialog"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<h4 class="modal-title">Pick your row layout</h4></div><div class="modal-body">';
                for (var buttonArray in rg.options.controlButtons) {
                    $modal += '<div class="row" style="margin-bottom: 7px;"><a href="#" class="rg-add-this-row" data-key="' + buttonArray + '">';
                    rg.options.controlButtons[buttonArray].forEach(function (size) {
                        $modal += '<div class="col-xs-' + size + '"><div class="bg-primary text-center">' + size + '</div></div>';
                    });
                    $modal += '</a></div>';
                }
                $modal += '</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>';
                $('body').append($modal);
                $('#generated_modal').modal();
                rg.currentCanvas = $button.closest('.canvas');
            })
            .on('click', '.rg-add-this-row', function (e) {
                e.preventDefault();
                var $id = $(this).data('key');
                $('#generated_modal').modal('hide');
                var $style = "";
                rg.options.controlButtons[$id].forEach(function (element) {
                    $style += rg.createCol(element, '<a href="#" class="rg-pick-col-template btn btn-primary"><i class="fa fa-crosshairs"></i></a>');
                });
                $style = rg.createRow($style);
                rg.currentCanvas.children('.rg-select-row').before($style);
            })
            .on('click', '.rg-pick-col-template', function (e) {
                e.preventDefault();
                $btn = $(this);
                $('#set-template-modal').modal('show');
            })
            .on('click', '#template_picker a', function (e) {
                e.preventDefault();
                $('#set-template-modal').modal('hide');
                $btn.parent().removeClass('text-center');
                $btn.parent().addClass('xpo_data');
                $btn.children('i').attr('class', 'fa fa-spinner fa-spin');
                var template_name = $(this).data('templatename');

                $.get("/ajax/gettemplate/" + template_name, function (data) {
                    $btn.parent().append('<xpodata data-templatename="' + template_name + '"></xpodata>');
                    $btn.replaceWith(data);
                });
            })
            .on('click', '.btn-launch-settings', function (e) {
                e.preventDefault();
                rg.xpodataForBtn = $(this).parents('.btn-group-settings').siblings('.xpo_data');
                var $xpodataForBtn = rg.xpodataForBtn;
                $('#custom_class_col').val($xpodataForBtn.data('custom-class'));
                $('#custom_class_row').val($xpodataForBtn.closest('.row').data('custom-class'));
                $('#has_container').val($xpodataForBtn.closest('.row').data('has-container'));
                $('#settings-modal').modal('show');
            });

        /*
         * Modal events
         */
        $('#settings-modal').on('hidden.bs.modal', function (e) {
            var $xpodataForBtn = rg.xpodataForBtn;
            $xpodataForBtn.data('custom-class', $('#custom_class_col').val());
            $xpodataForBtn.closest('.row').data('custom-class', $('#custom_class_row').val());
            $xpodataForBtn.closest('.row').data('has-container', $('#has_container').val());
        });

        $('#generated_modal').on('hidden.bs.modal', function (e) {
            $(this).remove();
        });

        /**
         * Init function to load the plugin
         */
        rg.init();
    };

    /**
     * Default options
     *
     */
    $.rapidgrid.defaultOptions = {
        controlButtons: [[12], [8, 4], [9, 3], [5, 2, 5], [5, 7], [6, 6], [4, 4, 4], [3, 3, 3, 3], [2, 2, 2, 2, 2, 2]],

        // Desktop class
        colDesktopClass: "col-md-"
    };

    $.fn.rapidgrid = function (options) {
        var element = $(this);
        var rapidgrid = new $.rapidgrid(this, options);
        element.data('rapidgrid', rapidgrid);
        return this;
    }
}(jQuery));