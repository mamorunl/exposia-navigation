@extends('exposia::index')

@section('title')
 @lang('exposia-navigation::pages.index.title')
@stop

@section('content')
    @if(count($pages) > 25)
        <a href="{{ route('admin.pages.create') }}" class="huge-button" title="@lang('exposia::global.create')"><i class="material-icons">add</i></a>
    @endif
    <section class="content paddingleft_right15">
        <table class="table-striped table" id="pages-table">
            <thead>
            <tr>
                <th class="col-xs-5">@lang('exposia-navigation::pages.fields.title')</th>
                <th class="col-xs-5">@lang('exposia-navigation::pages.fields.slug')</th>
                <th class="col-xs-2">@lang('exposia-navigation::pages.index.last_edit')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td><p>{{ $page->title }}</p>
                        <small>
                            @if(Config::has('website.languages') && count(Config::get('website.languages')) > 1)

                                @foreach(Config::get('website.languages') as $abbr => $lang)
                                    @if($abbr != Config::get('app.locale'))
                                        <a href="{{ route('admin.translations.edit', [$page->id, $abbr]) }}" class="btn btn-xs btn-default" title="@lang('exposia-navigation::pages.index.edit_language')"><i class="fa fa-language"></i> {{ $lang['name'] }}</a>
                                    @endif
                                @endforeach
                            @endif
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> @lang('exposia::global.edit')</a>
                            <a href="#" class="btn btn-danger btn-xs btn-confirm-delete"><i class="fa fa-trash-o"></i> @lang('exposia::global.destroy')</a>
                            {!! Form::open(['method' => 'delete', 'route' => ['admin.pages.destroy', $page->id]]) !!}
                            {!! Form::close() !!}
                        </small>
                    </td>
                    <td>{{ $page->node->slug }}</td>
                    <td>{{ $page->updated_at->format("d F Y @ H:i") }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>

    <a href="{{ route('admin.pages.create') }}" class="huge-button" title="@lang('exposia::global.create')"><i class="material-icons">add</i></a>
@stop
@section('modal')
@parent
@stop

@section('style')
    <link href="/backend/assets/js/bootstrap-datatables/datatables.min.css" rel="stylesheet">
@stop

@section('script')
    <script src="/backend/assets/js/bootstrap-datatables/datatables.min.js"></script>
    <script>
        $(function() {
            $('#pages-table').DataTable({
                pageLength: 25,
                language: {
                    "sProcessing": "{{ trans('exposia-navigation::pages.index.datatables.sProcessing') }}",
                    "sLengthMenu": "{{ trans('exposia-navigation::pages.index.datatables.sLengthMenu') }}",
                    "sZeroRecords": "{{ trans('exposia-navigation::pages.index.datatables.sZeroRecords') }}",
                    "sInfo": "{{ trans('exposia-navigation::pages.index.datatables.sInfo') }}",
                    "sInfoEmpty": "{{ trans('exposia-navigation::pages.index.datatables.sInfoEmpty') }}",
                    "sInfoFiltered": "{{ trans('exposia-navigation::pages.index.datatables.sInfoFiltered') }}",
                    "sInfoPostFix": "{{ trans('exposia-navigation::pages.index.datatables.sInfoPostFix') }}",
                    "sSearch": "{{ trans('exposia-navigation::pages.index.datatables.sSearch') }}",
                    "sEmptyTable": "{{ trans('exposia-navigation::pages.index.datatables.sEmptyTable') }}",
                    "sInfoThousands": "{{ trans('exposia-navigation::pages.index.datatables.sInfoThousands') }}",
                    "sLoadingRecords": "{{ trans('exposia-navigation::pages.index.datatables.sLoadingRecords') }}",
                    "oPaginate": {
                        "sFirst": "{{ trans('exposia-navigation::pages.index.datatables.oPaginate.sFirst') }}",
                        "sLast": "{{ trans('exposia-navigation::pages.index.datatables.oPaginate.sLast') }}",
                        "sNext": "{{ trans('exposia-navigation::pages.index.datatables.oPaginate.sNext') }}",
                        "sPrevious": "{{ trans('exposia-navigation::pages.index.datatables.oPaginate.sPrevious') }}"
                    }
                }
            });
        });
        $('.btn-confirm-delete').click(function(e) {
            e.preventDefault();
            var $link = $(this);
            bootbox.confirm({
                message: "Weet u zeker dat u deze pagina wilt verwijderen?",
                callback: function(result) {
                    if(result) {
                        $link.siblings('form').submit();
                    }
                }
            });
        });
    </script>
@stop