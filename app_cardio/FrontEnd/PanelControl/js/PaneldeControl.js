var ControlUsuarios              = false;
var ControlBarrios               = false;
var ControlCiudades              = false;
var ControlMedicamentos          = false;
var ControlPacientes             = false;
var ControlCum_Programas         = false;
var ControlHipertension_Arterial = false;
var ControlHipercolesterolemia   = false;
var ControlDeabetes              = false;

var UsuarioActual = jQuery.parseJSON(sessionStorage.getItem('userLogin'));


$('#CerrarSesion').click(function (event) {
    sessionStorage.removeItem('userLogin');
    Recargar("../../FrontEnd/PanelControl/");
});

$('#ControlPanelUser').click(function (event) {
    if (!ControlUsuarios) {
        listarUsers();
        ControlUsuarios = true;
    } else {
        ControlUsuarios = false;

    }
});

$('#ControlPanelBarrio').click(function (event) {
    if (!ControlBarrios) {
        listarBarrios();
        ControlBarrios = true;
    } else {
        ControlBarrios = false;
    }
});

$('#ControlPanelCiudad').click(function (event) {
    if (!ControlCiudades) {
        listarCiudad();
        ControlCiudades = true;
    } else {
        ControlCiudades = false;
    }
});

$('#ControlPanelMedicamento').click(function (event) {
    if (!ControlMedicamentos) {
        listarMedicamento();
        ControlMedicamentos = true;
    } else {
        ControlMedicamentos = false;
    }
});

$('#ControlPanelPaciente').click(function (event) {
    if (!ControlPacientes) {
        listarPaciente();
        ControlPacientes = true;
    } else {
        ControlPacientes = false;
    }
});

$('#ControlPanelCum_Programa').click(function(event) {
	if(!ControlCum_Programas){
		listarCum_Programa();
		ControlCum_Programas = true;
	}else{
		ControlCum_Programas = false;
	}
});

$('#ControlPanelHipertension_Arterial').click(function(event) {
	if(!ControlHipertension_Arterial){
		listarHipertension_Arterial();
		ControlHipertension_Arterial = true;
	}else{
		ControlHipertension_Arterial = false;
	}
});

$('#ControlPanelHipercolesterolemia').click(function(event) {
	if(!ControlHipercolesterolemia){
		listarHipercolesterolemia();
		ControlHipercolesterolemia = true;
	}else{
		ControlHipercolesterolemia = false;
	}
});

$('#ControlPanelDeabetes').click(function(event) {
	if(!ControlDeabetes){
		listarDeabetes();
		ControlDeabetes = true;
	}else{
		ControlDeabetes = false;
	}
});

jQuery(document).ready(function () {
    $(".oculto").hide();
    $(".inf").click(function () {
        var nodo = $(this).attr("href");

        if ($(nodo).is(":visible")) {
            $(nodo).hide();
            return false;
        } else {
            $(".oculto").hide("slow");
            $(nodo).fadeToggle("fast");
            $('#n_img').addClass('hidden');
            return false;
        }
    });
});

jQuery(document).ready(function () {
    $('.date').datetimepicker({
        format: 'YYYY-MM-DD'
    });
});


jQuery(document).ready(function () {
    
    $('.IEfec_nac').datetimepicker({
        format: 'YYYY-MM-DD'
    }).on('dp.change', function(e){ 
        var formatedValue = e.date.format(e.date._f);
        $('#npedad').val(calcularAnos(formatedValue)); 
    });

    $('.AEfec_nac').datetimepicker({
        format: 'YYYY-MM-DD'
    }).on('dp.change', function(e){ 
        var formatedValue = e.date.format(e.date._f);
        $('#epedad').val(calcularAnos(formatedValue)); 
    });

});


function calcularAnos(fechaNacimiento) {
    var hoy         = new Date();
    var fnacimiento = new Date(fechaNacimiento)
    var edad        = hoy.getFullYear() - fnacimiento.getFullYear();
    var mes         = hoy.getMonth() - fnacimiento.getMonth();

    if (mes < 0 || (mes === 0 && hoy.getDate() < fnacimiento.getDate())) {
        edad--;
    }        
    return edad;
}