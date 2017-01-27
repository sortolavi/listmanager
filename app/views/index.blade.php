@extends('master')


@section('header')

  <h2>{{Auth::user()->username}}'s task manager</h2>
 

@stop



@section('content')
  @if(Auth::check())

    <ul class="list-group">
      <li><a href="#" id="btn_add_new" class="btn btn-primary btn-lg" role="button" onClick="add_task('add_task');">New item</a></li>
    </ul>

    <section id="form_section">
  
      <form id="add_task" class="todo" style="display:none">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="input-group">
          <input class="form-control" id="task_title" type="text" name="title" placeholder="New item" value="" />
          <span class="input-group-btn">
            <button class="btn btn-primary" name="submit">Add</button>
          </span>
        </div>
      </form>

      <form id="edit_task" class="todo" style="display:none">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input id="edit_task_id" type="hidden" value="" />
        <div class="input-group">
          <input class="form-control" id="edit_task_title" type="text" name="title" value="" />
          <span class="input-group-btn">
            <button class="btn btn-primary" name="submit">Done</button>
          </span>
        </div>
      </form>

    </section>




    <section id="data_section" class="todo">

      

      <ul id="task_list" class="list-group">
      	@foreach($todos as $todo)
	        
        	<li id="{{$todo->id}}" class="{{$todo->status == 0?'list-group-item':'list-group-item done'}}">
            <a href="#" onClick="task_done('{{$todo->id}}');" class="toggle" title="Mark">
              <span id="{{$todo->id}}-glyph" class="glyphicon {{$todo->status == 0?'glyphicon-unchecked':'glyphicon-check'}}"></span>
            </a>
            
            <a href="#" onClick="delete_task('{{$todo->id}}');" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
            <a href="#" onClick="edit_task('{{$todo->id}}');" title="Edit"><span class="glyphicon glyphicon-edit"></span></a>
          
            <span id="span_{{$todo->id}}">{{{$todo->title}}}</span>

          </li>
	       
        @endforeach
      </ul>
    </section>

    

   

  
    
  @endif

  

@stop


