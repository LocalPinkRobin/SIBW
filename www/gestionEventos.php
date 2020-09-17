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

    if(isset ($_POST['etiqueta']) && isset($_POST['n_evento'])){
        
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if($_POST['boton'] === 'Borrar' ){
            borrarEvento($_POST['ev']);
        }
        if($_POST['boton'] === 'Modificar' ){
            $_SESSION['id_evento'] = $_POST['n_evento'];
            $variablesTwig['ev_mod'] = getEvento($_POST['n_evento']);
        }
        if($_POST['boton'] === 'Actualizar' ){
            editarEvento($_POST['id'],$_POST['nombre'],$_POST['lugar'],$_POST['organizador'],$_POST['contenido'],$_POST['publicado']);
        }
        if ($_POST['boton'] === 'Añadir' ){
            anadirEtiqueta();
        }

    }

    $variablesTwig['eventos'] = getEventosPortadaAll();
    echo $twig->render('gestionEventos.html',$variablesTwig);
    
?>