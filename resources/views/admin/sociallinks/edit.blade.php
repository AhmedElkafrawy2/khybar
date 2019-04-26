@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'sociallinks' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        تعديل رابط
                        <a href="{{ route('sociallinks.destroy', $sociallink->id) }}" class="btn btn-danger btn-xs pull-left">حذف</a>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('sociallinks.update', $sociallink->id) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="الاسم" id="name" type="text" class="form-control" name="name" value="{{ old('name', $sociallink->name) }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-addon">fa fa-</div>
                                        <input placeholder="الايقونه" id="icon" type="text" class="form-control" name="icon" value="{{ old('icon', $sociallink->icon) }}">
                                    </div>
                                    <span class="help-block">
                                        <strong>الايقونات المتاحة : <a target="_blank" href="http://fontawesome.io/icons/">هنا</a></strong>
                                    </span>
                                    @if ($errors->has('icon'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('icon') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="الرابط" id="link" type="text" class="form-control" name="link" value="{{ old('link', $sociallink->link) }}">
                                    @if ($errors->has('link'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="اللون" id="color" type="text" class="form-control" name="color" value="{{ old('color', $sociallink->color) }}">
                                    @if ($errors->has('color'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('color') }}</strong>
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
