@php( $noNav = '' )
@extends('admin.layouts.app')

@section('content')
<div class="table-flow">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                @include('admin.layouts.message')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        إستعادة كلمة المرور
                        <a class="pull-left" href="{{ route('admin.login') }}">
                            دخول
                        </a>
                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form-horizontal" method="POST" action="{{ route('admin.password.email') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                <div class="col-md-12">
                                    <input placeholder="البريد الالكتروني" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        استعادة كلمة المرور
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
