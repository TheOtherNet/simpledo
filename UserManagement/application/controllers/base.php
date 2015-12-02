<?php

class Base_Controller extends Controller {

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

    public function action_index($errors=false)
    {
        $login = Auth::check();
        if (Input::has('pwgen')){
            $pw = Hash::make(Input::get('pwgen'));
        } else {
            $pw = "";
        }
        if (!$login){
            return View::make('home.login')->with(
                'site', Site::find(1)
            )->with('pw', $pw);
        } else {
            return View::make('home.index')->with(
                'site', Site::find(1)
            )->with(
                'errors', $errors
            );
        }
	}

}
