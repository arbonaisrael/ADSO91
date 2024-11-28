var Deabetes = [];
var Pacientes = [];
var Medicamentos = [];

$('#CancelarCrearDeabetes').click(function(event) {
	$('#CrearNuevoDeabetes').addClass('hidden');
});

$('#CancelarActualizarDeabetes').click(function(event) {
	$('#EditarDeabetes').addClass('hidden');
});


$('#agregarDeabetes').click(function(event) {
	$('#CrearNuevoDeabetes').removeClass('hidden');
	$('#EditarDeabetes').addClass('hidden');

    $.post('../../ApiREST/PacientesCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#ndid_cedula').html('');
				Pacientes = data.lpacientes;
				$.each(Pacientes, function(index, val) {
						cade = '';
						cade += '<option value="'+val.id_cedula+'">'+val.nombres+' '+ val.apellidos +'</option>';
						$('#ndid_cedula').append(cade);
				});
			}
		}
	);

	$.post('../../ApiREST/MedicamentosCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#ndid_medicamento1').html('');
				Medicamentos = data.lmedicamento;
				$.each(Medicamentos, function(index, val) {
						cade = '';
						cade += '<option value="'+val.lis_id_medicamento+'">'+val.lis_nombre+'</option>';
						$('#ndid_medicamento1').append(cade);
				});
			}
		}
	);

	$.post('../../ApiREST/MedicamentosCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#ndid_medicamento2').html('');
				Medicamentos = data.lmedicamento;
				$.each(Medicamentos, function(index, val) {
						cade = '';
						cade += '<option value="'+val.lis_id_medicamento+'">'+val.lis_nombre+'</option>';
						$('#ndid_medicamento2').append(cade);
				});
			}
		}
	);

});

$('#CrearNuevoDeabetes').submit(function(event) {
	    alerta = '';
		datos = {
			id_cedula : $('#ndid_cedula').val(), 
		    fec_realizacion_exa : $('#ndfec_realizacion_exa').val(), 
			cons_medico_general : $('#ndcons_medico_general').val(), 
			cons_enfermeria : $('#ndcons_enfermeria').val(), 
			cons_nutricion : $('#ndcons_nutricion').val(), 
			
			hemoglobina : $('#ndhemoglobina').val(),  
			colesterol_total : $('#ndcolesterol_total').val(), 
			colesterol_hdl : $('#ndcolesterol_hdl').val(), 
			trigliceridos : $('#ndtrigliceridos').val(),  
			creatinina : $('#ndcreatinina').val(), 
			uroanalisis : $('#nduroanalisis').val(), 
			ekg : $('#ndekg').val(), 
			id_medicamento1 : $('#ndid_medicamento1').val(),
			id_medicamento2 : $('#ndid_medicamento2').val(),			 
			edu_grupal : $('#ndedu_grupal').val(), 
			observaciones : $('#ndobservaciones').val(), 
			acciones_realizar : $('#ndacciones_realizar').val() 
		}

		$.post('../../ApiREST/DeabetesCtrl/Registrar', 
			{datos: datos}, 
			function(data) {
				if(data.estado == 1){
					alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
					$('#CrearNuevoDeabetes').addClass('hidden');
					listarDeabetes();
				}else{
					alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
				}

				$('#alertas_deabetes').html(alerta);
			}
		);	
		return false;
});

function EditarDeabetes(index){
	$('#EditarDeabetes').removeClass('hidden');
	$('#CrearNuevoDeabetes').addClass('hidden');

    $.post('../../ApiREST/PacientesCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#edid_cedula').html('');
				Pacientes = data.lpacientes;
				$.each(Pacientes, function(index, val) {
						cade = '';
						cade += '<option value="'+val.id_cedula+'">'+val.nombres+' '+ val.apellidos +'</option>';
						$('#edid_cedula').append(cade);
				});
			}
		}
	);

	$.post('../../ApiREST/MedicamentosCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#edid_medicamento1').html('');
				Medicamentos = data.lmedicamento;
				$.each(Medicamentos, function(index, val) {
						cade = '';
						cade += '<option value="'+val.lis_id_medicamento+'">'+val.lis_nombre+'</option>';
						$('#edid_medicamento1').append(cade);
				});
			}
		}
	);

	$.post('../../ApiREST/MedicamentosCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#edid_medicamento2').html('');
				Medicamentos = data.lmedicamento;
				$.each(Medicamentos, function(index, val) {
						cade = '';
						cade += '<option value="'+val.lis_id_medicamento+'">'+val.lis_nombre+'</option>';
						$('#edid_medicamento2').append(cade);
				});
			}
		}
	);

    $('#edid_deabetes').val(Deabetes[index].id_deabetes);
	$('#edid_cedula').val(Deabetes[index].id_cedula); 
    $('#edfec_realizacion_exa').val(Deabetes[index].fec_realizacion_exa);
	$('#edcons_medico_general').val(Deabetes[index].cons_medico_general); 
	$('#edcons_enfermeria').val(Deabetes[index].cons_enfermeria); 
	$('#edcons_nutricion').val(Deabetes[index].cons_nutricion);
	$('#edhemoglobina').val(Deabetes[index].hemoglobina);
	$('#edcolesterol_total').val(Deabetes[index].colesterol_total);
	$('#edcolesterol_hdl').val(Deabetes[index].colesterol_hdl);
	$('#edtrigliceridos').val(Deabetes[index].trigliceridos);
	$('#edcreatinina').val(Deabetes[index].creatinina);
	$('#eduroanalisis').val(Deabetes[index].uroanalisis);
	$('#edekg').val(Deabetes[index].ekç);
	$('#edid_medicamento1').val(Deabetes[index].id_medicamento1);
	$('#edid_medicamento2').val(Deabetes[index].id_medicamento2);	 
    $('#ededu_grupal').val(Deabetes[index].edu_grupal);
	$('#edobservaciones').val(Deabetes[index].observaciones);
	$('#edacciones_realizar').val(Deabetes[index].acciones_realizar);
}

$('#EditarDeabetes').submit(function(event) {
		alerta = '';
		datos = {
            id_deabetes : $('#edid_deabetes').val(), 
			id_cedula : $('#edid_cedula').val(),  
			fec_realizacion_exa : $('#edfec_realizacion_exa').val(), 
			cons_medico_general : $('#edcons_medico_general').val(),
			cons_enfermeria : $('#edcons_enfermeria').val(),
			cons_nutricion : $('#edcons_nutricion').val(),
			hemoglobina : $('#edhemoglobina').val(),
			colesterol_total : $('#edcolesterol_total').val(),
			colesterol_hdl : $('#edcolesterol_hdl').val(),
			trigliceridos : $('#edtrigliceridos').val(),
			creatinina : $('#edcreatinina').val(),
			uroanalisis : $('#eduroanalisis').val(),
			ekg : $('#edekg').val(),
			id_medicamento1 : $('#edid_medicamento1').val(),
			id_medicamento2 : $('#edid_medicamento2').val(),
			edu_grupal : $('#ededu_grupal').val(),
			observaciones : $('#edobservaciones').val(),
			acciones_realizar : $('#edacciones_realizar').val()	
		}
		ActualizarDeabetes(datos);
		$('#EditarDeabetes').addClass('hidden');
		return false;
});




function ActualizarDeabetes(datos){
	alerta = '';
	$.post('../../ApiREST/DeabetesCtrl/Actualizar', 
			{datos: datos}, 
			function(data) {
				if(data.estado == 1){
					alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
					$('#EditarDeabetes').addClass('hidden');
					listarDeabetes();
				}else{
					alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
				}

				$('#alertas_deabetes').html(alerta);
			}
		);
} 


function listarDeabetes(){
	$.post('../../ApiREST/DeabetesCtrl/Listar',
		{datos: null},
		function(data) {
			if(data.estado == 1){
				$('#Deabetes_detalle').html('');
				Deabetes = data.Deabetes;
				$.each(Deabetes, function(index, val) {
					cade = '';
					cade += '<tr class="white">';
					cade += '<td>'+val.id_cedula+'</td>';
					cade += '<td>'+val.nombrep +' '+ val.apellidop +'</td>';
					cade += '<td>'+val.fec_realizacion_exa+'</td>';
					if(val.cons_medico_general == 1)
						cade += '<td>Si</td>';
					else
						cade += '<td>No</td>';
					if(val.cons_enfermeria == 1)
						cade += '<td>Si</td>';
					else
						cade += '<td>No</td>';
                    if(val.cons_nutricion == 1)
						cade += '<td>Si</td>';
					else
						cade += '<td>No</td>';
					cade += '<td>'+val.nombrem1+'</td>';
					cade += '<td class="edit" onclick="EditarDeabetes('+index+')"><center><span class="glyphicon glyphicon-pencil"></span></center></td>';
					cade +='</tr>';
					$('#Deabetes_detalle').append(cade);
				});
			}
		}
	);
}
