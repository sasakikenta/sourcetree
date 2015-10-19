<?php

/*
|--------------------------------------------------------------------------
| アプリケーションルート
|--------------------------------------------------------------------------
|
| このファイルでアプリケーションの全ルートを定義します。
| 方法は簡単です。対応するURIをLaravelに指定してください。
| そしてそのURIに対応する実行コードをクロージャーで指定します。
|
*/
Route::group(['prefix' => 'todos'], function(){

	Route::get('', [
		'as' => 'todos.index',
		'uses' => 'TodosController@index',
		]);

		Route::post('', [
	'as' => 'todos.store',
	'uses' => 'TodosController@store',
]);
Route::post('{id}/update', [
	'as' => 'todos.update',
	'uses' => 'TodosController@update',
	// MEMO ルート単位のフィルタは’before', 'after'で指定する。
	// MEMO filter.php内の'todos.exists'フィルタ定義を有効にすること。
//		'before' => 'todos.exists',
]);
Route::put('{id}/title', [
	'as' => 'todos.update-title',
	'uses' => 'TodosController@ajaxUpdateTitle',
//		'before' => 'todos.exists',
]);
Route::post('{id}/delete', [
	'as' => 'todos.delete',
	'uses' => 'TodosController@delete',
//		'before' => 'todos.exists',
]);
Route::post('{id}/restore', [
	'as' => 'todos.restore',
	'uses' => 'TodosController@restore',
//		'before' => 'todos.exists',
]);

});

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/magic', function()
{
	Log::info('例1-1:テキストを返す');
	return "マジカルlaravel";
});
Route::get('/user/sasaki', function()
{
	return "sasaki world";
});
Route::get('/user/{name?}', function()
{
	return "こんにちわ world";
})
->where('name', '[0-9]+');
