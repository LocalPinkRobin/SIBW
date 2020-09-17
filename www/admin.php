<?php
    session_start();

    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("bd.php");


    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $variablesTwig = [];

    if (isset($_SESSION['nickUsuario'])) {
        $variablesTwig['usuario'] = getUser($_SESSION['nickUsuario']);
    }

    cambiarPermiso();

    echo $twig->render('perfil.html',$variablesTwig);
    
?>