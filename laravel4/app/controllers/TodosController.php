<?php


/**
 *
 */
class TodosController extends BaseController
{

  function __construct()
  {
    $this->beforeFilter(
      '@existsFilter',
      ['on' => ['post', 'put']]
    );
  }

  public function existsFilter()
	{
		Log::info(__METHOD__.' called.');
		// URLにパラメータ'id'が存在したら
		$id = Route::input('id');
		if ($id) {
			Log::debug("todo id(${id}) checking...");
			// 指定のIDがtodosテーブルに存在しなかったら
			if (! Todo::exists($id)) {
				Log::debug('Nothing!');
				// Webブラウザに404 Not Foundを返す
				App::abort(404);
			}
			Log::debug('Exists!');
		}
		else {
			Log::debug('url was not contained $id.');
		}
	}

  public function index()
  {
    $query = Todo::query()->select('*')->where('status', '=', Todo::STATUS_INCOMPLETE)->orderBy('updated_at', 'desc');
    $incompleteTodos = $query->get();

    $completeTodos = Todo::whereStaus(Todo::STATUS_COMPLETE)->orderBy('updated_at', 'desc')->get();

    $trashedTodos = Todo::onlyTrashed()->get();

    return View::make('pages.todos.index', compact('incompleteTodos', 'completeTodos', 'trashedTodos'));
  }

  public function store()
  {
    $rules = ['title' => 'required|min:3|max:255',];

    $input = Input::only(['title']);

    $validator = Validator::make($input, $rules);

    if ($validator->fails()) {
      return Redirect::route('todos.index')->withErrors($validator)->withInput();
    }

    $todo = Todo::create([
        'title' => $input['title'],
        'status'=> Todo::STATUS_INCOMPLETE,
    ]);

    return Redirect::route('todos.index');
  }

  public function update($id)
  {
    // Todoモデルを取得する
    $todo = Todo::find($id);
    // バリデーションルールの定義
    // MEMO 文字列でルールを'|'で区切ることで複数指定できる。
    // MEMO 配列でルールを複数指定することもできる。
    $rules = [
      'title' => 'required|min:3|max:255',
      'status' => ['required', 'numeric', 'min:1', 'max:2'],
      'dummy' => '',	// ルールを指定しないとオプション扱いにできる
    ];
    // 入力データを取得する
    // MEMO $inputの内容をログに出力して確認してみる。dummyキーはあるが値は空(null)になっている。
    $input = Input::only(array_keys($rules));
    Log::debug(print_r($input, true));
    // バリデーションを実行する
    $validator = Validator::make($input, $rules);
    if ($validator->fails()) {
      return Redirect::route('todos.index')->withErrors($validator)->withInput();
    }
    // titleが指定されていたら
    if ($input['title'] !== null) {
      // titleカラムを更新する
      $todo->fill([
        'title' => $input['title'],
      ]);
    }
    // statusが指定されていたら
    if ($input['status'] !== null) {
      // statusとcompleted_atカラムを更新する
      $todo->fill([
        'status' => $input['status'],
        'completed_at' => $input['status'] == Todo::STATUS_COMPLETE ? new DateTime : null,
      ]);
    }
    // データを更新する（SQL発行）
    $todo->save();
    // リストページにリダイレクトする
    return Redirect::route('todos.index');
  }
  /**
   * タイトルを更新する。
   *
   * @param  integer  $id  TodoのID
   * @return void
   */
  public function ajaxUpdateTitle($id)
  {
    // Todoモデルを取得する
    $todo = Todo::find($id);
    // バリデーションルールの定義
    $rules = [
      'title' => 'required|min:3|max:255',
    ];
    // 入力データを取得する
    $input = Input::only(['title']);
    // バリデーションを実行する
    $validator = Validator::make($input, $rules);
    if ($validator->fails()) {
      // Ajaxレスポンスを返す
      return Response::json(['result' => 'NG', 'errors' => $validator->errors()], 400);
    }
    // titleカラムを更新する
    $todo->fill([
      'title' => $input['title'],
    ]);
    // データを更新する（SQL発行）
    $todo->save();
    // Ajaxレスポンスを返す
    return Response::json(['result' => 'OK'], 200);
  }
  /**
   * Todoを削除する。
   *
   * @param  integer  $id  TodoのID
   * @return void
   */
  public function delete($id)
  {
    // Todoモデルを取得する
    $todo = Todo::find($id);
    // データを削除する（SQL発行）
    $todo->delete();
    // リストページにリダイレクトする
    return Redirect::route('todos.index');
  }
  public function restore($id)
  {
    // 削除されたTodoモデルを取得する
    $todo = Todo::onlyTrashed()->find($id);
    // データを復元する（SQL発行）
    $todo->restore();
    // リストページにリダイレクトする
    return Redirect::route('todos.index');
  }
}
