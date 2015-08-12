<div class="modal fade" id="{{ $modal_type }}_modal_{{ $key }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="@lang('exposia::global.close')">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('exposia-navigation::parsers.' . $modal_type . '.title')</h4>
            </div>
            <div class="modal-body">