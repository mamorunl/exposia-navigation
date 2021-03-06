/**
 * Created by heppi_000 on 24-7-2015.
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
        rg.options = $.extend($.rapidgrid.defaultOptions, options);

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

            $('.canvas').sortable({
                axis: 'y',
                cursor: "move",
                forcePlaceholderSize: true,
                handle: ".rg-move-row",
                items: "> .row:not(.rg-select-row)",
                opacity: 0.7,
                revert: true,
                tolerance: "pointer"
            });

            rg.$el.find('.row:not(.rg-select-row)').sortable({
                axis: 'x',
                cursor: "move",
                items: '> .rg-col',
                forcePlaceholderSize: true,
                handle: ".rg-move-col",
                opacity: 0.7,
                revert: true,
                tolerance: "pointer"
            });
        };

        rg.createFirstRow = function () {
            return '<div class="row rg-select-row">' +
                '<div class="col-md-12 text-center">' +
                '<a href="#" class="huge-button btn-select-layout" title="Add new row"><i class="material-icons">add</i></a>' +
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
                '<div class="text-center" data-custom-class="">' +
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
                '<a href="#" class="btn btn-default rg-move-row" data-toggle="tooltip" data-placement="top" title="Move Row"><i class="fa fa-arrows-v"></i></a>' +
                '<a href="#" class="btn btn-default rg-move-col" data-toggle="tooltip" data-placement="top" title="Move Column"><i class="fa fa-arrows-h"></i></a>' +
                '<a href="#" class="btn btn-danger btn-launch-settings" data-toggle="tooltip" data-placement="top" title="Settings"><i class="fa fa-cog"></i></a>' +
                '</div>';
        };

        rg.createSelectTemplateButton = function() {
            return '<a href="#" class="rg-pick-col-template huge-button"><i class="material-icons">extension</i></a>';
        };

        $('body')
            .on('click', '.btn-select-layout', function (e) {
                e.preventDefault();
                var $button = $(this);
                var $modal = '<div class="modal fade" id="generated_modal" tabindex="-1" role="dialog"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<h4 class="modal-title">' + rg.options.translations.row_layout + '</h4></div><div class="modal-body"><ul class="nav nav-tabs" role="tablist">';

                for (var buttonArray in rg.options.controlButtons) {
                    $modal += '<li role="presentation"><a href="#generated_modal_tab' + buttonArray + '" data-key="' + buttonArray + '" data-toggle="tab">' + rg.options.controlButtons[buttonArray].join('-') + '</a></li>';
                }

                $modal += '</ul><div class="tab-content">';

                for (var buttonArray in rg.options.controlButtons) {
                    $modal += '<div role="tabpanel" class="tab-pane" id="generated_modal_tab' + buttonArray + '"><div class="row">';

                    rg.options.controlButtons[buttonArray].forEach(function (size) {
                        $modal += '<div class="col-xs-' + size + '"><div class="example-block bg-primary">' + size + ' (' + Math.floor((size/12)*100) + '%)</div></div>';
                    });

                    $modal += '</div><a href="#" data-key="' + buttonArray + '" class="rg-add-this-row huge-button"><i class="material-icons">add</i><br>' + rg.options.translations.add + '</a></div>';
                }

                $modal += '</div></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' + rg.options.translations.close + '</button></div></div></div></div>';

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
                    $style += rg.createCol(element, rg.createSelectTemplateButton());
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
                $btn.children('i').addClass('fa-spin').text('toys');
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
            }).on('click', '.btn-delete-row', function(e) {
            e.preventDefault();
            $('#settings-modal').modal('hide');
            rg.xpodataForBtn.closest('.row').fadeOut(800, function() {
                $(this).remove();
            });
        }).on('click', '.btn-reset-col', function(e) {
            e.preventDefault();
            var template_button = rg.createSelectTemplateButton();
            rg.xpodataForBtn.removeClass('xpo_data').addClass('text-center').html(template_button);
            $('#settings-modal').modal('hide');
        }).on('hidden.bs.modal', '#generated_modal', function () {
            $(this).remove();
        });

        /*
         * Modal events
         */
        $('#settings-modal').on('hidden.bs.modal', function () {
            var $xpodataForBtn = rg.xpodataForBtn;
            $xpodataForBtn.data('custom-class', $('#custom_class_col').val());
            $xpodataForBtn.closest('.row').data('custom-class', $('#custom_class_row').val());
            $xpodataForBtn.closest('.row').data('has-container', $('#has_container').val());
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
        colDesktopClass: "col-md-",
        translations: {
            row_layout: 'Pick your row layout',
            close: 'Close',
            add: 'Add'
        }
    };

    $.fn.rapidgrid = function (options) {
        var element = $(this);
        var rapidgrid = new $.rapidgrid(this, options);
        element.data('rapidgrid', rapidgrid);
        return this;
    }
}(jQuery));