var ControlUsuarios = false;
var ControlBarrios  = false;
var ControlCiudades = false;

var UsuarioActual   = jQuery.parseJSON(sessionStorage.getItem('userLogin'));


$('#CerrarSesion').click(function(event){
    sessionStorage.removeItem('userLogin');
    Recargar("../../FrontEnd/PanelControl/");
});

$('#ControlPanelUser').click(function(event) {
    if (!ControlUsuarios){
        $('#n_img').addClass('hidden');
        listarUsers();
        ControlUsuarios = true;
    } else {
        ControlUsuarios = false;
        $('#n_img').removeClass('hidden');
    }
});

$('#ControlPanelBarrio').click(function(event) {
    if (!ControlBarrios){
        $('#n_img').addClass('hidden');
        listarBarrios();
        ControlBarrios = true;
    } else {
        ControlBarrios = false;
        $('#n_img').removeClass('hidden');
    }
});

$('#ControlPanelCiudad').click(function(event) {
	if(!ControlCiudades){
		$('#n_img').addClass('hidden');
		listarCiudad();
		ControlCiudades = true;
	}else{
		ControlCiudades = false;
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