@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'referendum' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        اضافة اختيار للاستفتاء
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('referendum.choices.store') }}" >
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="الاختيار" id="answer" type="text" class="form-control" name="answer" value="{{ old('answer') }}">
                                    @if ($errors->has('answer'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('answer') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        اضافة
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
