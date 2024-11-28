var Cum_Programas = [];
var Pacientes = [];



$('#CancelarCrearCum_Programa').click(function(event) {
	$('#CrearNuevoCum_Programa').addClass('hidden');
});

$('#CancelarActualizarCum_Programa').click(function(event) {
	$('#EditarCum_Programa').addClass('hidden');
});


$('#agregarCum_Programa').click(function(event) {
	$('#CrearNuevoCum_Programa').removeClass('hidden');
	$('#EditarCum_Programa').addClass('hidden');

    $.post('../../ApiREST/PacientesCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#ncpid_cedula').html('');
				Pacientes = data.lpacientes;
				$.each(Pacientes, function(index, val) {
						cade = '';
						cade += '<option value="'+val.id_cedula+'">'+val.nombres+' '+ val.apellidos +'</option>';
						$('#ncpid_cedula').append(cade);
				});
			}
		}
	);

});

$('#CrearNuevoCum_Programa').submit(function(event) {
	    alerta = '';
		datos = {
			id_cedula           : $('#ncpid_cedula').val(),
			fec_ingreso         : $('#ncpfec_ingreso').val(),
			fec_egreso          : $('#ncpfec_egreso').val(),
			causa_egreso        : $('#ncpcausa_egreso').val(),
			fec_hospitalizacion : $('#ncpfec_hospitalizacion').val(),
		}

		$.post('../../ApiREST/Cum_ProgramasCtrl/Registrar', 
			{datos: datos}, 
			function(data) {
				if(data.estado == 1){
					alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
					$('#CrearNuevoCum_Programa').addClass('hidden');
					listarCum_Programa();
				}else{
					alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
				}

				$('#alertas_cum_programas').html(alerta);
			}
		);	
		return false;
});

function EditarCum_Programa(index){
	$('#EditarCum_Programa').removeClass('hidden');
	$('#CrearNuevoCum_Programa').addClass('hidden');

    $.post('../../ApiREST/PacientesCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#ecpid_cedula').html('');
				Pacientes = data.lpacientes;
				$.each(Pacientes, function(index, val) {
						cade = '';
						cade += '<option value="'+val.id_cedula+'">'+val.nombres+' '+ val.apellidos +'</option>';
						$('#ecpid_cedula').append(cade);
				});
			}
		}
	);

    $('#ecpid_programa').val(Cum_Programas[index].id_programa);
	$('#ecpid_cedula').val(Cum_Programas[index].id_cedula);
	$('#ecpfec_ingreso').val(Cum_Programas[index].fec_ingreso);
	$('#ecpfec_egreso').val(Cum_Programas[index].fec_egreso);
	$('#ecpcausa_egreso').val(Cum_Programas[index].causa_egreso);
	$('#ecpfec_hospitalizacion').val(Cum_Programas[index].fec_hospitalizacion);
	
}

$('#EditarCum_Programa').submit(function(event) {
		alerta = '';
		datos = {
			id_programa         : $('#ecpid_programa').val(),
			id_cedula           : $('#ecpid_cedula').val(),
			fec_ingreso         : $('#ecpfec_ingreso').val(),
			fec_egreso          : $('#ecpfec_egreso').val(),
			causa_egreso        : $('#ecpcausa_egreso').val(),
			fec_hospitalizacion : $('#ecpfec_hospitalizacion').val(),
			
		}
		ActualizarCum_Programa(datos);
		$('#EditarCum_Programa').addClass('hidden');
		return false;
});

function ActualizarCum_Programa(datos){
	alerta = '';
	$.post('../../ApiREST/Cum_ProgramasCtrl/Actualizar', 
			{datos: datos}, 
			function(data) {
				if(data.estado == 1){
					alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
					$('#EditarCum_Programa').addClass('hidden');
					listarCum_Programa();
				}else{
					alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
				}

				$('#alertas_cum_programas').html(alerta);
			}
		);
} 


function listarCum_Programa(){
	$.post('../../ApiREST/Cum_ProgramasCtrl/Listar',
		{datos: null},
		function(data) {
			if(data.estado == 1){
				$('#Cum_Programas_detalle').html('');
				Cum_Programas = data.Cum_Programas;
				$.each(Cum_Programas, function(index, val) {
					cade = '';
					cade += '<tr class="white">';
					cade += '<td>'+val.id_cedula+'</td>';
					cade += '<td>'+val.nombres +' '+ val.apellidos +'</td>';
					cade += '<td>'+val.fec_ingreso+'</td>';
					cade += '<td>'+val.fec_egreso+'</td>';
					cade += '<td>'+val.fec_hospitalizacion+'</td>';
					cade += '<td class="edit" onclick="EditarCum_Programa('+index+')"><center><span class="glyphicon glyphicon-pencil"></span></center></td>';
					cade +='</tr>';
					$('#Cum_Programas_detalle').append(cade);
				});
			}
		}
	);
}
