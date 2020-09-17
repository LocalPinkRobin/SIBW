var palabrasProhibidas; 


function render(data){
    var html = "<div class ='commentBox'><div class='leftPanelImg'></div><div class = 'rightPanel'><span>"+data.name+"</span><div class = 'email'>" +data.email +"</div><div class = 'date'>" +data.date +"</div><p>"+data.body+"</p></div><div class = 'clear'> </div></div>"
    $('#container').append(html);

}

function traerPalabras() {
    $.ajax({
      url: '/palabrotas.php',
      type: 'post',
      success: function(data) {
        palabrasProhibidas = JSON.parse(data);
        console.log(palabrasProhibidas);
      },
    })
  }

  


function editComment(){
    var textarea = document.getElementById('bodyText');
    
    console.log(palabrasProhibidas);

    for (var palabrota of palabrasProhibidas){
        
        textarea.value = textarea.value.replace(palabrota,"*".repeat(palabrota.length));
    }
}



$(document).ready(function(){
    traerPalabras(); 

    
    $(closeNav).click(function closeNav(){
        document.getElementById("seccion").style.display = "none";
    });
    $(openNav).click(function openNav(){
        document.getElementById("seccion").style.display = "block";
    });






});
