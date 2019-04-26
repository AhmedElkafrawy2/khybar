@php( $nav = 1 )
@extends('admin.layouts.app')

@section('content')
<div class="table-flow">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                @include('admin.layouts.message')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        تعديل ملفي
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-warning">
                            <p><strong>ملاحظة: </strong>عند ترك الصورة او كلمة المرور فارغة لا يتم تغيير السابقة.</p>
                        </div>
                        <form class="form-horizontal" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="thumbnail">
                                @if ( Auth::guard('admin')->user()->image_id )
                                    <img src="{{ asset($path.'writers/'.Auth::guard('admin')->user()->image()->first()->filename) }}" alt="{{ Auth::guard('admin')->user()->image()->first()->filename }}">
                                @else
                                    <img src="{{ asset($path.'writers/default.png') }}" alt="default.png">
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}" style="margin-bottom: 15px;">
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

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="الاسم" id="name" type="text" class="form-control" name="name" value="{{ old('name', Auth::guard('admin')->user()->name) }}" required >
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="البريد الإلكتروني" id="email" type="email" class="form-control" name="email" value="{{ old('email', Auth::guard('admin')->user()->email) }}" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="كلمة المرور" id="password" type="password" class="form-control" name="password">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <input placeholder="تأكيد كلمة المرور" id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <textarea id="bio" placeholder="نبذة" class="form-control" name="bio">{{ old('bio', Auth::guard('admin')->user()->bio) }}</textarea>
                                    @if ($errors->has('bio'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('bio') }}</strong>
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
</div>
@endsection
