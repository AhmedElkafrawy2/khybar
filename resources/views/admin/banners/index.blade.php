@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'banners' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-body">
                    البنرات - {{ count( $banners )  }}
                    <a href="{{ route('banners.create') }}" class="btn btn-info btn-xs pull-left">إضافة</a>
                </div>
            </div>
            <hr>
            @if ( count( $banners ) == 0 )
                <div class="alert alert-info">
                    <p>لا يوجد اي بنرات حتى الان.</p>
                </div>
            @else
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                بنرات العمود الايمن
                            </div>
                        </div>
                    </div>
                    @php ( $right = 0 )
                    @foreach ( $banners as $banner )
                        @if ( $banner->position == 1 )
                            <div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <img src="{{ asset($path.'banners/'.$banner->image()->first()->filename) }}" alt="{{ $banner->image()->first()->filename }}">
                                    <div class="caption" style="padding: 3px 0 0 0;">
                                        <p>
                                            <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-default btn-xs" role="button">تعديل</a>
                                            <a href="{{ route('banners.destroy', $banner->id) }}" class="btn btn-danger btn-xs pull-left" role="button">حذف</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @php ( $right++ )
                        @endif
                    @endforeach
                    @if ( $right > 3 )
                        <div class="col-sm-12">
                            <div class="alert alert-warning">
                                <p><strong>ملاحظة: </strong>عند اضافة اكثر من 3 بنرات في العمود الايمن وايقاف وضع العشوائي ، تظهر اخر 3 بنرات فقط.</p>
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                بنرات العمود الايسر
                            </div>
                        </div>
                    </div>
                    @php ( $left = 0 )
                    @foreach ( $banners as $banner )
                        @if ( $banner->position == 2 )
                            <div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <img src="{{ asset($path.'banners/'.$banner->image()->first()->filename) }}" alt="{{ $banner->image()->first()->filename }}">
                                    <div class="caption" style="padding: 3px 0 0 0;">
                                        <p>
                                            <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-default btn-xs" role="button">تعديل</a>
                                            <a href="{{ route('banners.destroy', $banner->id) }}" class="btn btn-danger btn-xs pull-left" role="button">حذف</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @php ( $left++ )
                        @endif
                    @endforeach
                    @if ( $left > 2 )
                        <div class="col-sm-12">
                            <div class="alert alert-warning">
                                <p><strong>ملاحظة: </strong>عند اضافة اكثر من بنرين في العمود الايسر وايقاف وضع العشوائي ، يظهر اخر بنرين فقط.</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
