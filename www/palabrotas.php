<?php  
    require('bd.php');

    function getPalabrotas(){
        global $mysqli;
        if ( $mysqli == NULL){

            $mysqli = conectar();
        }
        
        $res = $mysqli->query("SELECT palabra FROM censuradas");
        
        $row = array();
        

        if ($res->num_rows > 0){

            for ($i = 0; $i< $res->num_rows; $i++){
            array_push($row , $res->fetch_assoc()["palabra"]);
            }
        }
        return $row;
    }
    
    $datos = getPalabrotas();

    echo (json_encode($datos));
?>