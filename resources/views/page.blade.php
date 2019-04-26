@extends('layouts.app')
@section('title')
    | {{ $page->title }}
@endsection
@section('content')
	@include('layouts.header')
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				@if ( count ( $rightbanners ) )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[0]->image()->first()->filename) }}" alt="{{ $rightbanners[0]->image()->first()->filename }}">
					</div>
				@endif

				<div class="panel panel-default" style="margin-top: 15px;">
					<div class="panel-body">
						<h1 style="margin: 0; font-size: 28px; line-height: 50px;">{{ $page->title }}</h1>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-body tinymcecontent">
						{!! $page->content !!}
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
