<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Sistema de control de usuarios</title>
    <meta name="viewport" content="width=device-width">
    {{ Asset::container('bootstrapper')->styles(); }}
    {{ Asset::container('bootstrapper')->scripts(); }}
</head>
<body>
    <div class="container-fluid" style="margin-left:20px; margin-right:20px">
        <header style="text-align:center; margin-bottom:50px;">
            <h1> <a href="/">  {{ $site->name  }} </a></h1>
{{ $pw }}
        </header>
        <div class="span12">
            <div role="main" class="span4">
                <form action="/home/login/" method="POST" class="form-horizontal">
                    <fieldset>
                        <legend>Inicio de sesión</legend>

                        <div class="control-group">
                            <label class="control-label" for="user">Correo electrónico</label>
                            <div class="controls">
                                <div class="input-prepend">
                                     <span class="add-on"><i class="icon-user"></i></span><input
                                          name="username" type="email" value="" class="span2" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="user">Contraseña</label>
                            <div class="controls">
                                <div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span><input
                                     name="password" type="password" class="span2" />
                            </div>
                        </div>
                        <br/>
                        <div style="text-align:center">
                            <button type="submit" class="btn btn-primary btn-large">Entrar</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
