@php ( $quill = '' )
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'essays' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        تعديل مقال
                        <a href="{{ route('essays.destroy', $essay->id) }}" class="btn btn-danger btn-xs pull-left">حذف</a>
                    </div>

                    <div class="panel-body">

                        <div class="alert alert-warning">
                            <p><strong>ملاحظة: </strong>عند ترك الصورة فارغة لا يتم تغيير الصورة السابقة.</p>
                        </div>

                        <form class="form-horizontal" method="POST" action="{{ route('essays.update', $essay->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="العنوان" id="title" type="text" class="form-control" name="title" value="{{ old('title', $essay->title) }}">
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-addon">example.com/essays/</div>
                                        <input placeholder="الرابط" id="slug" type="text" class="form-control" name="slug" value="{{ old('slug', $essay->slug) }}">
                                    </div>

                                    @if ($errors->has('slug'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> -->

                            <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <select id="category_id" class="form-control" name="category_id">
                                        <option value>غير مصنف</option>
                                        @foreach ( $categories as $category )
                                            <option {{ old('category_id', $essay->category_id) == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="thumbnail">
                                <img src="{{ asset($path.'essays/'.$essay->image()->first()->filename) }}" alt="{{ $essay->image()->first()->filename }}">
                            </div>

                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input id="image" type="file" class="form-control inputfile" name="image">
                                    <label for="image"><span>الصورة</span></label>
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <textarea id="description" placeholder="الملخص" class="form-control" name="description" rows="8" cols="80">{{ old('description', $essay->description) }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <textarea class="tinymce" id="content" name="content">{{ old('content', $essay->content) }}</textarea>
                                    @if ($errors->has('content'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <input id="comments" type="checkbox" name="comments" {{ old('comments', !$essay->comments) ? 'checked' : '' }}>
                                        <label for="comments" class="mark">ايقاف التعليقات</label>
                                    </div>
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
