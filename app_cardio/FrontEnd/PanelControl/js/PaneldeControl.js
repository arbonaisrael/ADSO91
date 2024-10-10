var ControlUsuarios = false;

var UsuarioActual   = jQuery.parseJSON(sessionStorage.getItem('userLogin'));


$('#CerrarSesion').click(function(event){
    sessionStorage.removeItem('userLogin');
    Recargar("../../FrontEnd/PanelControl/");
});

$('#ControlPanelUser').click(function(event) {
    if (!ControlUsuarios){
        $('#n_img').addClass('hidden');
        // listarUsers();
        ControlUsuarios = true;
    } else {
        ControlUsuarios = false;
        $('#n_img').removeClass('hidden');
    }
});


jQuery(document).ready(function(){
    $(".oculto").hide();              
      $(".inf").click(function(){
            var nodo = $(this).attr("href");  
   
            if ($(nodo).is(":visible")){
                 $(nodo).hide();
                 return false;
            }else{
          $(".oculto").hide("slow");                             
          $(nodo).fadeToggle("fast");
          return false;
            }
      });
  });