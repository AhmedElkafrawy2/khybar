@extends('layouts.app')
@section('title')
   | {{ $writer->name }}
@endsection
@section('content')

	@include('layouts.header')

	<div class="container">
		<div class="row">


			<div class="col-md-9">

				<div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="thumbnail" style="margin: 0;">
                                    @if ( $writer->image_id )
                                        <img src="{{ asset($path.'writers/'.$writer->image()->first()->filename) }}" alt="{{ $writer->image()->first()->filename }}">
									@else
										<img src="{{ asset($path.'/writers/default.png') }}" alt="default.png">
									@endif
                                </div>
                            </div>
                            <div class="col-md-10">
								<span class="label label-default pull-left" style="margin-right: 3px;">
									{{ $writer->posts()->count() }} منشور
								</span>
								@if ( $writer->id == 1 )
									<span class="label label-warning pull-left">
										الادارة
									</span>
								@endif
								<p><b>{{ $writer->name }}</b></p>
                                <p style="margin: 0;"><small>{{ $writer->bio }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>

				@if ( count ( $rightbanners ) )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[0]->image()->first()->filename) }}" alt="{{ $rightbanners[0]->image()->first()->filename }}">
					</div>
				@endif
				@if ( count($admin_posts) )
					<div class="mogtmaa mhliat">
						@foreach ( $admin_posts as $key => $post )
							@if ( $key < 5 )
								<div class="news_book_details">
									<div class="col-md-5 col-xs-12">
										@if ( $post->type == 1 )
											<img src="{{ asset($path.'/news/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}">
										@else
											<img src="{{ asset($path.'/essays/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}">
										@endif
										@if ( $post->category_id !== null )
											<div class="content_bar">{{ $post->category()->first()->name }}</div>
										@endif
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
				@if ( count($admin_posts) > 6 )
				<div class="mogtmaa mhliat">
					@foreach ( $admin_posts as $key => $post )
						@if ( $key > 5 )
							<div class="news_book_details">
								<div class="col-md-5 col-xs-12">
									@if ( $post->type == 1 )
										<img src="{{ asset($path.'/news/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}">
									@else
										<img src="{{ asset($path.'/essays/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}">
									@endif
									@if ( $post->category_id !== null )
										<div class="content_bar">{{ $post->category()->first()->name }}</div>
									@endif
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
				{{ $admin_posts->links() }}
			</div>
            <div class="col-md-3">
				@include('layouts.sidebar')
			</div>
    	</div>
	</div>

	@include('layouts.footer')
@endsection
