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
*//*
Route::get('/', function()
{
	return View::make('hello');
});*/


Route::get('/', function()
{
	return "hello world";
});
Route::get('/magic', function()
{
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
