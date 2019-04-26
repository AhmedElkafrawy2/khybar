@php ( $quill = '' )
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'staffer' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        تعديل عضو هيئة التحرير
                        <a href="{{ route('staffer.destroy', $staffer->id) }}" class="btn btn-danger btn-xs pull-left">حذف</a>
                    </div>

                    <div class="panel-body">

                        <div class="alert alert-warning">
                            <p><strong>ملاحظة: </strong>عند ترك الصورة فارغة لا يتم تغيير الصورة السابقة.</p>
                        </div>

                        <form class="form-horizontal" method="POST" action="{{ route('staffer.update', $staffer->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="الاسم" id="name" type="text" class="form-control" name="name" value="{{ old('name', $staffer->name) }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('job_title') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="الوظيفة" id="job_title" type="text" class="form-control" name="job_title" value="{{ old('job_title', $staffer->job_title) }}">
                                    @if ($errors->has('job_title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('job_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="thumbnail">
                                <img src="{{ asset($path.'staffer/'.$staffer->image()->first()->filename) }}" alt="{{ $staffer->image()->first()->filename }}">
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
