@php ( $quill = '' )
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'headermenus' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        تعديل عنصر في قائمة الرأس
                        <a href="{{ route('headermenus.destroy', $headermenu->id) }}" class="btn btn-danger btn-xs pull-left">حذف</a>
                    </div>

                    <div class="panel-body">

                        <form class="form-horizontal" method="POST" action="{{ route('headermenus.update', $headermenu->id) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('for') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <select id="for" class="form-control" name="for">
                                        <option {{ old('for', $headermenu->category_id) ? 'selected' : '' }} value="category">قسم</option>
                                        <option {{ old('for', $headermenu->page_id) ? 'selected' : '' }} value="page">صفحة</option>
                                    </select>
                                    @if ($errors->has('for'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('for') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div id="category-group" class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <select id="category_id" class="form-control" name="category_id">
                                        <option value>القسم</option>
                                        @foreach ( $categories as $category )
                                            <option {{ old('category_id', $headermenu->category_id) == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div id="page-group" class="form-group{{ $errors->has('page_id') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <select id="page_id" class="form-control" name="page_id">
                                        <option value>الصفحة</option>
                                        @foreach ( $pages as $page )
                                            <option {{ old('page_id', $headermenu->page_id) == $page->id ? 'selected' : '' }} value="{{ $page->id }}">{{ $page->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('page_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('page_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="الترتيب" id="order" type="text" class="form-control" name="order" value="{{ old('order', $headermenu->order) }}">
                                    @if ($errors->has('order'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('order') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-default btn-block">
                                        تعديل
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
