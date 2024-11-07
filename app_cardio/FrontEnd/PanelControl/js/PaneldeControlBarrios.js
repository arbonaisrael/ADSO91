$('#agregarBarrio').click(function(event) {
	$('#CrearNuevoBarrio').removeClass('hidden');
	$('#EditarBarrio').addClass('hidden');
});

$('#CancelarCrearBarrio').click(function(event) {
	$('#CrearNuevoBarrio').addClass('hidden');
});

$('#CancelarActualizarBarrio').click(function(event) {
	$('#EditarBarrio').addClass('hidden');
});

function listarBarrios(){
	$.post('../../ApiREST/BarriosCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#Barrios_detalle').html('');
				Barrios = data.lbarrios;
				$.each(Barrios, function(index, val) {
					cade = '';
					cade += '<tr class="white">';
					cade += '<td>'+val.lis_id_barrio+'</td>';
					cade += '<td>'+val.lis_nombre+'</td>';
					cade += '<td class="edit" onclick="EditarBarrio('+index+')"><center><span class="glyphicon glyphicon-pencil"></span></center></td>';
					cade +='</tr>';
					$('#Barrios_detalle').append(cade);
				});
			}
		}
	);
}

$('#CrearNuevoBarrio').submit(function(event) {
    alerta = '';
    datos = {
        nombre : $('#insbarnom').val()
    }
    $.post('../../ApiREST/BarriosCtrl/Registrar', 
        {datos: datos}, 
        function(data) {
            if(data.estado == 1){
                alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
                alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                alerta += data.mensaje+'</div>';
                $('#CrearNuevoBarrio').addClass('hidden');
                listarBarrios();
            }else{
                alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
                alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                alerta += data.mensaje+'</div>';
            }

            $('#alertas_barrios').html(alerta);
        }
    );
    return false;
});


function EditarBarrio(index){
	$('#EditarBarrio').removeClass('hidden');
	$('#CrearNuevoBarrio').addClass('hidden');
	
	$('#editbarid').val(Barrios[index].lis_id_barrio);
	$('#editbarnom').val(Barrios[index].lis_nombre);
}

$('#EditarBarrio').submit(function(event) {
		alerta = '';
		datos = {
			id_barrio : $('#editbarid').val(),
			nombre : $('#editbarnom').val()
		}
		ActualizarBarrio(datos);
		$('#EditarBarrio').addClass('hidden');
		return false;
});

function ActualizarBarrio(datos){
	alerta = '';
	$.post('../../ApiREST/BarriosCtrl/Actualizar', 
			{datos: datos}, 
			function(data) {
				if(data.estado == 1){
					alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
					$('#EditarBarrio').addClass('hidden');
					listarBarrios();
				}else{
					alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
				}

				$('#alertas_barrios').html(alerta);
			}
		);
} 