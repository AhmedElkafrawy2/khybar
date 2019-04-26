@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'pages' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-heading">
                    الصفحات - {{ count( $pages )  }}
                    <a href="{{ route('pages.create') }}" class="btn btn-info btn-xs pull-left">إضافة</a>
                </div>
                @if ( count( $pages ) == 0 )
                    <div class="panel-body">
                        <div class="alert alert-info" style="margin-bottom: 0px;">
                            <p>لا يوجد اي صفحات حتى الان.</p>
                        </div>
                    </div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>تعديل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $pages as $page )
                                <tr>
                                    <td>{{ $page->title }}</td>
                                    <td>
                                        @if ( $page->id == 1 || $page->id == 2 )
                                            @if ( $page->content == 1 )
                                                <a class="btn btn-danger btn-xs" href="{{ route('pages.deactivate', $page->id) }}">ايقاف</a>
                                            @else
                                                <a class="btn btn-success btn-xs" href="{{ route('pages.activate', $page->id) }}">تنشيط</a>
                                            @endif
                                        @else
                                            <a class="btn btn-info btn-xs" href="{{ route('pages.edit', $page->id) }}">تعديل</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
