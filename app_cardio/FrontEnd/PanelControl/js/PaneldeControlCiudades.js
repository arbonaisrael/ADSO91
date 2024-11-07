var Ciudades = [];

$('#agregarCiudad').click(function(event) {
	$('#CrearNuevoCiudad').removeClass('hidden');
	$('#EditarCiudad').addClass('hidden');
});

$('#CancelarCrearCiudad').click(function(event) {
	$('#CrearNuevoCiudad').addClass('hidden');
});

$('#CancelarActualizarCiudad').click(function(event) {
	$('#EditarCiudad').addClass('hidden');
});

$('#CrearNuevoCiudad').submit(function(event) {
    alerta = '';
    datos = {
        id_ciudad : $('#insciuid').val(),
        nombre : $('#insciunom').val()
    }
    $.post('../../ApiREST/CiudadesCtrl/Registrar', 
        {datos: datos}, 
        function(data) {
            if(data.estado == 1){
                alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
                alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                alerta += data.mensaje+'</div>';
                $('#CrearNuevoCiudad').addClass('hidden');
                listarCiudad();
            }else{
                alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
                alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                alerta += data.mensaje+'</div>';
            }

            $('#alertas_ciudades').html(alerta);
        }
    );
    return false;
});

function listarCiudad(){
	$.post('../../ApiREST/CiudadesCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#Ciudades_detalle').html('');
				Ciudades = data.lciudad;
				$.each(Ciudades, function(index, val) {
					cade = '';
					cade += '<tr class="white">';
					cade += '<td>'+val.lis_id_ciudad+'</td>';
					cade += '<td>'+val.lis_nombre+'</td>';
					cade += '<td class="edit" onclick="EditarCiudad('+index+')"><center><span class="glyphicon glyphicon-pencil"></span></center></td>';
					cade +='</tr>';
					$('#Ciudades_detalle').append(cade);
				});
			}
		}
	);
}

function EditarCiudad(index){
	$('#EditarCiudad').removeClass('hidden');
	$('#CrearNuevoCiudad').addClass('hidden');
	
	$('#editciudad').val(Ciudades[index].lis_id_ciudad);
	$('#editnomciu').val(Ciudades[index].lis_nombre);
}

$('#EditarCiudad').submit(function(event) {
		alerta = '';
		datos = {
			id_ciudad : $('#editciudad').val(),
			nombre : $('#editnomciu').val()
		}
		ActualizarCiudad(datos);
		$('#EditarCiudad').addClass('hidden');
		return false;
});


function ActualizarCiudad(datos){
	alerta = '';
	$.post('../../ApiREST/CiudadesCtrl/Actualizar', 
			{datos: datos}, 
			function(data) {
				if(data.estado == 1){
					alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
					$('#EditarBarrio').addClass('hidden');
					listarCiudad();
				}else{
					alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
				}

				$('#alertas_ciudades').html(alerta);
			}
		);
}