<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="footer_text">المشاركات والتعليقات المنشورة بأسماء أصحابها أو بأسماء مستعارة لا تمثل الرأي الرسمي لصحيفة (خيبر) الإخبارية بل تمثل وجهة نظر كاتبها</p>
            </div>
            <div class="col-md-12">
                <div class="col-md-4">
                    <img src="{{ asset('images/logo-bottom.png') }}">
                </div>
                <div class="col-md-5" style="margin-top: 70px;">
                    @if ( count( $footermenus ) )
                        <ul>
                            @foreach ( $footermenus as $footermenu )
                                <li>
                                    <a href="{{ route($footermenu->category_id ? 'show.category' : 'show.page', $footermenu->category_id ? $footermenu->category()->first()->slug : $footermenu->page()->first()->slug) }}">
                                        {{ $footermenu->category_id ? $footermenu->category()->first()->name : $footermenu->page()->first()->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="col-md-3" style="margin-top: 70px;">
                    <form>
                        <div class="input-group">

                            <input class="form-control" placeholder="أدخل بريدك الإلكتروني  هنا .." type="text">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"> <i class="glyphicon glyphicon-envelope"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <br>
                    @if ( $settings->social_in_header )
                        <div class="social">
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
    </div>
</footer>

<div class="footer_copyright">
    <div class="container">
        <div class="row">

            <div class="col-md-9">جميع الحقوق محفوظة لـ صحيفة خيبر الإخبارية © 2018</div>
            <div class="col-md-3">Made with <i style="color:#ff0000;" class="fas fa-heart"></i> by Wisyst.com</div>
        </div>
    </div>
</div>
