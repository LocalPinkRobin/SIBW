<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("bd.php");
    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    $variablesTwig = [];

    if (isset($_SESSION['nickUsuario'])) {
      $variablesTwig['usuario'] = getUser($_SESSION['nickUsuario']);
    }
    
    $variablesTwig['eventos'] = getEventosPortada();

    echo $twig->render('index.html',$variablesTwig);
    
?>