@extends('exposia::index')

@section('title')
 @lang('exposia-navigation::pages.index.title') <a href="{{ route('admin.pages.create') }}" class="btn btn-default pull-right"><i class="fa fa-plus"></i> @lang('exposia::global.create')</a>
@stop

@section('content')
    <section class="content paddingleft_right15">
        <table class="table-striped table">
            <thead>
            <tr>
                <th class="col-xs-4">@lang('exposia-navigation::pages.fields.title')</th>
                <th class="col-xs-4">@lang('exposia-navigation::pages.fields.slug')</th>
                <th class="col-xs-2">Laatste wijziging</th>
                <th class="col-xs-2">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->node->slug }}</td>
                    <td>{{ $page->updated_at->format("d F Y @ H:i") }}</td>
                    <td>
                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> @lang('exposia::global.edit')</a>
                        <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> @lang('exposia::global.destroy')</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@stop