<?php

class TestController extends BaseController
{
  public function index()
  {
    Log::debug('aaa');
    //Test::get();
    Test::query()->select('*')->get();

    return View::make('pages.test.index');
  }
}
