@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'breakingnews' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-heading">
                    الاخبار العاجلة - {{ count( $breakingnews )  }}
                    <a href="{{ route('breakingnews.create') }}" class="btn btn-info btn-xs pull-left">إضافة</a>
                </div>
                @if ( count( $breakingnews ) == 0 )
                    <div class="panel-body">
                        <div class="alert alert-info" style="margin: 0;">
                            <p>لا يوجد اي اخبار حتى الان.</p>
                        </div>
                    </div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الخبر</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $breakingnews as $breakingnew )
                                <tr>
                                    <td>{{ $breakingnew->title }}</td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('breakingnews.edit', $breakingnew->id) }}">تعديل</a>
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
