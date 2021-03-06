@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'banners' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        تعديل بنر
                        <a href="{{ route('banners.destroy', $banner->id) }}" class="btn btn-danger btn-xs pull-left">حذف</a>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('banners.update', $banner->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="thumbnail">
                                <img src="{{ asset($path.'banners/'.$banner->image()->first()->filename) }}" alt="{{ $banner->image()->first()->filename }}">
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

                            <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <select id="position" class="form-control" name="position">
                                        <option value="">المكان</option>
                                        <option {{ old('position', $banner->position) == 1 ? 'selected' : '' }} value="1">العمود الايمن</option>
                                        <option {{ old('position', $banner->position) == 2 ? 'selected' : '' }} value="2">العمود الايسر</option>
                                    </select>
                                    @if ($errors->has('position'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('position') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <span class="help-block">
                                <strong>بنرات العمود الايمن : </strong> النسبة بين الابعاد 1:8
                                <strong>بنرات العمود الايسر : </strong> النسبة بين الابعاد 1:1 (مربع)
                            </span>

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
