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

        if (isset($_GET['ev'])){
            $idEv = $_GET['ev'];
        } else {
            $idEv = -1;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($_POST['boton']==='Añadir comentario'){
                $comentario = $_POST['comentario'];
                $fecha = date_create()->format('Y-m-d');
                $autor = $_SESSION['nickUsuario']; 
                addComentario($autor,$comentario, $idEv,$fecha);

            }
        }



        $variablesTwig['evento'] = getEvento($idEv);
        $variablesTwig['rutas'] = getFoto($idEv);
        $variablesTwig['etiquetas'] = getEtiquetas($idEv);

        $variablesTwig['comentarios'] = getComentariosEvento($idEv);
        $variablesTwig['publicado'] = getPublicado($idEv);
        
        echo $twig->render('evento.html',$variablesTwig);
    
?>
