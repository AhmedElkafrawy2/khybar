<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="{{ !isset($category) && !isset($page) ? 'active' : '' }}">
                    <a href="{{ route('index') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>


                @foreach ( $headermenus as $headermenu )
                    @if ( isset( $category ) )
                        @php( $activated = $category->slug )
                    @elseif(  isset( $page ) )
                        @php( $activated = $page->slug )
                    @else
                        @php ( $activated = null )
                    @endif
                    @if ( $headermenu->category_id )
                        @php( $selected = $headermenu->category()->first()->slug )
                    @endif
                    @if( $headermenu->page_id )
                        @php( $selected = $headermenu->page()->first()->slug )
                    @endif
        
                    <li class="{{ $selected == $activated ? 'active' : '' }}">
                        <a href="{{ route($headermenu->category_id ? 'show.category' : 'show.page', $headermenu->category_id ? $headermenu->category()->first()->slug : $headermenu->page()->first()->slug) }}">{{ $headermenu->category_id ? $headermenu->category()->first()->name : $headermenu->page()->first()->title }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="col-md-3 search_div">
                <form method="post" action="{{ route('search') }}">
                    {{ csrf_field() }}
                    <div class="input-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input name="word" class="form-control" placeholder="أدخل كلمة البحث هنا .." type="text">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                        
                    </div>
                    @if ($errors->has('word'))
                        <small style="color: #fff;">
                            <strong>{{ $errors->first('word') }}</strong>
                        </small>
                    @endif
                </form>
            </div>
        </div>
    </div>
</nav>
