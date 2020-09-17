$(document).ready(function(){
    $('#buscador').keyup(function(){
        var resul = $(this).val();

        if(resul != ''){
            $('#caja_resul').html('');
            $.ajax({
                url: "llamada_ajax.php",
                method: "post",
                data:{busqueda:resul},
                dataType: "text",
                success: function(data){
                    $('#caja_resul').html(data);
                }
            });
        } else {
            $('#caja_resul').html('');
        }
    });
});