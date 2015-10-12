<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
App::error(function(ModelNotFoundException $e)
{
    return Response::make('Not Found', 404);
});

App::missing(function($exception)
{
    return Response::view('404', array(), 404);
});

HTML::macro('clever_link', function($route) 
{
    if(Request::is($route . '/*') OR Request::is($route))
    {
        $active = "active";
    }
    
    else 
    {
        $active = '';
    }
     
    return $active;
});

Route::any("/logout", [
  "as"   => "user/logout",
  "uses" => "AuthController@logout"
]);
Route::get('login', array('as' => 'login', function () { 
     return Redirect::to('login');
}))->before('guest');
Route::post('login', 'AuthController@login');
Route::get('login', 'AuthController@login');

Route::get('users', 'UsersController@index')->before('auth');
Route::get('/', 'HomeController@showWelcome')->before('auth');
Route::get('users/show', 'UsersController@show')->before('auth');
Route::get('users/create', 'UsersController@create')->before('auth');
Route::post('users/register', 'UsersController@register')->before('auth');
Route::post('users/save/{id}', 'UsersController@update')->before('auth');
Route::get('users/delete/{id}', 'UsersController@destroy')->before('auth');
Route::get('users/edit/{id}', 'UsersController@edit')->before('auth');
Route::get('users/lock/{id}', 'UsersController@lock')->before('auth');
Route::get('users/unlock/{id}', 'UsersController@unlock')->before('auth');
Route::get('pay', 'PayController@show')->before('auth');
Route::get('recruiter', 'RecruiterController@show')->before('auth');

Route::get('channels', 'ChannelsController@index')->before('auth');
Route::get('channels/status/{id}', 'ChannelsController@show')->before('auth');
Route::get('channels/create', 'ChannelsController@create')->before('auth');
Route::post('channels/register', 'ChannelsController@register')->before('auth');
Route::get('channels/create', 'ChannelsController@create')->before('auth');
Route::get('channels/edit/{id}', 'ChannelsController@edit')->before('auth');
Route::post('channels/update/{id}', 'ChannelsController@update')->before('auth');
Route::post('channels/generatestatus/{id}', 'ChannelsController@generatestatus')->before('auth');
Route::post('channels/generatestatus', 'ChannelsController@generatestatus')->before('auth');
Route::post('channels/send/{id}', 'ChannelsController@send')->before('auth');

Route::get('managed', 'ManagersController@index')->before('auth');
Route::get('chinfo', 'ChinfoController@index')->before('auth');
Route::get('mychannel', 'MychannelController@index')->before('auth');
Route::get('finance/channelspayments', 'FinanceController@channelspayments')->before('auth');
Route::get('finance/channelspayments/month/{month}/year/{year}', 'FinanceController@channelspayments')->before('auth');
Route::get('finance/csvchannels/month/{month}/year/{year}', 'FinanceController@csvchannels')->before('auth');
Route::get('finance/hubspayments', 'FinanceController@hubspayments')->before('auth');
Route::get('finance/csvhubs/month/{month}/year/{year}', 'FinanceController@csvhubs')->before('auth');
Route::get('finance/hubspayments/month/{month}/year/{year}', 'FinanceController@hubspayments')->before('auth');
Route::post('finance/bulk/{params1}/multiple/{month}/{year}', 'FinanceController@bulk')->before('auth');
Route::get('finance/finishhub/{id}/{month}/{year}/{value}', 'FinanceController@finishhub')->before('auth');
Route::get('finance/finish/{value}/{id}/{month}/{year}', 'FinanceController@finish')->before('auth');
Route::post('finance/insertvalue', 'FinanceController@insertvalue')->before('auth');
Route::get('finance/mcnearnings', 'FinanceController@mcnearnings')->before('auth');
Route::get('finance/mcnearnings/month/{month}/year/{year}', 'FinanceController@mcnearnings')->before('auth');
Route::get('finance/finishhub/month/{month}/year/{year}', 'FinanceController@mcnearnings')->before('auth');

Route::get('hubs', 'HubsController@index')->before('auth');
Route::get('hubs/create', 'HubsController@create')->before('auth');
Route::post('hubs/register', 'HubsController@register')->before('auth');
Route::get('hubs/edit/{id}', 'HubsController@edit')->before('auth');
Route::post('hubs/update/{id}', 'HubsController@update')->before('auth');
Route::get('hubs/csvemails/{id}', 'HubsController@csvemails')->before('auth');
Route::get('hubs/delete/{id}', 'HubsController@destroy')->before('auth');

Route::get('analytics', 'AnalyticsController@index')->before('auth');
Route::post('analytics/showGraphic/', 'AnalyticsController@showGraphic')->before('auth');
Route::get('analytics/showGraphic', 'AnalyticsController@showGraphic')->before('auth');
Route::post('analytics/getData', 'AnalyticsController@getData')->before('auth');
Route::get('stats', 'StatsController@index')->before('auth');
//homepartnerController
Route::get('homepartner', 'HomepartnerController@index')->before('auth');

//statuses
Route::get('statuses', 'StatusesController@show')->before('auth');
Route::get('statuses/create', 'StatusesController@create')->before('auth');
Route::post('statuses/register', 'StatusesController@register')->before('auth');
Route::get('statuses/edit/{id}', 'StatusesController@edit')->before('auth');
Route::post('statuses/save/{id}', 'StatusesController@update')->before('auth');
//musics
Route::get('audiomicro', 'AudiomicroController@show')->before('auth');

//menus
Route::get('menus', 'MenusController@show')->before('auth');
Route::get('menus/create', 'MenusController@create')->before('auth');
Route::post('menus/register', 'MenusController@register')->before('auth');
Route::get('menus/edit/{id}', 'MenusController@edit')->before('auth');
Route::post('menus/save/{id}', 'MenusController@update')->before('auth');
Route::get('menus/delete/{id}', 'MenusController@destroy')->before('auth');
//submenus
Route::get('submenus/create/{id}', 'SubmenusController@create')->before('auth');
Route::post('submenus/register/{id}', 'SubmenusController@register')->before('auth');
Route::get('submenus/edit/{id}', 'SubmenusController@edit')->before('auth');
Route::post('submenus/save/{id}', 'SubmenusController@update')->before('auth');
Route::get('submenus/delete/{id}', 'SubmenusController@destroy')->before('auth');

//roles
Route::get('roles', 'RolesController@show')->before('auth');
Route::get('roles/create', 'RolesController@create')->before('auth');
Route::post('roles/register', 'RolesController@register')->before('auth');
Route::get('roles/edit/{id}', 'RolesController@edit')->before('auth');
Route::post('roles/save/{id}', 'RolesController@update')->before('auth');
Route::get('roles/delete/{id}', 'RolesController@destroy')->before('auth');

//Form
Route::get('form/hub/{id}', 'FormController@show')->before('auth');
Route::get('form/hub//ref/{id}', 'FormController@show_user')->before('auth');
Route::post('form/send', 'FormController@send')->before('auth');
