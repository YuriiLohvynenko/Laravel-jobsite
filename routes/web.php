<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'Front', 'middleware' => 'web'], function () {
    Route::get('/', ['as' => 'front.home', 'uses' => 'HomeController@index']);
	Route::post('Home.savefilter', ['as' => 'Home.savefilter', 'uses' => 'HomeController@savefilter']);
    Route::get('search/{catid?}/{key?}', ['as' => 'front.search', 'uses' => 'HomeController@search']);
    Route::get('/contact', ['as' => 'front.contact', 'uses' => 'ContactController@index']);
    Route::post('/contact-store', ['as' => 'front.contact.store', 'uses' => 'ContactController@save']);
    Route::get('/privacy-policy', ['as' => 'front.privacy-policy', 'uses' => 'HomeController@privacy']);
    Route::get('/terms-of-use', ['as' => 'front.terms-of-use', 'uses' => 'ContactController@index']);
    Route::resource('/list', 'ListingController', ['as' => 'listing']);
    Route::resource('/profile', 'UserController', ['as' => 'user']);
    Route::post('list-offer', ['uses' => 'ListingController@storeOffer', 'as' => 'list.offer']);
    Route::post('list-counter-offer', ['uses' => 'ListingController@counterOffer', 'as' => 'list.count-offer']);
    Route::post('user.listing.store', ['uses' => 'ListingController@store', 'as' => 'user.listing.store']);
    Route::get('listings/create/{catid?}/{key?}', ['as' => 'front.listing.create', 'uses' => 'ListingController@create']);
    Route::get('/list-bookmark/{listingID}', ['as' => 'list.bookmark', 'uses' => 'ListingController@changeBookmark']);
    Route::get('/profile-bookmark/{userID}', ['as' => 'profile.bookmark', 'uses' => 'UserController@changeBookmark']);
    Route::post('/profile-invite/', ['as' => 'profile.invite', 'uses' => 'UserController@invite']);

    Route::post('/listings-login', ['as' => 'listings.login', 'uses' => 'ListingController@ajaxLogin']);
    Route::post('/listings-register', ['as' => 'listings.register', 'uses' => 'ListingController@register']);
});

Route::group(['namespace' => 'Auth\User', 'middleware' => 'web'], function () {
    Route::get('/login', ['as' => 'user.login', 'uses' => 'LoginController@index']);
    Route::get('/logout', ['as' => 'user.logout', 'uses' => 'LoginController@logout']);

    // Forget password region
    Route::get('forget-password', ['as' => 'user.get-reset', 'uses' => 'LoginController@getReset']);
    Route::post('forget-password', ['as' => 'user.post-reset', 'uses' => 'LoginController@postReset']);
    Route::get('password/reset/{token}', ['as' => 'user.get-password-reset', 'uses' => 'LoginController@getPasswordReset']);
    Route::post('password/reset', ['as' => 'user.post-password-reset', 'uses' => 'LoginController@postPasswordReset']);
    //endregion

    // Email verification region
    Route::get('user/email-verification/{code}', ['as' => 'user.get-email-verification', 'uses' => 'LoginController@getEmailVerification']);
    //endregion

    // User and volunteer login register
    Route::get('/login', ['as' => 'user.login', 'uses' => 'LoginController@index']);
    Route::post('/login', ['as' => 'user.login_check', 'uses' => 'LoginController@ajaxLogin']);
    Route::post('register', ['as' => 'post-register', 'uses' => 'LoginController@postRegister']);
    //endregion

    // Social Auth
    Route::get('/redirect/{provider}', ['uses' => 'LoginController@redirect', 'as' => 'social.login']);
    Route::get('/callback/{provider}', ['uses' => 'LoginController@callback']);

});


//region admin login routes
Route::group(['namespace' => 'Auth\Admin', 'middleware' => 'web', 'prefix' => 'admin'], function () {
    Route::get('/login', ['as' => 'admin.login', 'uses' => 'LoginController@index']);
    Route::get('/logout', ['as' => 'admin.logout', 'uses' => 'LoginController@logout']);
    Route::post('/login', ['as' => 'admin.login_check', 'uses' => 'LoginController@ajaxLogin']);

});
//endregion
Route::group(['namespace' => 'User', 'middleware' => ['auth.user', 'web'], 'prefix' => ''], function () {
    //region Dashboard Routes
    Route::resource('/dashboard', 'DashBoardController', ['as' => 'user']);
    //endregion
    Route::get('/listings-by-month', 'DashBoardController@listingsByMonth')->name('listings.byMonth');

    //region Dashboard Routes
    Route::resource('/dashboard-setting', 'DashBoardSettingController', ['as' => 'setting']);
    //endregion

    //region listing Routes
    Route::resource('/listing', 'ListingController', ['as' => 'user']);
    Route::any('listing-upload-files', ['uses' => 'ListingController@uploadFiles', 'as' => 'listing.file-upload']);
    Route::get('listing-view-offer/{id}', ['uses' => 'ListingController@viewOffer', 'as' => 'listing.view-offer']);
    Route::get('listing-offer-detail/{listing}/{user}', ['uses' => 'ListingController@offerDetail', 'as' => 'listing.offer-detail']);
    Route::get('listing-offer-accept/{offer}', ['uses' => 'ListingController@acceptOffer', 'as' => 'listing.accept-offer']);
    Route::get('listing-decline-accept/{offer}', ['uses' => 'ListingController@declineOffer', 'as' => 'listing.decline-offer']);
    Route::any('listing-delete/{listing}', ['uses' => 'ListingController@deleteListing', 'as' => 'listing.delete-listing']);
	Route::any('listing.destroy/{listing}', ['uses' => 'ListingController@destroy', 'as' => 'listing.destroy']);
    Route::get('listing-increase-budget/{listing}', ['uses' => 'ListingController@increaseBudget', 'as' => 'listing.increase-budget']);
    Route::get('listing-repost-listing/{listing}', ['uses' => 'ListingController@repostListing', 'as' => 'listing.repost-listing']);
    Route::get('listing-release-payment/{budget}', ['uses' => 'ListingController@releasePayment', 'as' => 'listing.release-payment']);
    Route::get('listing-show-release-payment/{budget}', ['uses' => 'ListingController@showReleasePayment', 'as' => 'listing.show-release-payment']);
    Route::post('listing-update-budget', ['uses' => 'ListingController@UpdateBudget', 'as' => 'listing.update-budget']);
    Route::get('listing-job-detail/{listing}', ['uses' => 'ListingController@jobDetail', 'as' => 'listing.job-detail']);
    Route::get('listing-assigned-job-detail/{listing}', ['uses' => 'ListingController@assignedJobDetail', 'as' => 'listing.assigned-job-detail']);
    Route::get('listing-open-dispute/{listing}', ['uses' => 'ListingController@openDispute', 'as' => 'listing.open-dispute']);
    Route::get('listing-show-dispute/{listing}', ['uses' => 'ListingController@showDispute', 'as' => 'listing.show-dispute']);
	Route::post('listing.dispute-mail', ['uses' => 'ListingController@disputemail', 'as' => 'listing.dispute-mail']);
    Route::get('listing-open-bid-dispute/{listing}', ['uses' => 'ListingController@openBidDispute', 'as' => 'listing.open-bid-dispute']);
    Route::get('listing-show-bid-dispute/{listing}', ['uses' => 'ListingController@showBidDispute', 'as' => 'listing.show-bid-dispute']);
    Route::get('listing-show-invoice/{listing}', ['uses' => 'ListingController@showInvoice', 'as' => 'listing.show-invoice']);
    Route::post('listing-submit-comment', ['uses' => 'ListingController@storeComment', 'as' => 'listing.submit-comment']);
    Route::post('listing-submit-bid-comment', ['uses' => 'ListingController@storeBidComment', 'as' => 'listing.submit-bid-comment']);
    Route::get('listing-show-tip/{listing}', ['uses' => 'ListingController@showTip', 'as' => 'listing.show-tip']);
    Route::get('listing-leave-review/{listing}', ['uses' => 'ListingController@leaveReview', 'as' => 'listing.leave-review']);
    Route::get('listing-leave-complete-review/{listing}', ['uses' => 'ListingController@leaveCompleteReview', 'as' => 'listing.leave-complete-review']);
    Route::get('listing-show-review/{listing}', ['uses' => 'ListingController@showReview', 'as' => 'listing.show-review']);
    Route::get('listing-show-complete-review/{listing}', ['uses' => 'ListingController@showCompleteReview', 'as' => 'listing.show-complete-review']);
    Route::get('listing-update-offer/{listing}', ['uses' => 'ListingController@updateOffer', 'as' => 'listing.update-offer']);
    Route::get('listing-counter-offer/{listing}', ['uses' => 'ListingController@counterOffer', 'as' => 'listing.counter-offer']);
    Route::get('listing-start-shift/{listing}', ['uses' => 'ListingController@startShift', 'as' => 'listing.start-shift']);
    Route::get('listing-change-shift/{listing}/{type}', ['uses' => 'ListingController@changeShift', 'as' => 'listing.change-shift']);
    Route::get('listing-view-bid-job/{listing}', ['uses' => 'ListingController@showBidJob', 'as' => 'listing.view-bid-job']);
    Route::get('listing-view-complete-job/{listing}', ['uses' => 'ListingController@showCompleteJob', 'as' => 'listing.view-complete-job']);
    Route::get('listing-copy/{listing}', ['uses' => 'ListingController@copyListing', 'as' => 'listing.copy']);
    Route::get('listing-withdraw-offer/{listing}', ['uses' => 'ListingController@withdrawOffer', 'as' => 'listing.withdraw-offer']);
    Route::post('listing-submit-copy', ['uses' => 'ListingController@copyListingSubmit', 'as' => 'listing.copy-submit']);
    Route::post('listing-submit-shift', ['uses' => 'ListingController@submitshift', 'as' => 'listing.submit-shift']);
    Route::post('listing-submit-offer', ['uses' => 'ListingController@submitOffer', 'as' => 'listing.submit-offer']);
    Route::post('listing-submit-review', ['uses' => 'ListingController@submitReview', 'as' => 'listing.submit-review']);
    Route::post('listing-submit-complete-review', ['uses' => 'ListingController@submitCompleteReview', 'as' => 'listing.submit-complete-review']);
    Route::post('listing-send-tip', ['uses' => 'ListingController@sendTip', 'as' => 'listing.send-tip']);
    Route::post('listing-dispute-store', ['uses' => 'ListingController@storeDispute', 'as' => 'listing.dispute-store']);
    Route::post('listing-dispute-bid-store', ['uses' => 'ListingController@storeBidDispute', 'as' => 'listing.dispute-bid-store']);
    //endregion

    //region bookmark Routes
    Route::resource('/bookmark', 'BookmarkController', ['as' => 'user']);
    //endregion

    //region notification Routes
    Route::post('/notications/mark-as-read/{notification_id}', 'NotificationController@markAsRead')->name('notifications.markAsRead');
    //endregion

    //region badges Routes
    Route::get('open-badge-popup', ['uses' => 'BadgesController@getBadges', 'as' => 'user.get-badges']);
    Route::post('user/submit-badges', ['uses' => 'BadgesController@submitBadges', 'as' => 'user.submit-badges']);
    Route::post('user/submit-licensed-badges', ['uses' => 'BadgesController@submitLicensedBadges', 'as' => 'user.submit-licensed-badges']);
    Route::resource('/badges', 'BadgesController', ['as' => 'user']);
    //endregion

    //region bookmark Routes
    Route::get('/review-model-view/{id?}/{type?}', ['uses' => 'ReviewController@modelView', 'as' => 'user.review.model-view']);
    Route::resource('/review', 'ReviewController', ['as' => 'user']);
    //endregion

    //region track live jobs Routes
    Route::resource('/track-job', 'TrackJobController', ['as' => 'user']);
    //endregion

    //region track live jobs Routes
    Route::post('/text-alert', ['uses' => 'TextAlertController@store', 'as' => 'user.text-alert.store']);
    Route::post('/text-alert-delete', ['uses' => 'TextAlertController@delete', 'as' => 'user.text-alert.delete']);
    //endregion

    //region track live jobs Routes
    Route::resource('/message', 'MessageController', ['as' => 'user']);
    Route::get('/message/get-message/{id}', ['uses' => 'MessageController@getMessages', 'as' => 'user.message.get-message']);
    Route::get('/message/accept-offer/{id}/{userId}/{messageId}', ['uses' => 'MessageController@acceptOffer', 'as' => 'user.message.acceptOffer']);
    Route::get('/message/decline-offer/{id}/{userId}/{messageId}', ['uses' => 'MessageController@declineOffer', 'as' => 'user.message.declineOffer']);
    Route::get('/message/message-search/{term?}', ['uses' => 'MessageController@messageSearch', 'as' => 'user.message.messageSearch']);
    Route::get('/message/read-all-unread/{id}', ['uses' => 'MessageController@readAllUnread', 'as' => 'user.message.readAllUnread']);
    Route::get('/message/accept-dispute/{id}', ['uses' => 'MessageController@acceptDispute', 'as' => 'user.message.accept-dispute']);
    Route::get('/message/decline-dispute/{id}', ['uses' => 'MessageController@declineDispute', 'as' => 'user.message.decline-dispute']);
    Route::get('/message/get-message-popup/{toUserId}/{listingId}', ['uses' => 'MessageController@messagePopup', 'as' => 'user.message.get-message-popup']);
    //endregion
//    Route::get('/update-status/{status}', ['uses' => 'UserController@updateStatus', 'as' => 'user.update-status']);
    Route::get('/update-status/{status}', ['as' => 'user.message.update-status', 'uses' => 'MessageController@updateStatus']);

});


Route::group(['namespace' => 'Admin', 'middleware' => ['auth.admin', 'web'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    //region Dashboard Routes
    Route::resource('/dashboard', 'DashBoardController');

    //region Dashboard Routes
    Route::resource('/dashboard-setting', 'DashBoardSettingController');
    Route::get('/reviews/contact-user/{clientId}/{freelancerId}', ['as' => 'reviews.contact-user', 'uses' => 'DashBoardReviewsController@contactUser']);
    Route::get('/reviews/send-message/{id}', ['as' => 'reviews.send-message', 'uses' => 'DashBoardReviewsController@sendMessage']);
    Route::get('/reviews/delete-feedback/{listingId}', ['as' => 'reviews.delete-feedback', 'uses' => 'DashBoardReviewsController@deleteFeedback']);
    Route::get('/reviews/delete-review/{listingId}/{type}', ['as' => 'reviews.delete-review', 'uses' => 'DashBoardReviewsController@deleteReview']);
    Route::resource('/reviews', 'DashBoardReviewsController');
    //endregion

    //region badges Routes
    Route::get('/verify', ['as' => 'badges.verify', 'uses' => 'BadgesController@getVerify']);
    Route::get('/badge-detail', ['as' => 'badges.detail', 'uses' => 'BadgesController@badgeDetail']);
    Route::get('/badge-confirmation', ['as' => 'badges.confirmation', 'uses' => 'BadgesController@getConfirmation']);
    Route::post('/badge-approve', ['as' => 'badges.approve', 'uses' => 'BadgesController@approve']);
    Route::post('/badge-remove', ['as' => 'badges.remove', 'uses' => 'BadgesController@remove']);
    Route::post('/badge-reject', ['as' => 'badges.reject', 'uses' => 'BadgesController@reject']);
    Route::get('/badge/contact-user/{id}', ['as' => 'badge.contact-user', 'uses' => 'BadgesController@contactUser']);
    Route::get('/badge/send-message/{id}', ['as' => 'badge.send-message', 'uses' => 'BadgesController@sendMessage']);
    Route::resource('/badges', 'BadgesController');
    //endregion

    // region messages Routes
    Route::resource('/messages', 'MessageController');
    Route::get('/messages/read-all-unread/{id}', ['uses' => 'MessageController@readAllUnread', 'as' => 'messages.readAllUnread']);
    Route::get('/messages/show-thread/{id}', ['as' => 'messages.showThread', 'uses' => 'MessageController@showThread']);
    Route::get('/messages/change-status/{status}/{id}', ['as' => 'messages.changeStatus', 'uses' => 'MessageController@changeStatus']);
    Route::get('/messages/send-message/{id}', ['as' => 'messages.send-message', 'uses' => 'MessageController@sendMessage']);
    // endregion

    // region dispute Routes
    Route::resource('/dispute', 'DisputeController');
    Route::get('/dispute/read-all-unread/{id}', ['uses' => 'DisputeController@readAllUnread', 'as' => 'dispute.readAllUnread']);
    Route::get('/dispute/show-thread/{id}', ['as' => 'dispute.showThread', 'uses' => 'DisputeController@showThread']);
    Route::get('/dispute/change-status/{status}/{id}', ['as' => 'dispute.changeStatus', 'uses' => 'DisputeController@changeStatus']);
    Route::get('/dispute/send-message/{id}', ['as' => 'dispute.send-message', 'uses' => 'DisputeController@sendMessage']);
    // endregion

    //region users routes
    Route::get('users/data', ['as' => 'users.data', 'uses' => 'UsersController@data']);
    Route::get('users/badge/confirmation', ['as' => 'users.badge.confirmation', 'uses' => 'UsersController@getConfirmation']);
    Route::post('users/information', ['as' => 'users.information', 'uses' => 'UsersController@information']);
    Route::post('users/change-status', ['as' => 'users.change-status', 'uses' => 'UsersController@changeStatus']);
    Route::get('/users/contact-user/{id}', ['as' => 'users.contact-user', 'uses' => 'UsersController@contactUser']);
    Route::get('/users/send-message/{id}', ['as' => 'users.send-message', 'uses' => 'UsersController@sendMessage']);
    Route::resource('/users', 'UsersController');
    //endregion

    //region users routes
//    Route::get('users/data', ['as' => 'users.data', 'uses' => 'UsersController@data']);
//    Route::get('users/badge/confirmation', ['as' => 'users.badge.confirmation', 'uses' => 'UsersController@getConfirmation']);
    Route::post('jobs/information', ['as' => 'jobs.information', 'uses' => 'ListingController@information']);
//    Route::post('users/change-status', ['as' => 'users.change-status', 'uses' => 'UsersController@changeStatus']);
    Route::get('/jobs/contact-user/{id}', ['as' => 'jobs.contact-user', 'uses' => 'UsersController@contactUser']);
//    Route::get('/users/send-message/{id}', ['as' => 'users.send-message', 'uses' => 'UsersController@sendMessage']);
    Route::resource('/jobs', 'ListingController');
    //endregion
});

Route::get('console-cmd', function () {
    Artisan::call('key:generate');
});