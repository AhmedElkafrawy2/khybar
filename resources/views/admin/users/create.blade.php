@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'users' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                @include('admin.layouts.message')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        إضافة عضو
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

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

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="الاسم" id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="البريد" id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="رقم الجوال" id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="كلمة المرور" id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
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
                                    <textarea id="bio" placeholder="نبذة" class="form-control" name="bio" rows="8" cols="80">{{ old('bio') }}</textarea>
                                    @if ($errors->has('bio'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('bio') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        إضافة
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
