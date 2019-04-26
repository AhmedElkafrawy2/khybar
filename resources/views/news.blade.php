@extends('layouts.app')
@section('title')
    | {{ $new->title }}
@endsection
@section('content')
	@include('layouts.header')
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				@include('layouts.message')
				@if ( count ( $rightbanners ) )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[0]->image()->first()->filename) }}" alt="{{ $rightbanners[0]->image()->first()->filename }}">
					</div>
				@endif
				<div class="panel panel-default" id="panel-title">
					<div class="panel-body">
						<h1 class='news-title-font' style="margin: 0; font-size: 28px; line-height: 50px;">{{ $new->title }}</h1>
                                                <h2 style="color: #64B5F6"> مصدرالخبر: {{ $new->post_source  }} </h2>
					</div>
				</div>
				<div class="thumbnail">
				    <img src="{{ asset($path.'news/'.$new->image()->first()->filename) }}" alt="{{ $new->image()->first()->filename }}">
				</div>
				<div class="panel panel-default">
					<div class="news-title-font panel-body tinymcecontent">
						{!! $new->content !!}
					</div>
					<div class="panel-footer social-share">
						<p>
						شارك هذا الخبر على
						</p>
						<ul>
							<a href="https://www.facebook.com/sharer/sharer.php?u={{ route('show.news', $new->slug) }}" target="_blank">
								<li>
									<i class="fab fa-facebook"></i>
								</li>
							</a>
							<a href="https://twitter.com/intent/tweet?text={{ route('show.news', $new->slug) }}" target="_blank">
								<li>
									<i class="fab fa-twitter-square"></i>
								</li>
							</a>
							<a href="whatsapp://send?text={{ route('show.news', $new->slug) }}"
							data-action="share/whatsapp/share" target="_blank">
								<li>
									<i class="fab fa-whatsapp-square"></i>
								</li>
							</a>
						</ul>
					</div>
				</div>
				@if ( count ( $rightbanners ) > 1 )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[1]->image()->first()->filename) }}" alt="{{ $rightbanners[1]->image()->first()->filename }}">
					</div>
				@endif
				<div class="panel panel-default" style="margin-top: 15px;">
					<div class="panel-heading">
						الكاتب
					</div>
					<div class="panel-body">
						<div class="media">
							<div class="media-left">
								<img class="img-rounded" style="width: 64px;height: 64px;border: 1px solid #d3e0e9;" class="media-object" src="{{ $new->writer()->first()->image_id ? asset($path.'writers/'.$new->writer()->first()->image()->first()->filename) : asset($path.'writers/default.png') }}" alt="{{ $new->writer()->first()->image_id ? $new->writer()->first()->image()->first()->filename : 'default.png' }}">
							</div>
							<div class="media-body">
								<span class="label label-default pull-left" style="margin-right: 3px;">
									{{ $new->writer()->first()->posts()->count() }} منشور
								</span>
								@if ( $new->writer()->first()->id == 1 )
									<span class="label label-warning pull-left">
										الادارة
									</span>
								@endif
								<h4 class="media-heading">
									{{ $new->writer()->first()->name }}
								</h4>
								<hr style="margin-top: 10px; margin-bottom: 10px;">
								<p>{{ $new->writer()->first()->bio }}</p>
							</div>
						</div>
					</div>
				</div>

				<div class="panel panel-default" style="margin-top: 15px;">
					<div class="panel-heading">
						التعليقات - {{ $new->available_comments()->get()->count() }}
					</div>
					@if ( $new->available_comments()->get()->count() )
						<div class="panel-body">
                                                    
							@foreach ( $new->available_comments()->get() as $comment )
							<div class="media">
								<div class="media-left">
                                                                    
									<img class="img-rounded" 
                                                                             style="width: 64px;height: 64px;border: 1px solid #d3e0e9;" 
                                                                             class="media-object" 
                                                                             @if($comment->user_id != 0)
                                                                                src="{{ $comment->user()->first()->image_id ? asset($path.'users/'.$comment->user()->first()->image()->first()->filename) : asset($path.'users/default.png') }}" 
                                                                                alt="{{ $comment->user()->first()->image_id ? $comment->user()->first()->image()->first()->filename : 'default.png' }}">
                                                                             @else
                                                                                src="{{ asset($path.'users/default.png')  }}"
                                                                                alt='default.png'>
                                                                             @endif
                                                                             
								</div>
								<div class="media-body">
									<h4 class="media-heading">{{ $comment->name }}</h4>
									{{ $comment->content }}
								</div>
							</div>
							@endforeach
						</div>
					@endif
				</div>


                                <form action="{{ route('comments.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="post_id" value="{{ $new->id }}">
                                        <div class="panel panel-default" style="margin-top: 15px;">
                                                <div class="panel-heading">
                                                        اضافة تعليق
                                                        <button type="submit" class="btn btn-default btn-xs pull-left">نشر</button>
                                                </div>
                                                <div class="panel-body">
                                                        @guest
                                                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                                <input type="text" id="name" placeholder="الاسم" class="form-control" name="name" rows="8" cols="80" value="{{ old('name') }}" />
                                                                @if ($errors->has('name'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('name') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                                                            <textarea id="content" placeholder="التعليق" class="form-control" name="content" rows="8" cols="80">{{ old('content') }}</textarea>
                                                            @if ($errors->has('content'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('content') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                </div>
                                        </div>
                                </form>
				@if ( count ( $rightbanners ) > 2 )
					<div class="ad1">
						<img src="{{ asset($path.'banners/'.$rightbanners[2]->image()->first()->filename) }}" alt="{{ $rightbanners[2]->image()->first()->filename }}">
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