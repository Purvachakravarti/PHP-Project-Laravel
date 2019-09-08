
<style>
    .boder-style{
        border: 1px solid grey;
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
    .fa-plus{
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
    .body-style{
        border: 1px solid lightgray;
    }
    .table{
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
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

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <script src="https://kit.fontawesome.com/f5201b0a29.js"></script>




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
                    <p>Congratulations {{ Auth::user()->name }} ! You are logged in!</p>
                    
                     <!-- Bootstrap Boilerplate... -->

                    <div class="panel-body boder-style">
                        <!-- Display Validation Errors -->
                        @include('common.errors')

                        <!-- New Task Form -->
                        <form action="/task" method="POST" class="form-horizontal">
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

                    <!-- Current Tasks -->
                    @if (count($tasks) > 0)
               
                        <div class="panel panel-default ">
                            <div class="panel-heading">
                                <strong>MY CURRENT TASKS</strong>
                            </div>

                            <div class="panel-body body-style">
                                <table class="table table-striped">

                                    <!-- Table Headings -->
                                    <thead>
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
                                                <!-- Task Name -->
                                                <td class="table-text">
                                                    <div>{{ $task->tasks_name }}</div>
                                                </td>
                                                <!-- Task Due Date -->
                                                <td class="table-text">
                                                    
                                                    <div>{{ $task->tasks_duedate }}</div>
                                                    
                                                </td>
                                                <!-- Task Status -->
                                                <td class="table-text">
                                                    <div>{{ $task->tasks_status }}</div>
                                                </td>

                                                <td>
                                                    <!-- TODO: Delete Button -->
                                                     <form action="/task/{{ $task->id }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button><i class="far fa-trash-alt"></i></button>
                                                    </form>
                                                    <form action="/task/{{ $task->id }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('EDIT') }}
                                                        <button><i class="fas fa-edit"></i></button>
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
    $(document).ready(function () {
    
   var todaysDate = new Date(); // Gets today's date
    
    // Max date attribute is in "YYYY-MM-DD".  Need to format today's date accordingly
    
    var year = todaysDate.getFullYear();                        // YYYY
    var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2);  // MM
    var day = ("0" + todaysDate.getDate()).slice(-2);           // DD

    var minDate = (year +"-"+ month +"-"+ day); // Results in "YYYY-MM-DD" for today's date 
    
    // Now to set the max date value for the calendar to be today's date
    $('#tasks_duedate input').attr('min',minDate);
 
  });
</script>
   
@endsection
