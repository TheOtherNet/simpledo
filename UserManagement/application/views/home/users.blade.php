<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Sistema de control de usuarios</title>
    <meta name="viewport" content="width=device-width">
    {{ Asset::container('bootstrapper')->styles(); }}
    {{ Asset::container('bootstrapper')->scripts(); }}
    <script>
        function delete_user(id){
            $.ajax({
                url: '/home/delete/' + id,
                type:'POST',
                success:function(){
                    alert("Usuario borrado correctamente");
                    window.location.reload();
                }
            });
        }
    </script>
    <style>
        iframe[seamless]{
        background-color: transparent;
        border: 0px none transparent;
        padding: 0px;
        overflow: hidden;
    }
        .profile_main{
            border:1px solid lightblue;
            margin:2px;
            margin-bottom:15px;
            height:64px;
        }

        .profile_name{
            font-size:x-large;
            padding-top:13px;
        }

        .profile_status{
            padding-top:10px;

        }

        .profile_img{
            background:lightblue;
            width:65px;
            height:65px;
            margin-right:10px;
            float:left;
        }
    </style>
</head>
<body>
    <div class="container">
        <header style="text-align:center; margin-bottom:50px;">
            <h1><a href="/">  {{ $site->name  }}</a></h1>
        </header>
<div class="span4">
    <form class="form form-inline">
        <input type="text" class="input input-large" name="search" />
        <button class="btn btn-primary btn-medium"> Buscar </button>
        <br/>
    </form>
    <button class="btn btn-large btn-success" style="width:85%;background:dodgerblue" onclick="document.location.href='/home/edituser/new'">Nuevo </button>
    <br/><br/>
    <button class="btn btn-large btn-success" onclick="location.href='/home/management/';">  Todos </button>
    <button class="btn btn-large btn-warning" onclick="location.href='/home/management/1';"> P. validar </button>
    <button class="btn btn-large btn-danger" onclick="location.href='/home/management/2';">  P. pago </button>
    <button class="btn btn-large btn-success" onclick="location.href='/home/management/3';">  P. devolucion libro </button>
<br/>
<br/>

<?php

foreach ($users->results as $user) {
        $logs = DB::table('access_log')->where('id_tarjeta', '=', $user->id_tarjeta);
        $lastlog = $logs->order_by('date', 'desc')->take(1)->first();
        $lastlog = $lastlog?$lastlog->date:false;
?>
<a href="/home/edituser/<?php echo $user->id;?>">
    <div class="profile_main">
        <div class="profile_img"><img src="/img/users/<?= $user->id;?>.jpg" /></div>
        <div class="profile_name"><?= $user->name . " " . $user->surname;?></div>
        <div class="profile_status"><?php
        if (!$user->status){
            echo "Pendiente de validar";
        } else {
            if ($user->fechapago < date('yyyy-mm-dd')){
                echo "Sin pagar";
            } else {
                echo "Pagado";
            }
        }
        echo " - ";
echo $lastlog?$lastlog:"Nunca ha accedido";
?>
<a onclick="delete_user(<?=$user->id?>);"> Borrar </a>
            </div>
    </div>
</a>
    <?php
}
echo $users->links();
?>
</div>
<div class="span6">
    <iframe width=100% height=500 seamless src="/home/stats/false/false"></iframe>
</div>
</body>
</html>
