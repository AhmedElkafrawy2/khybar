@if ( count ( $leftbanners ) )
    <div class="ad1">
        <img src="{{ asset($path.'banners/'.$leftbanners[0]->image()->first()->filename) }}" alt="{{ $leftbanners[0]->image()->first()->filename }}">
    </div>
@endif
@if ( count( $lastessays ) )
    <div class="news_book">
        <h4>جديد المقالات</h4>
        @foreach ( $lastessays as $essay )
            <div class="news_book_details">
                <div class="col-md-4">
                    <img src="{{ asset($path.'essays/'.$essay->image()->first()->filename) }}" alt="{{ $essay->image()->first()->filename }}">
                </div>
                <div class="col-md-8 col-xs-8">
                    <a href="{{ route('show.essay', $essay->slug) }}">
                        <h5>{{ $essay->title }}</h5>
                    </a>
                    <p>
                        <span>بواسطة :</span>
                        <a href="{{ route('show.writer', $essay->writer()->first()->id) }}">
                            {{ $essay->writer()->first()->name }}
                        </a>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@endif
@if ( $settings->sidebar_slider_category_id )
    @if ( count ( $slidebarslides ) )
        <div class="slideshow-container">
            @foreach ( $slidebarslides as $slide )
                <div class="mySlides fade2">
                    @if ( $post->type == 1 )
                        <img src="{{ asset($path.'news/'.$slide->image()->first()->filename) }}" alt="{{ $slide->image()->first()->filename }}" style="width:100%">
                    @else
                        <img src="{{ asset($path.'essays/'.$slide->image()->first()->filename) }}" alt="{{ $slide->image()->first()->filename }}" style="width:100%">
                    @endif
                    <div class="text">
                        <h3>{{ $slide->category()->first()->name }}</h3>
                        <br>{{ $slide->title }}
                    </div>
                </div>
            @endforeach
            <a class="next" onclick="plusSlides(1)">&#10094;</a>
            <a class="prev" onclick="plusSlides(-1)">&#10095;</a>
        </div>
    @endif
@endif
@if ( count ( $leftbanners ) > 1 )
    <div class="ad1">
        <img src="{{ asset($path.'banners/'.$leftbanners[1]->image()->first()->filename) }}" alt="{{ $leftbanners[1]->image()->first()->filename }}">
    </div>
@endif
@if ( count ( $mostviewed ) || count ( $mostcommented ) )
    <div class="watch">
        <ul class="nav nav-tabs">
            @if ( count( $mostviewed ) )
                <li class="active">
                    <a data-toggle="tab" href="#views">الأكثر مشاهدة</a>
                </li>
            @endif
            @if ( count( $mostcommented ) )
                <li>
                    <a data-toggle="tab" href="#comments">الأكثر تعليقا</a>
                </li>
            @endif
        </ul>
        <div class="tab-content">
            @if ( count( $mostviewed ) )
                <div id="views" class="tab-pane fade in active">
                    @foreach ( $mostviewed as $post )
                        <div class="news_book_details">
                            <div class="col-md-4">
                                @if ( $post->type == 1 )
                                    <img src="{{ asset($path.'news/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}" style="width:100%">
                                @else
                                    <img src="{{ asset($path.'essays/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}" style="width:100%">
                                @endif
                            </div>
                            <div class="col-md-8 col-xs-8">
                                <a href="{{ $post->type == 1 ? route('show.news', $post->slug) : route('show.essay', $post->slug) }}">
                                    <p>{{ $post->title }}</p>
                                    <p> <small style="margin-left: 4px;"><i class="fa fa-eye"></i>{{ $post->views }}</small>
                                        <small><i class="fa fa-comments"></i>{{ $post->comments()->count() }}</small>
                                    </p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ( count( $mostcommented ) )
                <div id="comments" class="tab-pane fade">
                    @foreach ( $mostcommented as $post )
                        <div class="news_book_details">
                            <div class="col-md-4">
                                @if ( $post->type == 1 )
                                    <img src="{{ asset($path.'news/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}" style="width:100%">
                                @else
                                    <img src="{{ asset($path.'essays/'.$post->image()->first()->filename) }}" alt="{{ $post->image()->first()->filename }}" style="width:100%">
                                @endif
                            </div>
                            <div class="col-md-8 col-xs-8">
                                <a href="{{ route('show.news', $post->slug) }}">
                                    <p>{{ $post->title }}</p>
                                    <p> <small style="margin-left: 7px;"><i class="fa fa-eye"></i>{{ $post->views }}</small>
                                        <small><i class="fa fa-comments"></i>{{ $post->comments()->count() }}</small>
                                    </p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endif
@if ( $referendum->activated && $referendum->answers()->count() )
    @Guest
        <div class="poll">
            <h4>الاستفتاء</h4>
            <p>{{ $referendum->title }}</p>
            <form action="{{ route('referendumvotes.store') }}" method="post">
                {{ csrf_field() }}
                @foreach ( $referendum->answers()->get() as $answer )
                    <div class="radio">
                        <input id="answer_{{ $answer->id }}" type="radio" name="answer_{{ $answer->id }}" value="{{ $answer->id }}">
                        <label class="mark" for="answer_{{ $answer->id }}">
                            {{ $answer->answer }}
                        </label>
                    </div>
                @endforeach
                <br>
                <button type="submit" class="vote">تصويت</button>
            </form>
        </div>
    @else
        @if ( count ( auth()->user()->vote()->first() ) )
            <div class="poll">
                <h4>الاستفتاء</h4>
                <div class="col-sm-12">
                    <div class="alert alert-warning">
                        <p>لقد قمت بالتصويت من قبل.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="poll">
                <h4>الاستفتاء</h4>
                <p>{{ $referendum->title }}</p>
                <form action="{{ route('referendumvotes.store') }}" method="post">
                    {{ csrf_field() }}
                    @foreach ( $referendum->answers()->get() as $answer )
                        <div class="radio">
                            <input id="answer_{{ $answer->id }}" type="radio" name="answer_{{ $answer->id }}" value="{{ $answer->id }}">
                            <label class="mark" for="answer_{{ $answer->id }}">
                                {{ $answer->answer }}
                            </label>
                        </div>
                    @endforeach
                    <br>
                    <button type="submit" class="vote">تصويت</button>
                </form>
            </div>
        @endif
    @endif
@endif
