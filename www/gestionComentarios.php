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
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if($_POST['boton'] === 'Borrar' ){
            borrarComentario($_POST['num']);
        }
        if($_POST['boton'] === 'Editar' ){
            editarComentario($_POST['num'],$_POST['texto']);
        }


    }

    $variablesTwig['firma'] = 'Comentario editado por'. $_SESSION['nickUsuario']; 
    $variablesTwig['comentarios'] = getComentarios();
    echo $twig->render('gestionComentarios.html',$variablesTwig);
    
?>