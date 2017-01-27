@foreach($todos as $todo)
      <li id="{{$todo->id}}" class="list-group-item">
      	<a href="#" onClick="task_done('{{$todo->id}}');" class="toggle">
			<span id="{{$todo->id}}-glyph" class="glyphicon glyphicon-unchecked"></span>
      	</a>
      	<a href="#" onClick="delete_task('{{$todo->id}}');"  title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
      	<a href="#" onClick="edit_task('{{$todo->id}}','{{$todo->title}}');" title="Edit"><span class="glyphicon glyphicon-edit"></span></a>
      	<span id="span_{{$todo->id}}">{{{$todo->title}}}</span>
      </li>
@endforeach