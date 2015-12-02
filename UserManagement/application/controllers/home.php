<?php

class Home_Controller extends Base_Controller {

    public function action_opendoor()
    {
        if (Auth::check()){
            system('sudo door_opener');
        }
        return Redirect::to('/');
    }

    public function action_log()
    {
        return "<pre>".
            file_get_contents('/tmp/simpledod.log')
            ."</pre>";
    }

    public function action_registro($estado)
    {
       date_default_timezone_set('GMT');
       // Para sacar el nombre: Estado::find($estado)->nombre;
       DB::table('access_log')->insert(
           array(
               'id_tarjeta' => $_POST['id'],
               'extra_data' => $_POST['extra'],
               'status'     => $estado,
               'date'       => date('Y-m-d H:i:s')
           )
       );
    }

    public function action_login()
    {
        $credentials = array(
            'username' => $_POST['username'],
            'password' => $_POST['password']
        );
        Auth::attempt($credentials);
        return Redirect::to('/');
    }

    public function action_delete($id)
    {
        if (Auth::check()){
            $member = Member::find($id);
            DB::table('access_log')->where(
                'id_tarjeta', "=", $member->id_tarjeta 
            )->delete();
            $member->delete();
        }
    }

    public function action_logout()
    {
        Auth::logout();
    }

    public function action_stats($id=false, $show=true)
    {
        if (!$id || $id == "false"){
            $logins = DB::table('access_log')->get();
        } else {
            $member = Member::find($id);
            $logins = DB::table('access_log')->where(
                'id_tarjeta',
                '=',
                $member->id_tarjeta
            )->get();
        }
        return View::make('home.stats')->with(
            'accesses', $logins
        )->with(
            'site', Site::find('1')
        )->with(
            'titulo', $show
        );
    }

    public function action_edituser($id=false, $show=true)
    {
        $user = false;

        if ($id){
            $user = Member::find($id);
        }

        $show_stats=true;
        $auth = Auth::check(); // FIXME

        if (!$auth){ // Si no estamos autenticados, pero estamos intentando editar...
            $show_stats=false;
            $user=false;
        }

        if (!$user){
            $user = new Member;
            $user->save();
        }

        $fields = array(
            'dni', 'email', 'name', 'surname', 'fechapago',
            'phone', 'address', 'status', 'id_tarjeta', 'has_parking',
            'comment', 'associateno', 'payment'
        );



        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user->has_parking = null; // Nullify this.
            $user->id_tarjeta = null; // Nullify this.
        }

        foreach ($fields as $field){
            if (Input::has($field)){
                $user->$field = $_POST[$field];
            }
        }

        $user->save();
        if (!$auth){
            return Redirect::to('http://www.laciudaddelasbicis.com');
        }

        return View::make('home.user')->with(
            'user', $user
        )->with(
            'site', Site::find(1)
        )->with(
            'show_stats', $show_stats
        );
    }

    public function action_management($status = false)
    {
        if (!Auth::check()){
            return Redirect::to('/');
        }

        if ($status) {
            if ($status == 1) {
                $users = Member::where(
                    'status', '!=', 1
                )->or_where_null(
                    'status'
                );
            } elseif ($status == 2) {
                $users = Member::where(
                    'fechapago',
                    '<',
                    date('yyyy-mm-dd')
                )->or_where_null(
                    'fechaPago'
                )->where(
                    'status',
                    '=',
                    '1'
                );
            } elseif ($status == 3) {
                $bad_users = ['q'];
                $books = DB::table('access_log')->where(
                    'status',
                    '=',
                    "2"
                ); // Get all the books.
                foreach ($books->get() as $book){
                    if (count(DB::table('access_log')->where(
                            'status',
                            '=',
                            "2"
                        )->where(
                            'id_tarjeta',
                            '=',
                            $book->id_tarjeta
                        )->get()
                    ) % 2 != 0 ) {
                        $bad_users[] = $book->id_tarjeta;
                    }
                }
                $users = Member::where_in(
                    'id_tarjeta',
                    array_unique($bad_users)
                );

            }
            if (Input::has('search')){
                $users = $users->where(
                    'name',
                    'like',
                    '%'.$_REQUEST['search'].'%'
                )->or_where(
                    'surname',
                    'like',
                    '%'.$_REQUEST['search'].'%'
                );
            }
            $users = $users->order_by('id', 'asc')->paginate(5);
        } else {
            if (Input::has('search')){
                $users = Member::where(
                    'name',
                    'like',
                    '%'.$_REQUEST['search'].'%'
                )->or_where(
                    'surname',
                    'like',
                    '%'.$_REQUEST['search'].'%'
                )->order_by('id', 'asc')->paginate(5);
            } else {
                $users = Member::order_by('id', 'asc')->paginate(5);
            }
        }

        return View::make('home.users')->with(
            'users', $users
        )->with(
            'site', Site::find(1)
        );
    }
}
