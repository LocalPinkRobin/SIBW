<?php

    $mysqli;

    function conectar (){
        global $mysqli;
        $mysqli = new mysqli ("mysql", "tiger", "contraseña", "SIBW");
        if ($mysqli->connect_errno){
            echo ("Fallo al conectar: " . $mysqli->connect_error);
        }
        return $mysqli;
    }

    function getEvento ($idEv){
        global $mysqli;
        if ( $mysqli == NULL){

            $mysqli = conectar();
        }
        
        if (is_numeric($idEv)){
            $idEv = $mysqli->real_escape_string($idEv);
            $res = $mysqli->query("SELECT id, nombre, lugar, organizador, contenido, publicado FROM eventos WHERE id=" . $idEv);
        }
        $evento = array('id'=> '-1', 'nombre'=> 'Nombre por defecto', 'lugar' => 'Lugar por defecto', 'organizador' => 'organizador por defecto', 'contenido' => 'Contenido por defecto');

        if ($res->num_rows > 0){
            $row = $res->fetch_assoc();
            $evento = array ('id'=>$row['id'],'nombre'=> $row['nombre'],'lugar'=> $row['lugar'], 'organizador'=> $row['organizador'], 'contenido'=> $row['contenido'],'publicado'=> $row['publicado']);

        }

        return $evento;
    }

    function getFoto($idEv){
        global $mysqli;

        if ( $mysqli == NULL){

             $mysqli = conectar();
        }

        if (is_numeric($idEv)){

            $idEv = $mysqli->real_escape_string($idEv);
            $res = $mysqli->query("SELECT ruta FROM imagenes WHERE evento=" . $idEv);
        }
        $row = array();
        

        if ($res->num_rows > 0){

            for ($i = 0; $i< $res->num_rows; $i++){
            array_push($row , $res->fetch_assoc());
            }
        }
        return $row;
        
    }

    function registrar (){
        global $mysqli;

        if ( $mysqli == NULL){

             $mysqli = conectar();
        }

            $usuario = $_POST['usuario'];
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $email = $_POST['email'];

            // Tengo dos user por defecto que es:
            // usuario: mari
            // contraseña: passsecreto

            //usuario: andres
            //contraseña: tiger
            
            $sql = $mysqli->query("INSERT INTO usuarios(id, pass, permisos,email) VALUES ('$usuario','$pass','registrado','$email')");


    }

    function checkLogin($usuario, $pass){
        global $mysqli;

        if ( $mysqli == NULL){

             $mysqli = conectar();
        }

        $res = $mysqli->query("SELECT * FROM usuarios WHERE id= '$usuario';");

        if ($res->num_rows>0){
            print_r($row['pass']);
            $row = $res->fetch_assoc();
        
            if (password_verify($pass,$row['pass'])){
                return true;
            }
        }
        
        return false;
    }

    function getUser($usuario) {
        
        
        global $mysqli;

        if ( $mysqli == NULL){

             $mysqli = conectar();
        }

        $res = $mysqli->query("SELECT * FROM usuarios WHERE id= '$usuario';");

        if ($res->num_rows>0){
            $row = $res->fetch_assoc();
        
            $usu = array();
            array_push($usu,$row['id']);
            array_push($usu,$row['permisos']);
            array_push($usu,$row['email']);

            return $usu;
        }
        
        return 0;

    }

    function getEventosPortada(){
        global $mysqli;
        if ( $mysqli == NULL){

            $mysqli = conectar();
        }
        
        
            $res = $mysqli->query("SELECT id, nombre, portada FROM eventos WHERE publicado=true");
            $eventos = array();

            if ($res->num_rows>0){
                while ($row = $res->fetch_assoc()){
                    $aux = array();

                    array_push($aux, $row['id']);
                    array_push($aux, $row['nombre']);
                    array_push($aux, $row['portada']);

                    array_push ($eventos, $aux);
                }               
            }
        return $eventos;
        
    }
    function getEventosPortadaAll(){
        global $mysqli;
        if ( $mysqli == NULL){

            $mysqli = conectar();
        }
        
        
            $res = $mysqli->query("SELECT id, nombre, portada, publicado FROM eventos");
            $eventos = array();

            if ($res->num_rows>0){
                while ($row = $res->fetch_assoc()){
                    $aux = array();

                    array_push($aux, $row['id']);
                    array_push($aux, $row['nombre']);
                    array_push($aux, $row['portada']);
                    array_push($aux, $row['publicado']);

                    array_push ($eventos, $aux);
                }               
            }
        return $eventos;
        
    }

    function actualizarDatos($usu) {

        global $mysqli;

        if ( $mysqli == NULL){

             $mysqli = conectar();
        }

        if(($_POST['usuario']) != ""){
            $usuario = $_POST['usuario'];
            
            $sql = $mysqli->query("UPDATE usuarios SET id = '$usuario' WHERE id = '$usu' ");
        }

        if(($_POST['email']) != ""){
            $email = $_POST['email'];
            
            $sql = $mysqli->query("UPDATE usuarios SET email = '$email' WHERE id = '$usu' ");
        }

    }

    function getEtiquetas($idEv){
        global $mysqli;
        if ( $mysqli == NULL){

            $mysqli = conectar();
        }
                
        $res = $mysqli->query("SELECT etiqueta FROM etiquetas WHERE evento =". $idEv);
        $row = array();
        
        if ($res->num_rows > 0){

            for ($i = 0; $i< $res->num_rows; $i++){
                array_push($row , $res->fetch_assoc());
            }
        }
        return $row;
        
    }

    function cambiarPermiso(){

        global $mysqli;
        if ( $mysqli == NULL){

            $mysqli = conectar();
        }
        $usuario = $_POST['usuario'];
        $permiso = $_POST['permiso'];
            
        $sql = $mysqli->query("UPDATE usuarios SET permisos = '$permiso' WHERE id = '$usuario' ");
    }

    function anadirEtiqueta(){
        global $mysqli;
        if ( $mysqli == NULL){

            $mysqli = conectar();
        }
        $etiqueta = $_POST['etiqueta'];
        $evento = $_POST['n_evento'];
            
        $sql = $mysqli->query("INSERT INTO etiquetas(etiqueta, evento) VALUES ('$etiqueta','$evento') ");
    }

    function getComentariosEvento ($idEv){
        global $mysqli;
        if ( $mysqli == NULL){

            $mysqli = conectar();
       }

       $res = $mysqli->query("SELECT * FROM comentarios WHERE evento= '$idEv';");
       $comentarios = array();
       if ($res->num_rows>0){
            while ($row = $res->fetch_assoc()){
                $aux = array();

                array_push($aux, $row['autor']);
                array_push($aux, $row['fecha']);
                array_push($aux, $row['comentario']);



                array_push ($comentarios, $aux);

            }           

        } 
        return $comentarios;

    }

    function addComentario($autor,$comentario, $evento,$fecha){
        global $mysqli;
        if ( $mysqli == NULL){

            $mysqli = conectar();
        }
        $res = $mysqli->query("INSERT INTO comentarios(autor, comentario, evento, fecha) VALUES ('$autor','$comentario', '$evento','$fecha') ");


    }
    function getComentarios() {
        global $mysqli;
        if ( $mysqli == NULL){

            $mysqli = conectar();
       }

       $res = $mysqli->query("SELECT comentarios.id , autor, fecha, comentario, nombre FROM comentarios, eventos WHERE evento = eventos.id;");
       $comentarios = array();
       if ($res->num_rows>0){
            while ($row = $res->fetch_assoc()){
                $aux = array();

                array_push($aux, $row['id']);
                array_push($aux, $row['autor']);
                array_push($aux, $row['fecha']);
                array_push($aux, $row['comentario']);
                array_push($aux, $row['nombre']);


                array_push ($comentarios, $aux);

            }           

        } 
        return $comentarios;

    }

    function borrarComentario($id){
        global $mysqli;

        if ( $mysqli == NULL){
            $mysqli = conectar();
        }
        $res = $mysqli->query("DELETE FROM comentarios WHERE id ='$id'");

    }
    function borrarEvento($id){
        global $mysqli;

        if ( $mysqli == NULL){
            $mysqli = conectar();
        }
        $res = $mysqli->query("DELETE FROM eventos WHERE id ='$id'");

    }

    function editarComentario ($id, $comentario){
        global $mysqli;

        if ( $mysqli == NULL){
            $mysqli = conectar();
        }
        $comentario = $comentario.' ' . '[Comentario editado por '. $_SESSION['nickUsuario'].']';

        $sql = $mysqli->query("UPDATE comentarios SET comentario = '$comentario' WHERE id = '$id' ");
    }
    function editarEvento ($id, $nom, $lugar, $organizador, $contenido, $publicado){
        global $mysqli;

        if ( $mysqli == NULL){
            $mysqli = conectar();
        }


        $sql = $mysqli->query("UPDATE eventos SET nombre = '$nom', organizador = '$organizador', lugar = '$lugar',
                                                  contenido = '$contenido', publicado = '$publicado' WHERE id = '$id' ");
    }

    function getPublicado($idEv){
        global $mysqli;
        if ( $mysqli == NULL){
            $mysqli = conectar();
        }

        $res = $mysqli->query("SELECT publicado FROM eventos WHERE evento= '$idEv';");

        return $res;
    }

    function setPublicado ($publicado){
        global $mysqli;
        if ( $mysqli == NULL){
            $mysqli = conectar();
        }
    }
    


?>
