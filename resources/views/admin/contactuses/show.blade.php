@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'contactuses' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        عرض رسالة
                        <a class="btn btn-danger btn-xs pull-left" href="{{ route('contactuses.destroy', $contactus->id) }}">حذف</a>
                    </div>

                    <div class="panel-body">
                        <p style="margin: 0;">{{ $contactus->content }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p style="margin: 0;">{{ $contactus->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p style="margin: 0;">{{ $contactus->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p style="margin: 0;">{{ $contactus->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
