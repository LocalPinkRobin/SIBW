<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";


    $mysqli = new mysqli ("mysql", "Mari", "1999verde", "SIBW");
    if ($mysqli->connect_errno){
        echo ("Fallo al conectar: " . $mysqli->connect_error);
    }

    $res = $mysqli->query("SELECT id, nombre FROM eventos WHERE publicado = true AND (nombre LIKE '%".$_POST['busqueda']."%' OR contenido LIKE '%".$_POST['busqueda']."%')");

    $resul ='';

    if ($res->num_rows>0){
        while ($row = $res->fetch_assoc()){
            $resul.= '    <a href="evento.php?ev='.$row['id'].'" class="barra_busqueda_resultado">
                            <div class="barra_busqueda_titulo">
                                '.$row['nombre'].'
                            </div>
                        </a>';

        }           

    } 
    $mysqli->close();
    echo $resul;



?>