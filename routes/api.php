<?php

use Illuminate\Http\Request;

Route::get('/leaderboard/all', 'Home\HomeController@leaderboardAPI');
Route::get('/leaderboard/tournament', 'Home\HomeController@leaderboardAPI');

Route::group([
		'prefix' 	=> 'auth', 
		'as' 		=> 'auth.', 
		'namespace' => 'Authenticate'
	], function(){
		Route::get('verifikasi', 'AuthController@verifikasi');
		Route::get('auth', 'AuthController@index');
		Route::post('auth', 'AuthController@index');
		Route::post('game', 'GameController@index');
});

# Library (VueJS)
Route::group(
	['middleware' => 
		['buster','auth:api']
	], function(){       

});
Route::group([
	'prefix' 	=> 'library', 
	'as' 		=> 'library.', 
	'namespace' => 'Library'
], function(){
	Route::resource('achievement', 'AchievementController');
	Route::resource('help', 'HelpController');
	Route::resource('intro', 'IntroController');
	Route::resource('limit', 'LimitController');
	Route::resource('tournament', 'TournamentController');
	Route::resource('mission', 'MissionController');
	Route::resource('purchase', 'PurchaseController');
	Route::resource('tools', 'ToolsController');
	Route::resource('vehicle', 'VehicleController');
	Route::resource('withdraw', 'WithdrawController');
});
# (VueJS)
Route::group(
	['middleware' => 
		['auth:api','sentry']
	], function(){       
		Route::group(['prefix' => 'mutation', 'as' => 'mutation.', 'namespace' => 'Mutation'], function(){
			Route::group(['prefix' => 'record', 'as' => 'record.', 'namespace' => 'Record'], function(){
				Route::resource('achievement/active', 'AchievementController');
				Route::resource('game/active', 'GameController');
				Route::resource('mission/active', 'MissionController');
				Route::resource('purchase/active', 'PurchaseController');
				Route::resource('withdraw/active', 'WithdrawController');
				Route::resource('tools/active', 'ToolsController');
				Route::resource('vehicle/active', 'VehicleController');
			});

			Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function(){
				Route::resource('wallet/active', 'WalletController');
				Route::resource('summary/active', 'SummaryController');
			});  			
		});
		Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'Library'], function(){
			Route::resource('user', 'UserController');
		});
});

# Mutation (VueJS)
Route::group(
	['middleware' => 
		['buster','auth:api','sentry']
		//['auth:api,scope:player,admin']
	], 
	function(){      
	Route::group(['prefix' => 'mutation', 'as' => 'mutation.', 'namespace' => 'Mutation'], function(){
		Route::group(['prefix' => 'record', 'as' => 'record.', 'namespace' => 'Record'], function(){
			Route::resource('achievement', 'AchievementController');
			Route::resource('game', 'GameController');
			Route::resource('mission', 'MissionController');
			Route::resource('purchase', 'PurchaseController');
			Route::resource('withdraw', 'WithdrawController');
			Route::resource('tools', 'ToolsController');
			Route::resource('vehicle', 'VehicleController');
		});

		Route::group(['prefix' => 'reference', 'as' => 'reference.', 'namespace' => 'Reference'], function(){
			Route::resource('intro', 'IntroController');
		});    

		Route::group(['prefix' => 'result', 'as' => 'result.', 'namespace' => 'Result'], function(){
			Route::resource('wallet', 'WalletController');
			Route::resource('summary', 'SummaryController');
			Route::get('reset-tournament', 'WalletController@resetTournament');
		});    

		Route::group(['prefix' => 'resume', 'as' => 'resume.', 'namespace' => 'Resume'], function(){
			Route::get('/{query?}', 'ResumeController@index');
			Route::get('/show/{id?}', 'ResumeController@show');
		});    
	});
});	

# Game
Route::group(
	['middleware' => 
		['buster','auth:api','sentry']
	], function(){       
		Route::group(['prefix' => 'game', 'as' => 'game.', 'namespace' => 'Mutation\Game'], function(){
		
			Route::resource('history', 'HistoryController', ['only' => ['index','show']]);
			Route::resource('availability', 'AvailabilityController', ['only' => ['index']]);
			Route::resource('dashboard', 'AvailabilityController', ['only' => ['index']]);
			Route::resource('entry', 'EntryController', ['only' => ['index','store']]);	  
			
		});  			
});
