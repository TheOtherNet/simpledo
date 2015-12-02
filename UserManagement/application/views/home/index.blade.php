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

        function marcarLibro(){
            $.ajax({
                url: '/home/registro/2',
                type:'POST',
                data:{
                    'id' : prompt('Ponga la tarjeta en el lector'),
                    'extra' : prompt("Introduzca la referencia del libro: ")
                }
            });
        }

        function marcarTaller(){
            $.ajax({
                url: '/home/registro/1',
                type:'POST',
                data:{
                    'id' : prompt('Ponga la tarjeta en el lector'),
                    'extra' : prompt("Introduzca un comentario al respecto: ")
                }
            });
        }

        function marcarGenerico(){
            $.ajax({
                url: '/home/registro/3',
                type:'POST',
                data:{
                    'id' : prompt('Ponga la tarjeta en el lector'),
                    'extra' : prompt("Introduzca un comentario al respecto: ")
                }
            });
        }
    </script>
</head>
<body>
    <div class="container-fluid" style="margin-left:0px; margin-right:0px">
        <header style="text-align:center; margin-bottom:50px;">
            <h1> <a href="/"> {{ $site->name  }} </a> <a style="color:red; font-size:medium; margin-left:30px;" href="/home/logout">Cerrar sesión </a> </h1>
        </header>
        <div class="span13">
            <div role="main" class="span4">
                <fieldset>
                    <legend>Estadisticas de acceso</legend>
                    <div class="well">
                        <a href="/home/stats/">
                            <img src="/img/stats.png" />
                        </a>
                    </div>
                    <p>Estadisticas recopiladas de acceso al almacen de bicis</p>
                </fieldset>
            </div>
            <div role="main" class="span4">
                <fieldset>
                    <legend>Apertura remota de puerta</legend>
                    <a href="/home/opendoor" onclick="if(!confirm('¿Está seguro de que quiere abrir la puerta?')){ return false; }" >
                        <div class="well" style="text-align:right">
                            <h1 style="float:left; padding-top:30px"> Abrir  </h1>
                            <img style="text-align:right" src="/img/unlock.png" />
                        </div>
                    </a>
                    <p>
                        Abre la puerta. Este sistema puede usarse para abrir la puerta desde dentro de la oficina
                        o desde fuera, con un smartphone y las credenciales adecuadas
                    </p>
                </fieldset>
            </div>


            <div role="main" class="span4">
                <fieldset>
                    <legend>Gestion de usuarios</legend>
                    <a href="/home/management">
                        <div class="well" style="text-align:right">
                            <h1 style="float:left; padding-top:30px"> Gestionar </h1>
                            <img style="text-align:right" src="/img/users/sinfoto.jpg" />
                            <br/>
                            <br/>
                            <br/>
                            <br/>

                        </div>
                    </a>
                    <p>
                        Acceso al sistema de gestión de usuarios.
                        Desde aquí podrá
                    </p>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
                </fieldset>
            </div>

            <div role="main" class="span4">
                <fieldset>
                    <legend>Marcar inicio/fin de taller</legend>
                    <a href="#" onclick="marcarTaller();return false">
                        <div class="well" style="text-align:right">
                            <h1 style="float:left; padding-top:30px"> Taller </h1>
                            <img style="text-align:right" src="/img/users/sinfoto.jpg" />
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                        </div>
                    </a>
                    <p>
                        Pasa la tarjeta despues de pulsar este boton para
                        registrar cuando un usuario entra y sale del taller.
                        Estos datos saldran en el registro del usuario.
                    </p>
                </fieldset>
            </div>

            <div role="main" class="span4">
                <fieldset>
                    <legend>Marcar prestamo/devolucion de libro</legend>
                    <a href="#" onclick="marcarLibro(); return false">
                        <div class="well" style="text-align:right">
                            <h1 style="float:left; padding-top:30px"> Libro </h1>
                            <img style="text-align:right" src="/img/users/sinfoto.jpg" />
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                        </div>
                    </a>
                    <p>
                        Pasa la tarjeta despues de pulsar este boton para
                        registrar cuando un usuario coje un libro..
                        Estos datos saldran en el registro del usuario.
                    </p>
                </fieldset>
            </div>

        </div>
    </div>
</body>
</html>
