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
 * Add A New Task
 */
Route::post('/task/{id}', function (Request $request, $id) {
    
    $task = Task::where('id','=',$id)->first();
    if(!empty($task)){
    	$name = $request->tasks_n;
    	$duedate = $request->tasks_dd;
    }
	else
	{
		$validator = Validator::make($request->all(), [
        'tasks_name' => 'required|max:255',

	    ]);
	    if ($validator->fails()) {
	        return redirect('/')
	            ->withInput()
	            ->withErrors($validator);
	    } 
		$task = new Task;
		$user = auth()->user();
		$task->user_id = $user->id;
		$name = $request->tasks_name;
    	$duedate = $request->tasks_duedate;
	}
    
	$task->tasks_name = $name;
    $task->tasks_duedate = $duedate;
    $task->save();

    return redirect('/home');

});


/**
 * Delete An Existing Task
 */
Route::delete('/task/{id}', function ($id) {
	 // Task::findOrFail($id)->delete();
	 $task = Task::where('id','=',$id)->first();
	 $task->tasks_status = 'DELETED';
	 $task->save();
    return redirect('/home');
});


Auth::routes();

Route::get('/', function () {
    return redirect('/home');
});


Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home/search', 'HomeController@search');
Route::get('/home/filter/{type}', 'HomeController@filter');
