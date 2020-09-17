<?php
    session_start();

    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("bd.php");
    

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

        if (isset($_GET['ev']) && is_numeric($_GET['ev'])){
            $idEv = htmlentities($_GET['ev']);
        } else {
            $idEv = -1;
        }

        $evento = getEvento($idEv);



    echo $twig->render('evento_imprimir.html',['evento' => $evento]);
    
?>
