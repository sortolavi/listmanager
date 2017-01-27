<?php
class TodoController extends BaseController
{

    // public $restful = true;
    public function __construct(){
        // $this->beforeFilter('auth');
        // $this->beforeFilter('auth', array('except' => 'getLogin'));
        // $this->beforeFilter('csrf', array('on' => 'post'));
    }




    public function getAbout() {
        return View::make("about");     
    }



    // public function getLogin() {
    //     return View::make("login");     
    // }


    public function postLogin() {
        
        if(Session::token() !== Input::get('_token') ) {
            return Redirect::back()
                ->withInput()
                ->with('error', "Unauthorized attempt");
        }
        
        if(Auth::attempt(Input::only('username', 'password'))) {
            // return Redirect::to('/')
            // ->with('message', 'You are now logged in');
            return Redirect::intended('/');
        } else {
            return Redirect::back()
                ->withInput()
                ->with('error', "Invalid credentials");
        }
        

    }


    public function getLogout(){
        Auth::logout();
        return Redirect::to('/')
            ->with('message', 'You are now logged out');
    }    



    public function getIndex() {
        if(Auth::check()) {
            // $todos = Todo::all();
            $max_items = 9999;
            // sort using sortId
            $user_id = Auth::user()->id;
            $todos = Todo::where('user_id', $user_id)->orderBy('sort_id', 'asc')->get();
            // dd($todos->count());
            if(Auth::user()->username == "demo") {
                $max_items = 5;
            }
            return View::make("index")->with("todos", $todos);
        }
        else {
            return View::make("about");
        }
    }




    public function getDelete($id) {
        
        if(Request::ajax()){

            $todo = Todo::whereId($id)->first();
            $todo->delete();
            return "OK";

        }
    }


    

    public function getDone($id) {

        if(Request::ajax()){

            $task = Todo::find($id);
            $task->status = ($task->status == 0 ? 1 : 0);
            
            $task->save();
            return "OK";

        }
        
    }

    public function postAdd() {

        if(Request::ajax()){
            
            $token = Input::get("_token");
            if($token == csrf_token()) {
                // todo: set input so that items are separeted by . or : with regexp
                // ajaxData view can handle them all
                $todo = new Todo();
                $todo->title = Input::get("title");
                $todo->user_id = Auth::user()->id;
                $todo->sort_id = Input::get("sort_id");


                // save if legal
                $ok_to_save = true;
                
                if(Auth::user()->username == "demo") {
                    $todos = Todo::where('user_id', $todo->user_id)->orderBy('sort_id', 'asc')->get();
                    // $cnt = $todos->count();
                    if($todos->count() >= 5) {
                        $ok_to_save = false;
                    }
                }

                if($ok_to_save) {
                    $todo->save();
                
                    $last_todo = $todo->id;

                    $todos = Todo::whereId($last_todo)->get();

                    return View::make("ajaxData")
                            ->with("todos", $todos);
                } else {
                    return View::make("errorData");
                            
                }
                
            }
        }
        
    }

    public function postUpdate($id) {
        
        if(Request::ajax()){
            $token = Input::get("_token");
            if($token == csrf_token()) {
                $task = Todo::find($id);
                $task->title = Input::get("title");
                $task->save();
                return "OK";
            }
        }
    }

    

    public function postUpdatesort() {
        
        if(Request::ajax()){
            
            // construct db sql command
            $get_arr = Input::get("alltasks");

            $str_arr = [];
            foreach ($get_arr as $index => $task) {
                $str_arr[] = "(".$task.",".$index.")";
            }
            $values = implode(",", $str_arr);
            
            // should look like: ... VALUES (47, 0),(55, 1),(36, 2) ON DUPL...
            $str = "INSERT INTO todos (id,sort_id) VALUES ".$values." ON DUPLICATE KEY UPDATE sort_id=VALUES(sort_id);";

            DB::unprepared($str);

            return "OK";
        }
    }
}