@extends('admincms::index')

@section('title')
 Pagina's <a href="{{ route('admin.pages.create') }}" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Nieuwe pagina</a>
@stop

@section('content')
    <section class="content paddingleft_right15">
        <table class="table-striped table">
            <thead>
            <tr>
                <th class="col-xs-4">Titel</th>
                <th class="col-xs-4">Slug</th>
                <th class="col-xs-2">Laatste wijziging</th>
                <th class="col-xs-2">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>{{ $page->title }}</td>
                    <td></td>
                    <td>{{ $page->updated_at->format("d F Y @ H:i") }}</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                        <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Destroy</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@stop