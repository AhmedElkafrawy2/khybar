@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'contactuses' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if ( $show == 'unread' )
                        الرسائل غير المقروءة - {{ count( $contactuses )  }}
                        <a href="{{ route('contactuses.all') }}" class="btn btn-default btn-xs pull-left">الكل</a>
                    @else
                        الكل - {{ count( $contactuses )  }}
                        <a href="{{ route('contactuses') }}" class="btn btn-default btn-xs pull-left">غير المقروءة</a>
                    @endif
                </div>
                @if ( count( $contactuses ) == 0 )
                    <div class="panel-body">
                        <div class="alert alert-info" style="margin-bottom: 0px;">
                            <p>لا يوجد اي رسائل غير مقروءة حتى الان.</p>
                        </div>
                    </div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>البريد</th>
                                <th>رقم الجوال</th>
                                @if ( $show == 'unread' )
                                    <th>عرض/مقروء/حذف</th>
                                @else
                                    <th>عرض/حذف</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $contactuses as $contactus )
                                <tr>
                                    <td>
                                        {{ $contactus->name }}
                                    </td>
                                    <td>
                                        {{ $contactus->email }}
                                    </td>
                                    <td>
                                        {{ $contactus->phone }}
                                    </td>
                                    @if ( $show == 'unread' )
                                        <td>
                                            <a class="btn btn-info btn-xs" href="{{ route('contactuses.show', $contactus->id) }}">عرض</a>
                                            <a class="btn btn-success btn-xs" href="{{ route('contactuses.review', $contactus->id) }}">مقروء</a>
                                            <a class="btn btn-danger btn-xs" href="{{ route('contactuses.destroy', $contactus->id) }}">حذف</a>
                                        </td>
                                    @else
                                        <td>
                                            <a class="btn btn-info btn-xs" href="{{ route('contactuses.show', $contactus->id) }}">عرض</a>
                                            <a class="btn btn-danger btn-xs" href="{{ route('contactuses.destroy', $contactus->id) }}">حذف</a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $contactuses->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
