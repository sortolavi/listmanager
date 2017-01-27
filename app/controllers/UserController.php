<?php 
class UserController extends BaseController
{

    public function getLogin() {
        return View::make("login");     
    }


    public function postLogin() {
    
        if(Auth::attempt(Input::only('username', 'password'))) {
        	return Redirect::to('/')
            ->with('message', 'You are now logged in');
            // return Redirect::intended('/');
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

}