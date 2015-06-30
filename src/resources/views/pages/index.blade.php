@extends('exposia::index')

@section('title')
 @lang('exposia-navigation::pages.index.title') <a href="{{ route('admin.pages.create') }}" class="btn btn-default pull-right"><i class="fa fa-plus"></i> @lang('exposia::global.create')</a>
@stop

@section('content')
    <section class="content paddingleft_right15">
        <table class="table-striped table">
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
@stop
@section('modal')
@parent
@stop
@section('script')
    <script>
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