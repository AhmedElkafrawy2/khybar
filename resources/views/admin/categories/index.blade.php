@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'categories' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-heading">
                    الاقسام - {{ count( $categories )  }}
                    <a href="{{ route('categories.create') }}" class="btn btn-info btn-xs pull-left">إضافة</a>
                </div>
                @if ( count( $categories ) == 0 )
                    <div class="panel-body">
                        <div class="alert alert-info" style="margin-bottom: 0px;">
                            <p>لا يوجد اي اقسام حتى الان.</p>
                        </div>
                    </div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>القسم</th>
                                <th>الرابط</th>
                                <th>تعديل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $categories as $category )
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('categories.edit', $category->id) }}">تعديل</a>
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
