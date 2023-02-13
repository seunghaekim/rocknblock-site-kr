<?php

/**
 * Register CMS routes before all user routes.
 */
App::before(function ($request) {

    /**
     * @event cms.beforeRoute
     * Fires before cms routes get added
     *
     * Example usage:
     *
     *     Event::listen('cms.beforeRoute', function () {
     *         // your code here
     *     });
     *
     */
    Event::fire('cms.beforeRoute');
	
	Route::get('naver69961024092b3928adeacef5a96fcac0.html', function () {
		return File::get(public_path('public/naver69961024092b3928adeacef5a96fcac0.html'));
	});
	
	Route::get('robots.txt', function () {
		return File::get(public_path('public/robots.txt'));
	});

    /*
     * The CMS module intercepts all URLs that were not
     * handled by the back-end modules.
     */
    Route::any('{slug?}', 'Cms\Classes\CmsController@run')->where('slug', '(.*)?')->middleware('web');

    /**
     * @event cms.route
     * Fires after cms routes get added
     *
     * Example usage:
     *
     *     Event::listen('cms.route', function () {
     *         // your code here
     *     });
     *
     */
    Event::fire('cms.route');
});
