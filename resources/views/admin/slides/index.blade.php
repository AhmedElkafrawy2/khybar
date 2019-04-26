@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'slides' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-body">
                    الشرائح - {{ count( $slides )  }}
                    <a href="{{ route('slides.create') }}" class="btn btn-info btn-xs pull-left">إضافة</a>
                </div>
            </div>
            <hr>
            @if ( count( $slides ) == 0 )
                <div class="alert alert-info">
                    <p>لا يوجد اي شرائح حتى الان.</p>
                </div>
            @else
                <div class="row">
                    @foreach ( $slides as $slide )
                        <div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                                <img src="{{ asset($path.'slides/'.$slide->image()->first()->filename) }}" alt="{{ $slide->image()->first()->filename }}">
                                <div class="caption">
                                    <h3>{{ $slide->title }}</h3>
                                    <p>{{ $slide->description }}</p>
                                    <p>
                                        <a href="{{ route('slides.edit', $slide->id) }}" class="btn btn-default btn-block" role="button">تعديل</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
