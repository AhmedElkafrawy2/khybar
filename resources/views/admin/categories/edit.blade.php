@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'categories' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        تعديل قسم
                        <a href="{{ route('categories.destroy', $category->id) }}" class="btn btn-danger btn-xs pull-left">حذف</a>
                    </div>

                    <div class="panel-body">
                        <div class="alert alert-warning">
                            <p><strong>ملاحظة: </strong>عند حذف قسم تصبح جميع الاخبار والمقالات التي تحته بلا تصنيف ، كذلك يتم ازالته من القوائم.</p>
                        </div>

                        <form class="form-horizontal" method="POST" action="{{ route('categories.update', $category->id) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="الاسم" id="name" type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="الرابط" id="slug" type="text" class="form-control" name="slug" value="{{ old('slug', $category->slug) }}">
                                    @if ($errors->has('slug'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('slug') }}</strong>
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
