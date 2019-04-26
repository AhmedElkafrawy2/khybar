<div class="col-sm-3">
    @if ( auth()->guard('admin')->user()->id == 1 )
        <div class="list-group">
            <a href="{{ route('categories') }}" class="list-group-item {{ $page == 'categories' ? 'active' : '' }}">الاقسام</a>
            <a href="{{ route('news') }}" class="list-group-item {{ $page == 'news' ? 'active' : '' }}">الاخبار</a>
            <a href="{{ route('essays') }}" class="list-group-item {{ $page == 'essays' ? 'active' : '' }}">المقالات</a>
            <a href="{{ route('staffer') }}" class="list-group-item {{ $page == 'staffer' ? 'active' : '' }}">هيئة التحرير</a>
            <a href="{{ route('breakingnews') }}" class="list-group-item {{ $page == 'breakingnews' ? 'active' : '' }}">الاخبار العاجلة</a>
            <a href="{{ route('pages') }}" class="list-group-item {{ $page == 'pages' ? 'active' : '' }}">الصفحات</a>
            <a href="{{ route('headermenus') }}" class="list-group-item {{ $page == 'headermenus' ? 'active' : '' }}">قائمة الرأس</a>
            <a href="{{ route('footermenus') }}" class="list-group-item {{ $page == 'footermenus' ? 'active' : '' }}">قائمة الذيل</a>
            <a href="{{ route('banners') }}" class="list-group-item {{ $page == 'banners' ? 'active' : '' }}">البنرات</a>
            <a href="{{ route('referendum') }}" class="list-group-item {{ $page == 'referendum' ? 'active' : '' }}">الاستفتاء</a>
            <a href="{{ route('contactuses') }}" class="list-group-item {{ $page == 'contactuses' ? 'active' : '' }}">
                اتصل بنا
                <span class="badge">{{ isset($unreadcontactusescount) ? $unreadcontactusescount : '' }}</span>
            </a>
            <a href="{{ route('comments') }}" class="list-group-item {{ $page == 'comments' ? 'active' : '' }}">
                مراجعة التعليقات
                <span class="badge">{{ isset($unreadcommentscount) ? $unreadcommentscount : '' }}</span>
            </a>
            <a href="{{ route('sociallinks') }}" class="list-group-item {{ $page == 'sociallinks' ? 'active' : '' }}">روابط مواقع التواصل</a>
        </div>
        <div class="list-group">
            <a href="{{ route('writers') }}" class="list-group-item {{ $page == 'writers' ? 'active' : '' }}">الكتاب</a>
            <a href="{{ route('users') }}" class="list-group-item {{ $page == 'users' ? 'active' : '' }}">الاعضاء</a>
        </div>
        <div class="list-group">
            <a href="{{ route('settings') }}" class="list-group-item {{ $page == 'settings' ? 'active' : '' }}">الاعدادات</a>
        </div>
    @else
    <div class="list-group">
        @if ( auth()->guard('admin')->user()->add_news )
            <a href="{{ route('news') }}" class="list-group-item {{ $page == 'news' ? 'active' : '' }}">اخباري</a>
        @endif
        @if ( auth()->guard('admin')->user()->add_essays )
            <a href="{{ route('essays') }}" class="list-group-item {{ $page == 'essays' ? 'active' : '' }}">مقالاتي</a>
        @endif
    </div>
    @endif
</div>
