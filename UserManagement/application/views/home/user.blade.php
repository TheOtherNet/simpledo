<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Sistema de control de usuarios</title>
    <meta name="viewport" content="width=device-width">
    {{ Asset::container('bootstrapper')->styles(); }}
    {{ Asset::container('bootstrapper')->scripts(); }}
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
    <script>
        function validar(){
            document.getElementById('status').value = 1;
            alert("Usuario marcado para validar. Pulse enviar para aplicar los cambios");
        }
        function assign_card(){
            document.getElementById('id_tarjeta').value = prompt('Coloque la tarjeta sobre el lector');
            alert("Tarjeta asociada correctamente. Pulse enviar para aplicar los cambios");
        }
        function unassign_card(){
            document.getElementById('id_tarjeta').value = "";
            alert("Tarjeta anulada correctamente. Pulse enviar para aplicar los cambios");
        }
    </script>
</head>
<body>
    <div class="container">
        <header style="text-align:center; margin-bottom:50px;">
            <h1><a href="/">  {{ $site->name  }} </a></h1>
        </header>
<div class="span4">
    <form action="/home/edituser/<?php echo $user->id;?>" method=post class="form-horizontal">

    <input type=hidden name=id_tarjeta id=id_tarjeta value="<?= $user->id_tarjeta ?>" />
    <input type=hidden value="<?= $user->status ?>" name=status id=status />
<?php
$props=array(
    'E-mail' => 'email',
    'Nombre' => 'name',
    'Apellidos' => 'surname',
    'DNI' => 'dni',
    'Teléfono' => 'phone',
    'Dirección' => 'address',
    'Forma de pago' => 'payment',
    'Numero de socio' => 'associateno',
    'Comentario' => 'comment',
);

foreach ($props as $name => $prop){ ?>
<div class="control-group">
    <label class="control-label" for="<?php echo $prop; ?>">
        <?php echo $name?>
    </label>
    <div class="controls">
        <input type="text" name=<?php echo $prop; ?>
            value="<?php echo $user?$user->$prop:'';?>" placeholder="<?php echo $prop?>"/>
    </div>
</div>
<?php
}

?>
<div class="control-group">
    <label class="control-label" for="has_parking"> ¿Tiene acceso al parking?
    </label>
    <div class="controls">
        <input type="checkbox" name=has_parking <?php echo $user->has_parking?"checked":""; ?> value=1 />
    </div>
</div>

<hr>
<div class="span4">
    <button style="width:100%;" type=submit class="btn btn-big btn-success"> Enviar </button>
</div>
</div>
<div class="span4" style="margin-left:120px">
<?php if ($user){ ?>
<img src="/img/users/<?php echo $user->id;?>"/><br/>
<?php } ?>
<?php
if ($show_stats && $user){
?>
<br/><button class="btn btn-success btn-big"
        onclick="assign_card(); return false"> Asociar tarjeta </button><br/>
    <button class="btn btn-success btn-big"
            onclick="unassign_card(); return false"> Anular tarjeta </button><br/>
    <br/>
<?php echo $user->id_tarjeta? "<div class='alert alert-info'>".
"Tarjeta asociada actualmente : ". $user->id_tarjeta ."</div>" : ""; ?>
<?php
    if (!$user->status){
    echo "<div class='alert alert-info'>".
        "Usuario no validado";
    ?>
    <button onclick="validar(); return false" class="btn btn-warning"> Validar usuario </button>
    <?php
        echo "</div>";
    } elseif ($user->fechapago < date('Y-m-d') ) {
?>
<div class="alert alert-danger"> Este usuario tiene un pago pendiente
    <label> Introduzca una nueva fecha de vencimiento del pago</label>
    <input type="date" name=fechapago value="<?= $user->fechapago ?>" style="display:-webkit-inline-box">
</div>

<?
    } else{
        echo "<div class='alert alerf-info'>Usuario pagado hasta: $user->fechapago<br/><br/>";
    	echo '<input type="date" name=fechapago value="'.$user->fechapago.'" style="display:-webkit-inline-box"></div>';
    }
?>
</form>
<h2> Registros </h2>
<div style="height:100px; overflow-y:scroll;">
<?php
    $logs = DB::table('access_log')->where('id_tarjeta', '=', $user->id_tarjeta);
    setlocale(LC_TIME, 'es_ES'); 
    $logs_ = array(); 
    foreach ($logs->get() as $log){
        $logs_[] = $log;
    }
    foreach (array_reverse($logs_) as $log) {
        $estado = Estado::find($log->status)->nombre;
        echo "Registrado " . $estado . " ($log->extra_data) en " . gmstrftime('%H:%M:%S', strtotime($log->date) +7200 ) . "<br/>";
    }

?>
</div>
</div>
<div class="span12">
    <iframe width=100% height=500 seamless src="/home/stats/<?php echo $user?$user->id:"false"; ?>/false"></iframe>
</div>
<?php
} else {
?>
<p>
    <?php if (!Auth::check()){ ?>
    Envie este formulario de peticion de membresía en la ciudad de las bicis, será revisado lo antes posible por un administrador.
    <?php } ?>
</p>

<?php } ?>
</body>
</html>
