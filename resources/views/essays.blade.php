@extends('layouts.app')
@section('title')
| المقالات
@endsection
@section('content')

	@include('layouts.header')

	<div class="container">
		<div class="row">
			<div class="well">
				<h1 class="text-center" style="margin: 0;">المقالات</h1>
			</div>

			<div class="col-md-9">
				@if ( count ( $rightbanners ) )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[0]->image()->first()->filename) }}" alt="{{ $rightbanners[0]->image()->first()->filename }}">
					</div>
				@endif
				@if ( count($essays) )
					<div class="mogtmaa mhliat">
						@foreach ( $essays as $key => $essay )
							@if ( $key <= 5 )
								<div style="min-width: 100%" class="news_book_details">
									<div class="col-md-5 col-xs-12">
                                                                                <img height="200px" src="{{ asset($path.'essays/'.$essay->image()->first()->filename) }}" alt="{{ $essay->image()->first()->filename }}">
										@if ( $essay->category_id !== null )
											<div class="content_bar">{{ $essay->category()->first()->name }}</div>
										@endif
									</div>
									<div class="col-md-7">
										<a href="{{ route('show.essays', $essay->slug) }}">
											<h5>{{ $essay->title }}</h5>
										</a>
										<p>{{ $essay->description }}</p>
										<p>
											<small><i class="fa fa-calendar"></i>{{ date_format($essay->created_at, 'Y/m/d') }}</small>
											<small><i class="fa fa-eye"></i>{{ $essay->views }}</small>
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
				@if ( count($essays) > 6 )
					<div class="mogtmaa mhliat">
						@foreach ( $essays as $key => $essay )
							@if ( $key > 5 )
								<div style="min-width: 100%" class="news_book_details">
									<div class="col-md-5 col-xs-12">
                                                                                <img style="height: 200px" src="{{ asset($path.'essays/'.$essay->image()->first()->filename) }}" alt="{{ $essay->image()->first()->filename }}">
										@if ( $essay->category_id !== null )
											<div class="content_bar">{{ $essay->category()->first()->name }}</div>
										@endif
									</div>
									<div class="col-md-7">
										<a href="{{ route('show.essays', $essay->slug) }}">
											<h5>{{ $essay->title }}</h5>
										</a>
										<p>{{ $essay->description }}</p>
										<p>
											<small><i class="fa fa-calendar"></i>{{ date_format($essay->created_at, 'Y/m/d') }}</small>
											<small><i class="fa fa-eye"></i>{{ $essay->views }}</small>
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
				{{ $essays->links() }}
			</div>
            <div class="col-md-3">
				@include('layouts.sidebar')
			</div>
    	</div>
	</div>

	@include('layouts.footer')
@endsection
