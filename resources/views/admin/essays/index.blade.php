@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'essays' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-heading">
                    المقالات - {{ count( $essays )  }}
                    <a href="{{ route('essays.create') }}" class="btn btn-info btn-xs pull-left">إضافة</a>
                </div>
                @if ( count( $essays ) == 0 )
                    <div class="panel-body">
                        <div class="alert alert-info" style="margin-bottom: 0px;">
                            <p>لا يوجد اي مقالات حتى الان.</p>
                        </div>
                    </div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>القسم</th>
                                <th>الكاتب</th>
                                <th>تعديل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $essays as $essay )
                                <tr>
                                    <td>{{ $essay->title }}</td>
                                    <td>{{ $essay->category_id ? $essay->category()->first()->name : 'بلا تصنيف' }}</td>
                                    <td>{{ $essay->writer_id  == 1 ? 'الادارة' : $essay->writer()->first()->name }}</td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('essays.edit', $essay->id) }}">تعديل</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{ $essays->links() }}
        </div>
    </div>
</div>
@endsection
