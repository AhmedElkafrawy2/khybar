@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'news' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-heading">
                    الاخبار - {{ count( $news )  }}
                    <a href="{{ route('news.create') }}" class="btn btn-info btn-xs pull-left">إضافة</a>
                </div>
                @if ( count( $news ) == 0 )
                    <div class="panel-body">
                        <div class="alert alert-info" style="margin-bottom: 0px;">
                            <p>لا يوجد اي اخبار حتى الان.</p>
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
                            @foreach ( $news as $new )
                                <tr>
                                    <td>{{ $new->title }}</td>
                                    <td>{{ $new->category_id ? $new->category()->first()->name : 'بلا تصنيف' }}</td>
                                    <td>{{ $new->writer_id == 1 ? 'الادارة' : $new->writer()->first()->name }}</td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('news.edit', $new->id) }}">تعديل</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection
