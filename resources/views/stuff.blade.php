@extends('layouts.app')
@section('title')
    | هيئة التحرير
@endsection
@section('content')

	@include('layouts.header')

	<div class="container">
		<div class="row">
			<div class="well">
				<h1 class="text-center" style="margin: 0;">هيئة التحرير</h1>
			</div>

			<div class="col-md-9">
				@if ( count ( $rightbanners ) )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[0]->image()->first()->filename) }}" alt="{{ $rightbanners[0]->image()->first()->filename }}">
					</div>
				@endif
				@if ( count($staffer) )
					<div class="mogtmaa mhliat">
						@foreach ( $staffer as $key => $post )
							@if ( $key <= 5 )
								<div style= "min-width:100%" class="news_book_details">
									<div  class="col-md-5 col-xs-12">
                                                                            <div style="height: 100%;padding-bottom: 0" class="img-wrapper">
                                                                                <img style="height: 200px" src="{{ asset($path.'staffer/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}">
                                                                            </div>
                                                                        </div>
									<div class="col-md-7">
										<a>
											<h5>{{ $post->name }}</h5>
										</a>
										<p>{{ $post->job_title }}</p>
									</div>
								</div>
							@endif
						@endforeach
					</div>
				
                                @else
                                <div class="alert alert-info mogtmaa mhliat">
                                    قائمة اعضاء هيئة التحرير فارغة
                                </div>
                                @endif
				@if ( count ( $rightbanners ) > 1 )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[1]->image()->first()->filename) }}" alt="{{ $rightbanners[1]->image()->first()->filename }}">
					</div>
				@endif
				@if ( count($staffer) > 6 )
				<div class="mogtmaa mhliat">
					@foreach ( $staffer as $key => $post )
						@if ( $key > 5 )
							<div style= "min-width:100%" class="news_book_details">
								<div class="col-md-5 col-xs-12">
                                                                    <div style="height: 100%;padding-bottom: 0" class="img-wrapper">
									<img style="height: 200px" src="{{ asset($path.'/staffer/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}">
                                                                    </div>
                                                                </div>
								<div class="col-md-7">
									<a href="#">
										<h5>{{ $post->name }}</h5>
									</a>
									<p>{{ $post->job_title }}</p>
								</div>
							</div>
						@endif
					@endforeach
				</div>
				@endif
				@if ( count ( $rightbanners ) > 2 )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[2]->image()->first()->filename) }}" alt="{{ $rightbanners[2]->image()->first()->filename }}">
					</div>
				@endif
				{{ $staffer->links() }}
			</div>
                        <div class="col-md-3">
                            @include('layouts.sidebar')
                        </div>
                </div>
	</div>

	@include('layouts.footer')
@endsection
