/*

K:\Ebooks2\Programming\Php\Laravel\Laravel Application Development Blueprints 2013.pdf page 23-...

*/
// set task done
function task_done(id){
	// handle ui changes right away without waiting for ajax processing
	$("#"+id).toggleClass("done");
	$("#"+id+"-glyph").toggleClass("glyphicon-unchecked").toggleClass("glyphicon-check");

	$.get("done/"+id, function(data) {
		// now if something went wrong let's change ui back like it was before
		if(data != "OK"){
			$("#"+id).toggleClass("done");
		}
	});
}




// delete task using given parameter
function delete_task(id){
	var target = $("#"+id);
	target.hide('slow', function(){ target.remove(); });

	// $("#ajax-load").show(); 
	// $(".ajax-loader").show();
	showSpinner(true);
	
	$.get("delete/"+id, function(data) {
		if(data=="OK"){
			sort_indexes(id);
		}
		else{
			console.log("an error occurred when deleting item" + id);
			showSpinner(false);
		}
	});

	
}

// re-index remaining tasks after delete operation
function sort_indexes(sid){
	var taskList = $('#task_list');
	var tasks = [];

	$('li', taskList).each(function(index, elem) {
		
    	var $listItem = $(elem);
    	var task_id = $listItem[0].id;

    	// collect remaining tasks after delete operation
    	if(!sid || task_id != sid) tasks.push(task_id);

    });	
    // console.log(tasks);
	if(tasks.length == 0) {
		showSpinner(false);
		return;
	}
	showSpinner(true);

    // update all data with one post request
	$.post("updatesort", {'alltasks[]': tasks})
		.done(function(data) {
			console.log(data);
			if(data=="OK"){
				console.log("sort indexes updated after delete operation.")
			}
			showSpinner(false);
		})
		.fail(function(data){
			console.log(data);
		})
		.always(function(data){
			console.log(data);
		})
	;
}


function showSpinner(show) {
	if(show){
		$("#ajax-load").show(); 
		$(".ajax-loader").show();
	}
	else {
		$(".ajax-loader").hide();
		$("#ajax-load").hide();
	}
}


// unhide form id given as parameter
function show_form(form_id, title_id){
		
	$("form").hide();
	$('#'+form_id).show("slow");

	$(title_id).focus();
	
}


function add_task(){

	var title = "";
	$("#task_title").val(title);

	show_form('add_task', '#task_title');
}


// populate #edit_task form and unhide it
function edit_task(id){

	var title = $("#span_"+id).text();

	// title = current_title;
	$("#edit_task_id").val(id);
	$("#edit_task_title").val(title);
	
	show_form('edit_task', '#edit_task_title');
}



// 
// handle submitting the forms
// 
$('#add_task').submit(function(event) {
	
	// stop form from submitting normally
  	event.preventDefault();
  	
 	// var frm = document.forms["add_task"];
	// var _token = frm._token.value;

	var _token = $('input[name=_token]').val();

	var title = $('#task_title').val();
	if(!title) title = "Unspecified item";

	// this is next sort_id
	var sort_id = $('#task_list li').length;

	var testing_promise = 0;

	if(!testing_promise){

		showSpinner(true);

	  	//ajax post the form
	  	$.post("add", {_token: _token, title: title, sort_id: sort_id}).done(function(data) {
		  	
			$('#add_task').hide("slow");
			$("#task_list").append(data);

			// console.log(data);
			
			showSpinner(false);
		});
	
  	}else {

		// alternatively let's do this with all ajax bells and whistles using the Promise interface
		// 
		var jqxhr = $.post("add", {_token: _token, title: title, sort_id: sort_id}, function(){
			console.log("success first time");
		})
		.done(function(data){
			console.log("done: success second time");
			$('#add_task').hide("slow");
			$("#task_list").append(data);
		})
		.fail(function(){
			console.log("fail: something went wrong");
		})
		.always(function(){
			console.log("always: this is executed always");
		});

		// 
		jqxhr.always(function() {
			console.log( "new always: second time always with new function" );
		});
	}


});



$('#edit_task').submit(function(event) {
	
	// stop form from submitting normally
  	event.preventDefault();

  	var _token = $('input[name=_token]').val();
  	
	var task_id = $('#edit_task_id').val();
	var new_title = $('#edit_task_title').val();
	if(!new_title) new_title = "Unspecified item";

	showSpinner(true);

  	//ajax post the form
  	$.post("update/"+task_id, {_token: _token, title: new_title}).done(function(data) {
	  
		$('#edit_task').hide("slow");
		$("#span_"+task_id).text(new_title);

		showSpinner(false);
	});

});



$('#brand').click(function() {
  $(this).attr('target', '_blank');
}); 



// make tasklist sortable, ie. drag and drop items and save order to db
$(function() {
	var taskList = $('#task_list');

	taskList.sortable({ 
  
		update: sort_indexes

  	});

  	taskList.disableSelection();
});

