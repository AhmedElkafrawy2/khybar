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
                    اختيارات الاستفتاء
                    <a href="{{ route('referendum.choices.create') }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;">اضافة</a>
                    <a href="{{ route('referendum') }}" class="btn btn-xs btn-warning pull-left" style="margin-right: 3px;">الاستفتاء</a>
                </div>
            </div>

            @if ( count( $choices ) )
                @foreach ( $choices as $choice )
                    <div class="col-md-6 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                {{ $choice->answer }}
                                <a href="{{ route('referendum.choices.destroy', $choice->id) }}" class="btn btn-xs btn-danger pull-left">حذف</a>
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
