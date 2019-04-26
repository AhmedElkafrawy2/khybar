@extends('layouts.app')
@section('title')
    | اتصل بنا
@endsection
@section('content')

	@include('layouts.header')
	@include('layouts.message')

	<div class="container">
		<div class="row">
			<div class="col-md-9">
				@if ( count ( $rightbanners ) )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[0]->image()->first()->filename) }}" alt="{{ $rightbanners[0]->image()->first()->filename }}">
					</div>
				@endif
				<div class="panel panel-default" style="margin-top: 15px;">
					<div class="panel-heading">
						اتصل بنا
					</div>
					<div class="panel-body">
						<form action="{{ route('contactuses.store') }}" method="post">
							{{ csrf_field() }}
							<div class="row">
								 <div class="col-md-12">
									<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}" style="margin-bottom: 15px;">
	                                    <input placeholder="الاسم" id="name" type="name" class="form-control" name="name" value="{{ old('name') }}">
	                                    @if ($errors->has('name'))
	                                        <span class="help-block">
	                                            <strong>{{ $errors->first('name') }}</strong>
	                                        </span>
	                                    @endif
	                                </div>
	                            </div>

								<div class="col-md-6">
									<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" style="margin-bottom: 15px;">
	                                    <input placeholder="البريد الالكتروني" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
	                                    @if ($errors->has('email'))
	                                        <span class="help-block">
	                                            <strong>{{ $errors->first('email') }}</strong>
	                                        </span>
	                                    @endif
	                                </div>
	                            </div>

								<div class="col-md-6">
									<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}" style="margin-bottom: 15px;">
	                                    <input placeholder="رقم الجوال" id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}">
	                                    @if ($errors->has('phone'))
	                                        <span class="help-block">
	                                            <strong>{{ $errors->first('phone') }}</strong>
	                                        </span>
	                                    @endif
	                                </div>
	                            </div>

								<div class="col-md-12">
									<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}" style="margin-bottom: 15px;">
										<textarea id="content" placeholder="الرسالة" class="form-control" name="content" rows="8" cols="80">{{ old('content') }}</textarea>
										@if ($errors->has('content'))
											<span class="help-block">
												<strong>{{ $errors->first('content') }}</strong>
											</span>
										@endif
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
	                                    <button type="submit" class="btn btn-primary pull-left">
	                                        ارسال
	                                    </button>
	                                </div>
	                            </div>
							</div>
						</form>
					</div>
				</div>

				@if ( count ( $rightbanners ) > 1 )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[1]->image()->first()->filename) }}" alt="{{ $rightbanners[1]->image()->first()->filename }}">
					</div>
				@endif
			</div>
            <div class="col-md-3">
				@include('layouts.sidebar')
			</div>
    	</div>
	</div>

	@include('layouts.footer')
@endsection
