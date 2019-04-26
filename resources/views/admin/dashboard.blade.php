@extends('admin.layouts.app')

@section('content')
<div class="dashboard">
    <div class="container">
        <div class="row">
            @php ( $page = 'dashboard' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                @include('admin.layouts.message')
                <div class="row dashboard-links">
                    @if ( auth()->guard('admin')->user()->id == 1 )
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-tags"></i>
                                    الاقسام
                                </div>
                                <div class="panel-body">
                                    <h1 class="text-center" style="margin: 0;">{{ $categories->count() }}</h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-newspaper-o"></i>
                                    الاخبار
                                </div>
                                <div class="panel-body">
                                    <h1 class="text-center" style="margin: 0;">{{ $news->count() }}</h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-files-o"></i>
                                    المقالات
                                </div>
                                <div class="panel-body">
                                    <h1 class="text-center" style="margin: 0;">{{ $essays->count() }}</h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-photo"></i>
                                    البنرات
                                </div>
                                <div class="panel-body">
                                    <h1 class="text-center" style="margin: 0;">{{ $banners->count() }}</h1>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-newspaper-o"></i>
                                    اخباري
                                </div>
                                <div class="panel-body">
                                    <h1 class="text-center" style="margin: 0;">{{ $news->count() }}</h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-files-o"></i>
                                    مقالاتي
                                </div>
                                <div class="panel-body">
                                    <h1 class="text-center" style="margin: 0;">{{ $essays->count() }}</h1>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
