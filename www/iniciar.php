<?php
    session_start();

    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
  
    if (checkLogin($usuario, $pass)) {
      
      $_SESSION['nickUsuario'] = $usuario; 
    }
    
    header("Location: index.php");
    
    exit();
  }
  echo $twig->render('formulario.html', []);
    
?>