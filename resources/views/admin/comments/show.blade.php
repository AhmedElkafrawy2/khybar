@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'comments' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        عرض تعليق
                        <a style="margin-right: 3px;" class="btn btn-danger btn-xs pull-left" href="{{ route('comments.destroy', $comment->id) }}">حذف</a>
                        @if( $comment->user_id != 0 )
                            <a style="margin-right: 3px;" class="btn btn-info btn-xs pull-left" href="{{ route('users.edit', $comment->user()->first()->id) }}">{{ $comment->user()->first()->name }}</a>
                        @else
                            {{ $comment->name }}
                        @endif
                        <a class="btn btn-info btn-xs pull-left" target="_blank" href="{{ $comment->post->type == 1 ? route('show.news', $comment->post->slug) : route('show.essay', $comment->post->slug) }}">
                            {{ $comment->post->type == 1 ? 'الخبر' : 'المقال' }}
                        </a>
                    </div>

                    <div class="panel-body">
                        <p>{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
