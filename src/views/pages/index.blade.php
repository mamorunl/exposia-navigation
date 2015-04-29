@extends('admincms::index')

@section('title')
 Pagina's
@stop

@section('content')
    <section class="content paddingleft_right15">
        <table class="table-striped table">
            <thead>
            <tr>
                <th>Titel</th>
                <th>Slug</th>
                <th>Laatste wijziging</th>
                <th>&nbsp;</th>
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
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@stop