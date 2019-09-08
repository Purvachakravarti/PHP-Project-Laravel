
<style>
    .boder-style{
        border: 1px solid #dee2e6;
        padding: 20px;
    }
    .fa-edit{
        border-radius: 3px;
        border: 1px solid #c49f47;
        color: #c49f47;
        font-size: 15px;
        margin: 5px 0;
        padding: 10px;
    }
    .fa-trash-alt{
        border-radius: 3px;
        border: 1px solid #e7505a;
        color: #e7505a;
        font-size: 15px;
        margin: 5px 0;
        padding: 10px;
   
    }
    .fa-plus , .fa-save{
        border-radius: 3px;
        border: 1px solid #32c5d2;
        color: #32c5d2;
        font-size: 15px;
        margin: 5px 0;
        padding: 10px;

    }
    .fa-plus, .fa-trash-alt, .fa-edit {
        display: table-cell;
    }
    .panel-heading{
        padding: 15px 0px 15px 10px;
        color: black;
        /* #add5f9 */
        background-color: lightgray;
    }
    table{
        border: 1px solid lightgray;
    }
    table, td {
        text-align: center;
    }
    label{
        text-transform: uppercase;
        font-size: 14px;
        color: #5A5959;

    }
    .overdue{
        color: red;
    }
</style>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    
                     <!-- Bootstrap Boilerplate... -->

                    <div class="panel-body boder-style">
                        <!-- Display Validation Errors -->
                        @include('common.errors')

                        <!-- New Task Form -->
                        <form action="/task/0" method="POST" class="form-horizontal">
                            {{ csrf_field() }}

                            <!-- Task Name -->
                            <div class="form-group">
                                <label for="task" class="col-sm-6 control-label">Please enter the Task Name</label>

                                <div class="col-sm-6">
                                    <input type="text" name="tasks_name" id="task-name" class="form-control">
                                </div>
                            </div>
                            <br>
                             <!-- Task Name -->
                            <div class="form-group">
                                <label for="task" class="col-sm-6 control-label">Please enter the Due date</label>

                                <div class="col-sm-6">
                                    <input type="date" name="tasks_duedate" id="tasks_duedate" class="form-control">
                                </div>
                            </div>
                            <br>
                            <!-- Add Task Button -->
                            <div class="form-group" style="float: right">
                                <div>
                                    <button type="submit" >
                                        <i class="fa fa-plus">Add Task</i> 
                                    </button>
                                </div>
                            </div>  
                            <br>
                        </form>
                    </div>

                    
                    <!-- TODO: Current Tasks -->
                    @if (count($tasks) > 0)
               
                        <div class="panel panel-default ">
                            <div class="panel-heading">
                                <strong >MY CURRENT TASKS</strong>
                                <form action="/home/search" method="POST" role="search">
                                    {{ csrf_field() }}
                                    <div class="input-group row" >
                                        <input type="text" class="form-control col-sm-2" name="q"
                                            placeholder="Search Tasks By Keyword"> <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </form>

                                <div class="dropdown">
                                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    Filters
                                  </button>
                                  <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/home/filter/All">All</a>
                                    <a class="dropdown-item" href="/home/filter/Completed">Completed</a>
                                    <a class="dropdown-item" href="/home/filter/Active">Active</a>
                                    <a class="dropdown-item" href="/home/filter/Deleted">Deleted</a>
                                  </div>
                                </div>
                            </div>

                            <div class="panel-body ">
                                <table class="table">

                                    <!-- Table Headings -->
                                    <thead>
                                        <th></th>
                                        <th>Task</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>

                                    <!-- Table Body -->
                                    <tbody>
                                        @foreach ($tasks as $task)
                                        <?php $overdue = "";
                                            $duedate = $task->tasks_duedate;
                                            if($duedate < date('Y-m-d'))
                                             $overdue = "overdue";
                                        ?>
                                            <tr class = "{{ $overdue }}" >
                                                <!-- Completed Checkbox -->
                                                <td>
                                                    <div id="complete_{{ $task->id }}">
                                                        <i class="far fa-check-square"></i>
                                                    </div>
                                                </td>
                                                <!-- Task Name -->
                                                <form id="editform_{{ $task->id }}" action="/task/{{ $task->id }}" method="POST">
                                                {{ csrf_field() }}
                                                <td class="table-text" id="tname">
                                                    <div class="tasks_{{ $task->id }}">{{ $task->tasks_name }}</div>
                                                    <input type="text" name="tasks_n" value="{{ $task->tasks_name }}" id="task-n" class="form-control editField_{{ $task->id }}" style="display: none">
                                                </td>
                                                <!-- Task Due Date -->
                                                <td class="table-text" id="tduedate">
                                                    <div class="tasks_{{ $task->id }}">{{ $task->tasks_duedate }}</div>
                                                     @if($overdue == "overdue")
                                                        <p><i>Over Due</i></p>
                                                     @endif


                                                    <input type="date" name="tasks_dd" id="tasks_dd " value = "{{ $task->tasks_duedate }}" class="form-control editField_{{ $task->id }}" style="display: none">
                                                </td>
                                                </form>
                                                <!-- Task Status -->
                                                <td class="table-text">
                                                    <div>{{ $task->tasks_status }}</div>
                                                </td>

                                                <td>
                                                    <!-- TODO: Edit Button -->
                                                    <div id = "tedit_{{$task->id}}" onclick = "editFunction( {{$task->id}} )"><i class="fas fa-edit"></i></div>

                                                    
                                                        <button id = "tsave_{{$task->id}}" style="display: none" onclick = "submitEdit( {{$task->id}} )"><i class="far fa-save "></i> Save</button>
                                                    

                                                    <!-- TODO: Delete Button -->
                                                     <form action="/task/{{ $task->id }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button><i class="far fa-trash-alt"></i></button>
                                                     </form>
                                                    
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                  
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    function editFunction(task_id) {
      $(".editField_"+task_id).show();
      $(".tasks_"+task_id).hide();
      $("#tedit_"+task_id).hide();
      $("#tsave_"+task_id).show();

    }

    function submitEdit(task_id){
       $("#editform_"+task_id).submit(); 
    }
   
</script>
   
@endsection
