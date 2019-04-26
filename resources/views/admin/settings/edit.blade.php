@extends('admin.layouts.app')

@section('content')
<div class="dashboard">
    <div class="container">
        <div class="row">
            @php ( $page = 'settings' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-12">
                        @include('admin.layouts.message')
                    </div>

                    <form class="form-horizontal" method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    الاعدادات العامة
                                    <button type="submit" class="btn btn-default btn-xs pull-left">حفظ</button>
                                </div>
                            </div>
                            <div class="alert alert-warning">
                                <p><strong>ملاحظة: </strong>عند ترك الصورة فارغة لا يتم تغيير السابقة.</p>
                            </div>
                            <div class="alert alert-info">
                                <p><strong>ملاحظة: </strong>الكلمات المفتاحية والوصف يساعدان محركات البحث في العثور على موقعك ، احرص على ملأها بكلمات مناسبة.</p>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <label for="name"><small>اسم الموقع</small></label>
                                                <input placeholder="الاسم" id="name" type="text" class="form-control" name="name" value="{{ old('name', $settings->name) }}">
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group{{ $errors->has('meta_keywords') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <label for="meta_keywords"><small>الكلمات المفتاحية ، تفصل الكلمات بفاصلة انجليزية (,)</small></label>
                                                <input placeholder="الكلمات المفتاحية" id="meta_keywords" type="text" class="form-control" name="meta_keywords" value="{{ old('meta_keywords', $settings->meta_keywords) }}">
                                                @if ($errors->has('meta_keywords'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('meta_keywords') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group{{ $errors->has('meta_description') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <label for="meta_description"><small>الوصف</small></label>
                                                <textarea placeholder="الوصف" id="meta_description" name="meta_description" class="form-control" rows="1">{{ old('meta_description', $settings->meta_description) }}</textarea>
                                                @if ($errors->has('meta_description'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('meta_description') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="thumbnail">
                                            <img src="{{ asset($path.'settings/'.$settings->header()->first()->filename) }}" alt="{{ $settings->header()->first()->filename }}">
                                        </div>
                                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="image" type="file" class="form-control inputfile" name="image" value="{{ old('image') }}">
                                                <label for="image"><span>الصورة</span></label>
                                                @if ($errors->has('image'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('image') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <label for="sidebar_slider_category_id"><small>سلايدر العمود الايسر</small></label>
                                        <div class="form-group{{ $errors->has('sidebar_slider_category_id') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <select id="sidebar_slider_category_id" class="form-control" name="sidebar_slider_category_id">
                                                    <option value>اخفاء</option>
                                                    @foreach ( $categories as $category )
                                                        <option {{ old('sidebar_slider_category_id', $settings->sidebar_slider_category_id) == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('sidebar_slider_category_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('sidebar_slider_category_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    اعدادات العرض
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        روابط التواصل في الرأس
                                        @if ( $settings->social_in_header )
                                            <a href="{{ route('socialInHeader.deactivate') }}" class="btn btn-danger btn-xs pull-left">ايقاف</a>
                                        @else
                                            <a href="{{ route('socialInHeader.activate') }}" class="btn btn-success btn-xs pull-left">تنشيط</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        روابط التواصل في الذيل
                                        @if ( $settings->social_in_footer )
                                            <a href="{{ route('socialInFooter.deactivate') }}" class="btn btn-danger btn-xs pull-left">ايقاف</a>
                                        @else
                                            <a href="{{ route('socialInFooter.activate') }}" class="btn btn-success btn-xs pull-left">تنشيط</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        السلايدر
                                        @if ( $settings->slider )
                                            <a href="{{ route('slider.deactivate') }}" class="btn btn-danger btn-xs pull-left">ايقاف</a>
                                        @else
                                            <a href="{{ route('slider.activate') }}" class="btn btn-success btn-xs pull-left">تنشيط</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        بنرات عشوائية
                                        @if ( $settings->random_banners )
                                            <a href="{{ route('randomBanners.deactivate') }}" class="btn btn-danger btn-xs pull-left">ايقاف</a>
                                        @else
                                            <a href="{{ route('randomBanners.activate') }}" class="btn btn-success btn-xs pull-left">تنشيط</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
