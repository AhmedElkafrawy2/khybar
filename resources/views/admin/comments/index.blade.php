@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'comments' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if ( $show == 'unread' )
                        التعليقات غير المقروءة - {{ count( $comments )  }}
                        <a href="{{ route('comments.all') }}" class="btn btn-default btn-xs pull-left">الكل</a>
                    @else
                        الكل - {{ count( $comments )  }}
                        <a href="{{ route('comments') }}" class="btn btn-default btn-xs pull-left">غير المقروءة</a>
                    @endif
                </div>
                @if ( count( $comments ) == 0 )
                    <div class="panel-body">
                        <div class="alert alert-info" style="margin-bottom: 0px;">
                            <p>لا يوجد اي تعليقات غير مقروءة حتى الان.</p>
                        </div>
                    </div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>عرض</th>
                                <th>صاحب التلعيق</th>
                                <th>الخبر/المقال</th>
                                <th>تفعيل</th>
                                @if ( $show == 'unread' )
                                    <th>مقروء/حذف</th>
                                @else
                                    <th>حذف</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $comments as $comment )
                                <tr>
                                    <td>
                                        <a  class="btn btn-default btn-xs" href="{{ route('comments.show', $comment->id) }}">عرض</a>
                                    </td>
                                    <td>
                                        @if($comment->user_id != 0)
                                        <a class="btn btn-info btn-xs" href="{{ route('users.edit', $comment->user()->first()->id) }}">
                                            {{ $comment->user()->first()->name }}
                                        </a>
                                        @else
                                            {{ $comment->name }}
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs" target="_blank" href="{{ $comment->post->type == 1 ? route('show.news', $comment->post->slug) : route('show.essay', $comment->post->slug) }}">
                                            {{ $comment->post->type == 1 ? 'الخبر' : 'المقال' }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($comment->user_id == 0)
                                            @if($comment->approved == 0)
                                            <a class="btn btn-success btn-xs" href="{{  route('comments.activate', $comment->id)  }}">
                                                تفعيل
                                            </a>
                                            @else
                                            <a class="btn btn-warning btn-xs" href="{{  route('comments.deactivate', $comment->id)  }}">
                                                الغاء التفعيل
                                            </a>
                                            @endif
                                        @else
                                            مفعل
                                        @endif
                                    </td>
                                    @if ( $show == 'unread' )
                                        <td>
                                            <a class="btn btn-success btn-xs" href="{{ route('comments.review', $comment->id) }}">مقروء</a>
                                            <a class="btn btn-danger btn-xs" href="{{ route('comments.destroy', $comment->id) }}">حذف</a>
                                        </td>
                                    @else
                                        <td>
                                            <a class="btn btn-danger btn-xs" href="{{ route('comments.destroy', $comment->id) }}">حذف</a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $comments->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
