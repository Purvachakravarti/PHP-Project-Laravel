<?php
use App\Task;
use Illuminate\Http\Request;
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


/**
 * Display All Tasks
 */
// Route::get('/', function () {
//     //Code
//      $tasks = Task::orderBy('created_at', 'asc')->get();

//     return view('tasks', [
//         'tasks' => $tasks
//     ]);
// });

/**
 * Add A New Task
 */
Route::post('/task', function (Request $request) {
    
    $validator = Validator::make($request->all(), [
        'tasks_name' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $user = auth()->user();

    $task = new Task;
    $task->tasks_name = $request->tasks_name;
    $task->user_id = $user->id;
    $task->tasks_duedate = $request->tasks_duedate;
    $task->save();

    return redirect('/home');

});

/**
 * Edit A New Task
 */
Route::post('/task/{id}', function ($id) {
    //
});

/**
 * Delete An Existing Task
 */
Route::delete('/task/{id}', function ($id) {
	 Task::findOrFail($id)->delete();

    return redirect('/home');
});

/**
 * Edit An Existing Task
 */



Auth::routes();

Route::get('/', function () {
    return redirect('/home');
});


Route::get('/home', 'HomeController@index')->name('home');
