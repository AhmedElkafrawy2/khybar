<?php

Route::get('setup', function(){
    Artisan::call('config:cache');
    return redirect()->route('index');
});

Route::group(['prefix' => 'admin'], function () {

    Route::post('/upload-posts-image', 'TinyMCEController@uploadPostsImage')->name('upload.posts.image');
    Route::post('/upload-posts-image-all', 'TinyMCEController@uploadPostsImageAll')->name('upload.posts.image.all');

    Route::get('/login', 'Admin\AuthController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Admin\AuthController@login')->name('admin.login');
    Route::get('/password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/reset', 'Admin\ResetPasswordController@reset');

    Route::group(['middleware' => 'auth:admin'], function () {

        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::post('/logout', 'Admin\AuthController@logout')->name('admin.logout');
        Route::get('profile', 'AdminController@profile')->name('admin.profile');
        Route::post('profile/update', 'AdminController@updateProfile')->name('admin.profile.update');

        Route::group(['prefix' => 'news'], function(){
            Route::get('/', 'PostController@newsIndex')->name('news');
            Route::get('/create', 'PostController@newsCreate')->name('news.create');
            Route::post('/store', 'PostController@newsStore')->name('news.store');
            Route::get('/edit/{id}', 'PostController@newsEdit')->name('news.edit');
            Route::post('/update/{id}', 'PostController@newsUpdate')->name('news.update');
            Route::get('/destroy/{id}', 'PostController@newsDestroy')->name('news.destroy');
        });

        Route::group(['prefix' => 'essays'], function(){
            Route::get('/', 'PostController@essaysIndex')->name('essays');
            Route::get('/create', 'PostController@essaysCreate')->name('essays.create');
            Route::post('/store', 'PostController@essaysStore')->name('essays.store');
            Route::get('/edit/{id}', 'PostController@essaysEdit')->name('essays.edit');
            Route::post('/update/{id}', 'PostController@essaysUpdate')->name('essays.update');
            Route::get('/destroy/{id}', 'PostController@essaysDestroy')->name('essays.destroy');
        });

        Route::group(['prefix' => 'pages'], function(){
            Route::get('/', 'PageController@index')->name('pages');
            Route::get('/create', 'PageController@create')->name('pages.create');
            Route::post('/store', 'PageController@store')->name('pages.store');
            Route::get('/edit/{id}', 'PageController@edit')->name('pages.edit');
            Route::post('/update/{id}', 'PageController@update')->name('pages.update');
            Route::get('/destroy/{id}', 'PageController@destroy')->name('pages.destroy');
            Route::get('/activate/{id}', 'PageController@activate')->name('pages.activate');
            Route::get('/deactivate/{id}', 'PageController@deactivate')->name('pages.deactivate');
        });

        Route::group(['prefix' => 'header-menu'], function(){
            Route::get('/', 'HeaderMenuController@index')->name('headermenus');
            Route::get('/create', 'HeaderMenuController@create')->name('headermenus.create');
            Route::post('/store', 'HeaderMenuController@store')->name('headermenus.store');
            Route::get('/edit/{id}', 'HeaderMenuController@edit')->name('headermenus.edit');
            Route::post('/update/{id}', 'HeaderMenuController@update')->name('headermenus.update');
            Route::get('/destroy/{id}', 'HeaderMenuController@destroy')->name('headermenus.destroy');
        });

        Route::group(['prefix' => 'footer-menu'], function(){
            Route::get('/', 'FooterMenuController@index')->name('footermenus');
            Route::get('/create', 'FooterMenuController@create')->name('footermenus.create');
            Route::post('/store', 'FooterMenuController@store')->name('footermenus.store');
            Route::get('/edit/{id}', 'FooterMenuController@edit')->name('footermenus.edit');
            Route::post('/update/{id}', 'FooterMenuController@update')->name('footermenus.update');
            Route::get('/destroy/{id}', 'FooterMenuController@destroy')->name('footermenus.destroy');
        });

        Route::group(['prefix' => 'categories'], function(){
            Route::get('/', 'CategoryController@index')->name('categories');
            Route::get('/create', 'CategoryController@create')->name('categories.create');
            Route::post('/store', 'CategoryController@store')->name('categories.store');
            Route::get('/edit/{id}', 'CategoryController@edit')->name('categories.edit');
            Route::post('/update/{id}', 'CategoryController@update')->name('categories.update');
            Route::get('/destroy/{id}', 'CategoryController@destroy')->name('categories.destroy');
        });
        Route::group(['prefix' => 'staffer'], function(){
            Route::get('/', 'StafferController@index')->name('staffer');
            Route::get('/create', 'StafferController@create')->name('staffer.create');
            Route::post('/store', 'StafferController@store')->name('staffer.store');
            Route::get('/edit/{id}', 'StafferController@edit')->name('staffer.edit');
            Route::post('/update/{id}', 'StafferController@update')->name('staffer.update');
            Route::get('/destroy/{id}', 'StafferController@destroy')->name('staffer.destroy');
        });

        Route::group(['prefix' => 'comments'], function(){
            Route::get('/', 'CommentController@index')->name('comments');
            Route::get('/all', 'CommentController@all')->name('comments.all');
            Route::get('/show/{id}', 'CommentController@show')->name('comments.show');
            Route::get('/destroy/{id}', 'CommentController@destroy')->name('comments.destroy');
            Route::get('/review/{id}', 'CommentController@review')->name('comments.review');
            Route::get('/activate/{id}', 'CommentController@activate')->name('comments.activate');
            Route::get('/deactivate/{id}', 'CommentController@deactivate')->name('comments.deactivate');
        });

        Route::group(['prefix' => 'contact-us'], function(){
            Route::get('/', 'ContactUsController@index')->name('contactuses');
            Route::get('/all', 'ContactUsController@all')->name('contactuses.all');

            Route::get('/show/{id}', 'ContactUsController@show')->name('contactuses.show');

            Route::get('/destroy/{id}', 'ContactUsController@destroy')->name('contactuses.destroy');
            Route::get('/review/{id}', 'ContactUsController@review')->name('contactuses.review');
        });

        Route::group(['prefix' => 'breaking-news'], function(){
            Route::get('/', 'BreakingNewController@index')->name('breakingnews');
            Route::get('/create', 'BreakingNewController@create')->name('breakingnews.create');
            Route::post('/store', 'BreakingNewController@store')->name('breakingnews.store');
            Route::get('/edit/{id}', 'BreakingNewController@edit')->name('breakingnews.edit');
            Route::post('/update/{id}', 'BreakingNewController@update')->name('breakingnews.update');
            Route::get('/destroy/{id}', 'BreakingNewController@destroy')->name('breakingnews.destroy');
        });

        Route::group(['prefix' => 'referendum'], function(){
            Route::get('/', 'ReferendumController@index')->name('referendum');
            Route::get('/edit', 'ReferendumController@edit')->name('referendum.edit');
            Route::post('/update', 'ReferendumController@update')->name('referendum.update');
            Route::get('/reset', 'ReferendumController@reset')->name('referendum.reset');
            Route::get('/activate', 'ReferendumController@activate')->name('referendum.activate');
            Route::get('/deactivate', 'ReferendumController@deactivate')->name('referendum.deactivate');
            Route::group(['prefix' => 'choices'], function(){
                Route::get('/', 'ReferendumAnswerController@index')->name('referendum.choices');
                Route::get('/create', 'ReferendumAnswerController@create')->name('referendum.choices.create');
                Route::post('/store', 'ReferendumAnswerController@store')->name('referendum.choices.store');
                Route::get('/destroy/{id}', 'ReferendumAnswerController@destroy')->name('referendum.choices.destroy');
            });
        });

        Route::group(['prefix' => 'banners'], function(){
            Route::get('/', 'BannerController@index')->name('banners');
            Route::get('/create', 'BannerController@create')->name('banners.create');
            Route::post('/store', 'BannerController@store')->name('banners.store');
            Route::get('/edit/{id}', 'BannerController@edit')->name('banners.edit');
            Route::post('/update/{id}', 'BannerController@update')->name('banners.update');
            Route::get('/destroy/{id}', 'BannerController@destroy')->name('banners.destroy');
        });

        Route::group(['prefix' => 'social-links'], function(){
            Route::get('/', 'SocialLinkController@index')->name('sociallinks');
            Route::get('/create', 'SocialLinkController@create')->name('sociallinks.create');
            Route::post('/store', 'SocialLinkController@store')->name('sociallinks.store');
            Route::get('/edit/{id}', 'SocialLinkController@edit')->name('sociallinks.edit');
            Route::post('/update/{id}', 'SocialLinkController@update')->name('sociallinks.update');
            Route::get('/destroy/{id}', 'SocialLinkController@destroy')->name('sociallinks.destroy');
        });

        Route::group(['prefix' => 'writers'], function(){
            Route::get('/', 'AdminController@index')->name('writers');
            Route::get('/create', 'AdminController@create')->name('writers.create');
            Route::post('/store', 'AdminController@store')->name('writers.store');
            Route::get('/edit/{id}', 'AdminController@edit')->name('writers.edit');
            Route::post('/update/{id}', 'AdminController@update')->name('writers.update');
            Route::get('/destroy/{id}', 'AdminController@destroy')->name('writers.destroy');
        });

        Route::group(['prefix' => 'users'], function(){
            Route::get('/', 'UserController@index')->name('users');
            Route::get('/create', 'UserController@create')->name('users.create');
            Route::post('/store', 'UserController@store')->name('users.store');
            Route::get('/edit/{id}', 'UserController@edit')->name('users.edit');
            Route::post('/update/{id}', 'UserController@update')->name('users.update');
            Route::get('/destroy/{id}', 'UserController@destroy')->name('users.destroy');
        });

        Route::group(['prefix' => 'settings'], function(){
            Route::get('/', 'SettingController@index')->name('settings');

            Route::get('/edit', 'SettingController@edit')->name('settings.edit');
            Route::post('/update', 'SettingController@update')->name('settings.update');

            Route::get('/social-in-header/activate', 'SettingController@socialInHeaderActivate')->name('socialInHeader.activate');
            Route::get('/social-in-header/deactivate', 'SettingController@socialInHeaderDeactivate')->name('socialInHeader.deactivate');

            Route::get('/social-in-footer/activate', 'SettingController@socialInFooterActivate')->name('socialInFooter.activate');
            Route::get('/social-in-footer/deactivate', 'SettingController@socialInFooterDeactivate')->name('socialInFooter.deactivate');

            Route::get('/slider/activate', 'SettingController@sliderActivate')->name('slider.activate');
            Route::get('/slider/deactivate', 'SettingController@sliderDeactivate')->name('slider.deactivate');

            Route::get('/random-banners/activate', 'SettingController@randomBannersActivate')->name('randomBanners.activate');
            Route::get('/random-banners/deactivate', 'SettingController@randomBannersDeactivate')->name('randomBanners.deactivate');
        });
    });
});

Auth::routes();
Route::get('/', 'IndexController@index')->name('index');
Route::post('/search', 'IndexController@search')->name('search');
Route::get('/news/{slug}', 'IndexController@showNews')->name('show.news');
Route::get('/essays', 'IndexController@showEssays')->name('show.essays');
Route::get('/essays/{slug}', 'IndexController@showEssay')->name('show.essay');
Route::get('/category/{slug}', 'IndexController@showCategory')->name('show.category');
Route::get('/page/{slug}', 'IndexController@showPage')->name('show.page');
Route::get('/contact-us', 'IndexController@createContactUs')->name('contactuses.create');
Route::get('/altahrir', 'IndexController@showstuff')->name('show.altahrir');
Route::post('/contact-us/store', 'ContactUsController@store')->name('contactuses.store');
Route::get('/writer/{id}', 'IndexController@showWriter')->name('show.writer');
Route::post('/comments/store', 'CommentController@store')->name('comments.store');
Route::group(['middleware' => 'auth'], function () {
    
    Route::post('/referendum-votes/store', 'ReferendumVotesController@store')->name('referendumvotes.store');
});

