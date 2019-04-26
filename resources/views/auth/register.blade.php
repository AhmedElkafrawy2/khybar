@extends('layouts.app')

@section('content')
<div class="table-flow">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="register-image-container">
                    <img data-toggle="tooltip" data-placement="bottom" title="تعديل الصورة الشخصية" class="register-default-image" src="{{ url('/')}}/storage/app/public/users/default.png" />
                    <input form="register-form-id" type="file" id="register-file-input" name="image" class="register-file-input" value="{{ old('image') }}" />
                    @if ($errors->has('image'))
                        <div class="alert alert-danger help-block">
                            <strong>{{ $errors->first('image') }}</strong>
                        </div>
                    @endif
                </div>
                <div @if($errors->has('image')) style='margin-top: 51px;' @endif class="panel panel-default">
                    <div class="panel-heading">
                        تسجيل
                        <a class="pull-left" href="{{ route('login') }}">
                            دخول
                        </a>
                    </div>
                    <div class="panel-body">
                        <form id="register-form-id" class="form-horizontal" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                <div class="col-md-12">
                                    <input placeholder="الاسم" id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                <div class="col-md-12">
                                    <input placeholder="البريد الإلكتروني" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">

                                <div class="col-md-12">
                                    <input placeholder="رقم الهاتف/الجوال" id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}">

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                <div class="col-md-12">
                                    <input placeholder="كلمة المرور" id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="col-md-12">
                                    <input placeholder="تأكيد كلمة المرور" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        تسجيل
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
