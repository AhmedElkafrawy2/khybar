@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'headermenus' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-heading">
                    قائمة الرأس - {{ count( $headermenus )  }}
                    <a href="{{ route('headermenus.create') }}" class="btn btn-info btn-xs pull-left">إضافة</a>
                </div>
                @if ( count( $headermenus ) == 0 )
                    <div class="panel-body">
                        <div class="alert alert-info" style="margin-bottom: 0px;">
                            <p>لا يوجد اي عناصر حتى الان.</p>
                        </div>
                    </div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الترتيب</th>
                                <th>العنصر</th>
                                <th>قسم/صفحة</th>
                                <th>تعديل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $headermenus as $headermenu )
                                <tr>
                                    <td>{{ $headermenu->order }}</td>
                                    <td>{{ $headermenu->category_id ? $headermenu->category()->first()->name : $headermenu->page()->first()->title }}</td>
                                    <td>{{ $headermenu->category_id ? 'قسم' : 'صفحة' }}</td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('headermenus.edit', $headermenu->id) }}">تعديل</a>
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
