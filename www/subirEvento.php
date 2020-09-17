<?php
  
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include ("bd.php");


  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  global $mysqli;
  if ( $mysqli == NULL){

      $mysqli = conectar();
  }
  $nombre= $_POST['nombre'];
  $organizador= $_POST['organizador'];
  $lugar= $_POST['lugar'];
  $contenido= $_POST['contenido'];
  $publicado = $_POST['publicado'];
  
      

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_FILES['imagen'])){
        $errors= array();
        $file_name = $_FILES['imagen']['name'];
        $file_size = $_FILES['imagen']['size'];
        $file_tmp = $_FILES['imagen']['tmp_name'];
        $file_type = $_FILES['imagen']['type'];
        $file_ext = strtolower(end(explode('.',$_FILES['imagen']['name'])));
        
        $extensions= array("jpeg","jpg","png");
        
        if (in_array($file_ext,$extensions) === false){
          $errors[] = "Extensión no permitida, elige una imagen JPEG o PNG.";
        }
        
        if ($file_size > 2097152){
          $errors[] = 'Tamaño del fichero demasiado grande';
        }
        
        if (empty($errors)==true) {
          move_uploaded_file($file_tmp, "imgs/" . $file_name);
          
          $varsParaTwig['imagen'] = "imgs/" . $file_name;
          $ruta = "imgs/" . $file_name;
        }
        
        if (sizeof($errors) > 0) {
          $varsParaTwig['errores'] = $errors;
        }
    }
  }
  $sql = $mysqli->query("INSERT INTO eventos (nombre, organizador, lugar, contenido, portada, publicado) VALUES ('$nombre','$organizador', '$lugar', '$contenido','$ruta', '$publicado') ");

  $varsParaTwig['evento'] = getEvento($idEv);
  $varsParaTwig['rutas'] = getFoto($idEv);
  $varsParaTwig['publicado'] = getPublicado($idEv);

  header("Location: gestionEventos.php");
  echo $twig->render('gestionEventos.html',[]);

  ?>
