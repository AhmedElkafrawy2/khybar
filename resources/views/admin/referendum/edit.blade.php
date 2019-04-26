@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'referendum' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        تعديل الاستفتاء
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('referendum.update') }}" >
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input placeholder="السؤال" id="title" type="text" class="form-control" name="title" value="{{ old('title', $referendum->title) }}">
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
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
