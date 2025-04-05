<!DOCTYPE html>
<html lang="es" style="height: 100%">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon en formato .ico -->
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- Alternativas en otros formatos -->
    <link rel="icon" href="../../public/images/icon.png" type="image/png">
    <title>Bread King</title>
    <!-- PACE-->
    <link rel="stylesheet" type="text/css" href="../../public/plugins/PACE/themes/blue/pace-theme-flash.css">
    <script type="text/javascript" src="../../public/plugins/PACE/pace.min.js"></script>
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="../../public/plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Fonts-->
    <link rel="stylesheet" type="text/css" href="../../public/plugins/themify-icons/themify-icons.css">
    <!-- Primary Style-->
    <link rel="stylesheet" type="text/css" href="../../public/build/css/second-layout.css">

</head>
<body style="background-image: url(../../public/images/bread-wallpaper.jpg)" class="body-bg-full">
<div class="container page-container">
    <div class="page-content">
        <div class="logo">
            <img src="../../public/images/icon.png">
        </div>
        <form method="POST" class="form-horizontal">
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="text" id="login" name="login" placeholder="Usuario" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="password" id="clave" name="clave" placeholder="Contraseña" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn-lg btn btn-black btn-block btn-sign-in">Iniciar sesión</button>
        </form>

    </div>
</div>

<!-- jQuery-->
<script type="text/javascript" src="../../public/plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap JavaScript-->
<script type="text/javascript" src="../../public/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../public/js/login_usuario.js" type="text/javascript"></script>
</body>
</html>