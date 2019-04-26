<div class="top">
    <div class="container">
        <div class="row">
            <div class="col-md-5 users">
                <script src="{{ asset('js/my_js.js') }}"></script>
                <script src="{{ asset('js/my_jss.js') }}"></script>
            </div>
            <div class="col-md-4 users">
                <ul>
                    @Guest
                        <a href="{{ route('login') }}">
                            <li>
                                <span class="glyphicon glyphicon-lock"></span>
                                تسجيل الدخول
                            </li>
                        </a>
                        <a href="{{ route('register') }}">
                            <li>
                                <span class="glyphicon glyphicon-user"></span>
                                مستخدم جديد
                            </li>
                        </a>
                    @else
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            <li>
                                <i class="fa fa-sign-out-alt"></i>
                                خروج
                            </li>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    @endif
                </ul>
            </div>

            @if ( $settings->social_in_header )
                <div class="col-md-3 social">
                    <ul>
                        @foreach ( $sociallinks as $sociallink )
                            <a href="{{ $sociallink->link }}">
                                <li>
                                    <i class="fa fa-{{ $sociallink->icon }}" style="background-color: #{{ $sociallink->color }};"></i>
                                </li>
                            </a>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="logo_div" style="background-image: url({{ asset($path.'settings/'.$settings->header()->first()->filename) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-xs-7">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('images/logo.png') }}">
                </a>
            </div>

            <div class="col-md-3 logo2 col-xs-5">
                <img src="{{ asset('images/logo2.png') }}">
            </div>
        </div>
    </div>
</div>

@include('layouts.nav')

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            @if ( count($breakingnews) )
                <div class="well breakingnews">
                    <div class="ticker-caption" style="background-image: url({{ asset('images/newsbar1-title.png') }});"></div>
                    <ul class="ticker">
                        @foreach ( $breakingnews as $breakingnew )
                            <li>
                                {{ $breakingnew->title }}
                                <i class="fa fa-globe" style="margin-right: 10px;"></i>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ( count($lastnews) )
                <div class="well lastnews">
                    <div class="ticker-caption2" style="background-image: url({{ asset('images/newsbar2-title.png') }});"></div>
                    <ul class="ticker">
                        @foreach ( $lastnews as $lastnew )
                            <li>
                                <a href="{{ route('show.news', $lastnew->slug) }}">
                                    {{ $lastnew->title }}
                                </a>
                                <i class="fa fa-clock-o" style="margin-right: 10px;"></i>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
