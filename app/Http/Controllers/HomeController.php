<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $tasks = Task::whereIn('tasks_status', array('ACTIVE','COMPLETED'))->where('user_id','=',$user->id)->orderBy('tasks_duedate', 'asc')->get();

        // return view('home');
        return view('home', [
            'tasks' => $tasks
        ]);
    }

    public function search(Request $r)
    {
     
        $q = $r->q;
        $user = auth()->user();
        
        $searchedtask = Task::where([['tasks_name', 'LIKE','%'.$q.'%'],['user_id','=',$user->id]])->get();
        if(count($searchedtask) > 0)
            return view('home',['tasks' => $searchedtask]);
        else return view ('home',['tasks' => array()])->withMessage('No Details found. Try to search again !');
       
    }

    public function filter($type)
    {

      $user = auth()->user();
        switch($type)
        {
            case 'All':
                 $searchedtask = Task::where('user_id','=',$user->id)->get();
                 break;
            case 'Completed':
                $searchedtask = Task::where([['tasks_status', '=','COMPLETED'],['user_id','=',$user->id]])->get();
                break;
            case 'Active':
                $searchedtask = Task::where([['tasks_status', '=','ACTIVE'],['user_id','=',$user->id]])->get();
                break;
            case 'Deleted':
                $searchedtask = Task::where([['tasks_status', '=','DELETED'],['user_id','=',$user->id]])->get();
                break;
            default:
                $searchedtask = Task::where([['tasks_status', '=','COMPLETED'],['user_id','=',$user->id]])->get();


        }
       
        if(count($searchedtask) > 0)
            return view('home',['tasks' => $searchedtask]);
        else return view ('home',['tasks' => array()])->withMessage('No Details found. Try to search again !');
       
    }

    public function complete($id)
    {
     
        $task = Task::where('id','=',$id)->first();
        if($task){
            switch($task->tasks_status)
            {
                case 'COMPLETED': 
                    $task->tasks_status = 'ACTIVE';
                    break;
                case 'ACTIVE': 
                    $task->tasks_status = 'COMPLETED';
                    break;
            }
             $task->save();
        }

        return redirect('/home');
       
    }
    public function deleted($id)
    {
     
        $task = Task::where('id','=',$id)->first();
        $task->tasks_status = 'DELETED';
        $task->save();
    

        return redirect('/home');
       
    }
}
