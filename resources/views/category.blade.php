@extends('layouts.app')
@section('title')
 | {{ $category->name }}
@endsection
@section('content')

	@include('layouts.header')

	<div class="container">
		<div class="row">
			<div class="well">
				<h1 class="text-center" style="margin: 0;">{{ $category->name }}</h1>
			</div>

			<div class="col-md-9">
				@if ( count ( $rightbanners ) )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[0]->image()->first()->filename) }}" alt="{{ $rightbanners[0]->image()->first()->filename }}">
					</div>
				@endif
				@if ( count($category_posts) )
					<div class="mogtmaa mhliat">
						@foreach ( $category_posts as $key => $post )
							@if ( $key <= 5 )
								<div style="min-width: 100%" class="news_book_details">
									<div class="col-md-5 col-xs-12">
										@if ( $post->type == 1 )
											<img style="height: 200px" src="{{ asset($path.'news/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}">
										@else
											<img style="height: 200px" src="{{ asset($path.'essays/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}">
										@endif
										<div class="content_bar">{{ $post->category()->first()->name }}</div>
									</div>
									<div class="col-md-7">
										<a href="{{ $post->type == 1 ? route('show.news', $post->slug) : route('show.essay', $post->slug) }}">
											<h5>{{ $post->title }}</h5>
										</a>
										<p>{{ $post->description }}</p>
										<p>
											<small><i class="fa fa-calendar"></i>{{ date_format($post->created_at, 'Y/m/d') }}</small>
											<small><i class="fa fa-eye"></i>{{ $post->views }}</small>
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
				@if ( count($category_posts) > 6 )
				<div class="mogtmaa mhliat">
					@foreach ( $category_posts as $key => $post )
						@if ( $key > 5 )
							<div style="min-width: 100%" class="news_book_details">
								<div class="col-md-5 col-xs-12">
									@if ( $post->type == 1 )
										<img style="height: 200px" src="{{ asset($path.'/news/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}">
									@else
										<img style="height: 200px" src="{{ asset($path.'/essays/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}">
									@endif
									<div class="content_bar">{{ $post->category()->first()->name }}</div>
								</div>
								<div class="col-md-7">
									<a href="{{ $post->type == 1 ? route('show.news', $post->slug) : route('show.essay', $post->slug) }}">
										<h5>{{ $post->title }}</h5>
									</a>
									<p>{{ $post->description }}</p>
									<p>
										<small><i class="fa fa-calendar"></i>{{ date_format($post->created_at, 'Y/m/d') }}</small>
										<small><i class="fa fa-eye"></i>{{ $post->views }}</small>
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
				{{ $category_posts->links() }}
			</div>
            <div class="col-md-3">
				@include('layouts.sidebar')
			</div>
    	</div>
	</div>

	@include('layouts.footer')
@endsection
