@extends('layouts.app')

@section('content')
	@include('layouts.header')
	<div class="container">
		<div class="row">
		    <div class="well">
				<h1 class="text-center" style="margin: 0;">{{ $word }}</h1>
			</div>
			<div class="col-md-9">
				@if ( count ( $rightbanners ) )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[0]->image()->first()->filename) }}" alt="{{ $rightbanners[0]->image()->first()->filename }}">
					</div>
				@endif
				@if ( count($news) )
					<div class="mogtmaa mhliat">
						@foreach ( $news as $key => $new )
							@if ( $key <= 5 )
								<div class="news_book_details">
									<div class="col-md-5 col-xs-12">
										<img style="height: 200px" src="{{ asset($path.'news/'.$new->image()->first()->filename) }}" alt="{{ $new->image()->first()->filename }}">
										@if ( count ( $new->category()->first() ) )
											<div class="content_bar">{{ $new->category()->first()->name }}</div>
										@endif
									</div>
									<div class="col-md-7">
										<a href="{{ route('show.news', $new->slug) }}">
											<h5>{{ $new->title }}</h5>
										</a>
										<p>{{ $new->description }}</p>
										<p>
											<small><i class="fa fa-calendar"></i>{{ date_format($new->created_at, 'Y/m/d') }}</small>
											<small><i class="fa fa-eye"></i>{{ $new->views }}</small>
										</p>
									</div>
								</div>
							@endif
						@endforeach
					</div>
				@endif
				@if ( count ( $rightbanners ) > 1 )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[1]->image()->first()->filename) }}" alt="{{ $rightbanners[1]->image()->first()->filename }}">
					</div>
				@endif
				@if ( count($news) > 6 )
					<div class="mogtmaa mhliat">
						@foreach ( $news as $key => $new )
							@if ( $key > 5 )
								<div class="news_book_details">
									<div class="col-md-5 col-xs-12">
                                                                                <img style="height: 200px" src="{{ asset($path.'news/'.$new->image()->first()->filename) }}" alt="{{ $new->image()->first()->filename }}">
										@if ( count ( $new->category()->first() ) )
											<div class="content_bar">{{ $new->category()->first()->name }}</div>
										@endif
									</div>
									<div class="col-md-7">
										<a href="{{ route('show.news', $new->slug) }}">
											<h5>{{ $new->title }}</h5>
										</a>
										<p>{{ $new->description }}</p>
										<p>
											<small><i class="fa fa-calendar"></i>{{ date_format($new->created_at, 'Y/m/d') }}</small>
											<small><i class="fa fa-eye"></i>{{ $new->views }}</small>
										</p>
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
				{{ $news->links() }}
			</div>
            <div class="col-md-3">
				@include('layouts.sidebar')
			</div>
    	</div>
	</div>

	@include('layouts.footer')
@endsection
