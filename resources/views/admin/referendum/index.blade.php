@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'referendum' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-body">
                    الاستفتاء
                    <a href="{{ route('referendum.edit') }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;">تعديل</a>

                    <a href="{{ route('referendum.choices') }}" class="btn btn-xs btn-warning pull-left" style="margin-right: 3px;">الاختيارات</a>

                    <a href="{{ route('referendum.reset') }}" class="btn btn-xs btn-default pull-left" style="margin-right: 3px;">تصفير الاصوات</a>
                    @if ( $referendum->activated )
                        <a href="{{ route('referendum.deactivate') }}" class="btn btn-xs btn-danger pull-left">ايقاف</a>
                    @else
                        <a href="{{ route('referendum.activate') }}" class="btn btn-xs btn-success pull-left">تنشيط</a>
                    @endif
                </div>
            </div>

            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{ $referendum->title }}
                    </div>
                </div>
            </div>

            @if ( count( $referendum->answers()->get() ) )
                @foreach ( $referendum->answers()->get() as $choice )
                    <div class="col-md-6 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                {{ $choice->answer }}
                                <span class="pull-left">{{ $choice->votes()->count() }} صوت</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-sm-12">
                    <div class="alert alert-info">
                        <p>لا يوجد اي اختيارات حتى الان.</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="alert alert-warning">
                        <p><strong>ملاحظة: </strong>الاستفتاء بدون اختيارات لن يظهر.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
