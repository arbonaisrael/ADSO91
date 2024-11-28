var Hipertension_Arterial = [];
var Pacientes = [];
var Medicamentos = [];

$('#CancelarCrearHipertension_Arterial').click(function(event) {
	$('#CrearNuevoHipertension_Arterial').addClass('hidden');
});

$('#CancelarActualizarHipertension_Arterial').click(function(event) {
	$('#EditarHipertension_Arterial').addClass('hidden');
});


$('#agregarHipertension_Arterial').click(function(event) {
	$('#CrearNuevoHipertension_Arterial').removeClass('hidden');
	$('#EditarHipertension_Arterial').addClass('hidden');

    $.post('../../ApiREST/PacientesCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#nhaid_cedula').html('');
				Pacientes = data.lpacientes;
				$.each(Pacientes, function(index, val) {
						cade = '';
						cade += '<option value="'+val.id_cedula+'">'+val.nombres+' '+ val.apellidos +'</option>';
						$('#nhaid_cedula').append(cade);
				});
			}
		}
	);

	$.post('../../ApiREST/MedicamentosCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#nhaid_medicamento').html('');
				Medicamentos = data.lmedicamento;
				$.each(Medicamentos, function(index, val) {
						cade = '';
						cade += '<option value="'+val.lis_id_medicamento+'">'+val.lis_nombre+'</option>';
						$('#nhaid_medicamento').append(cade);
				});
			}
		}
	);

});

$('#CrearNuevoHipertension_Arterial').submit(function(event) {
	    alerta = '';
		datos = {
			id_cedula : $('#nhaid_cedula').val(), 
		    fec_realizacion_exa : $('#nhafec_realizacion_exa').val(), 
		    cf_tensionales : $('#nhacf_tensionales').val(), 
			tm_signos_vitales : $('#nhatm_signos_vitales').val(), 
			cons_medico_general : $('#nhacons_medico_general').val(), 
			cons_enfermeria : $('#nhacons_enfermeria').val(), 
			cons_nutricion : $('#nhacons_nutricion').val(), 
			glicemia_basal : $('#nhaglicemia_basal').val(), 
			hemoglobin : $('#nhahemoglobin').val(), 
			hematocritos : $('#nhahematocritos').val(), 
			colesterol_total : $('#nhacolesterol_total').val(), 
			colesterol_hdl : $('#nhacolesterol_hdl').val(), 
			trigliceridos : $('#nhatrigliceridos').val(), 
			potasio : $('#nhapotasio').val(), 
			creatinina : $('#nhacreatinina').val(), 
			uroanalisis : $('#nhauroanalisis').val(), 
			ekg : $('#nhaekg').val(), 
			id_medicamento : $('#nhaid_medicamento').val(), 
			edu_grupal : $('#nhaedu_grupal').val(), 
			observaciones : $('#nhaobservaciones').val(), 
			acciones_realizar : $('#nhaacciones_realizar').val() 
		}

		$.post('../../ApiREST/Hipertension_ArterialCtrl/Registrar', 
			{datos: datos}, 
			function(data) {
				if(data.estado == 1){
					alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
					$('#CrearNuevoHipertension_Arterial').addClass('hidden');
					listarHipertension_Arterial();
				}else{
					alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
				}

				$('#alertas_hipertension_arterial').html(alerta);
			}
		);	
		return false;
});

function EditarHipertension_Arterial(index){
	$('#EditarHipertension_Arterial').removeClass('hidden');
	$('#CrearNuevoHipertension_Arterial').addClass('hidden');

    $.post('../../ApiREST/PacientesCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#ehaid_cedula').html('');
				Pacientes = data.lpacientes;
				$.each(Pacientes, function(index, val) {
						cade = '';
						cade += '<option value="'+val.id_cedula+'">'+val.nombres+' '+ val.apellidos +'</option>';
						$('#ehaid_cedula').append(cade);
				});
			}
		}
	);

	$.post('../../ApiREST/MedicamentosCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#ehaid_medicamento').html('');
				Medicamentos = data.lmedicamento;
				$.each(Medicamentos, function(index, val) {
						cade = '';
						cade += '<option value="'+val.lis_id_medicamento+'">'+val.lis_nombre+'</option>';
						$('#ehaid_medicamento').append(cade);
				});
			}
		}
	);

    $('#ehaid_hiper_arterial').val(Hipertension_Arterial[index].id_hiper_arterial);
	$('#ehaid_cedula').val(Hipertension_Arterial[index].id_cedula); 
    $('#ehafec_realizacion_exa').val(Hipertension_Arterial[index].fec_realizacion_exa);
    $('#ehacf_tensionales').val(Hipertension_Arterial[index].cf_tensionales);
	$('#ehatm_signos_vitales').val(Hipertension_Arterial[index].tm_signos_vitales); 
	$('#ehacons_medico_general').val(Hipertension_Arterial[index].cons_medico_general); 
	$('#ehacons_enfermeria').val(Hipertension_Arterial[index].cons_enfermeria); 
	$('#ehacons_nutricion').val(Hipertension_Arterial[index].cons_nutricion);
	$('#ehaglicemia_basal').val(Hipertension_Arterial[index].glicemia_basal); 
	$('#ehahemoglobin').val(Hipertension_Arterial[index].hemoglobin);
	$('#ehahematocritos').val(Hipertension_Arterial[index].hematocritos);
	$('#ehacolesterol_total').val(Hipertension_Arterial[index].colesterol_total);
	$('#ehacolesterol_hdl').val(Hipertension_Arterial[index].colesterol_hdl);
	$('#ehatrigliceridos').val(Hipertension_Arterial[index].trigliceridos);
	$('#ehapotasio').val(Hipertension_Arterial[index].potasio);
	$('#ehacreatinina').val(Hipertension_Arterial[index].creatinina);
	$('#ehauroanalisis').val(Hipertension_Arterial[index].uroanalisis);
	$('#ehaekg').val(Hipertension_Arterial[index].ekç);
	$('#ehaid_medicamento').val(Hipertension_Arterial[index].id_medicamento); 
    $('#ehaedu_grupal').val(Hipertension_Arterial[index].edu_grupal);
	$('#ehaobservaciones').val(Hipertension_Arterial[index].observaciones);
	$('#ehaacciones_realizar').val(Hipertension_Arterial[index].acciones_realizar);
}

$('#EditarHipertension_Arterial').submit(function(event) {
		alerta = '';
		datos = {
            id_hiper_arterial : $('#ehaid_hiper_arterial').val(), 
			id_cedula : $('#ehaid_cedula').val(),  
			fec_realizacion_exa : $('#ehafec_realizacion_exa').val(), 
			cf_tensionales : $('#ehacf_tensionales').val(),
			tm_signos_vitales : $('#ehatm_signos_vitales').val(),
			cons_medico_general : $('#ehacons_medico_general').val(),
			cons_enfermeria : $('#ehacons_enfermeria').val(),
			cons_nutricion : $('#ehacons_nutricion').val(),
			glicemia_basal : $('#ehaglicemia_basal').val(),
			hemoglobin : $('#ehahemoglobin').val(),
			hematocritos : $('#ehahematocritos').val(),
			colesterol_total : $('#ehacolesterol_total').val(),
			colesterol_hdl : $('#ehacolesterol_hdl').val(),
			trigliceridos : $('#ehatrigliceridos').val(),
			potasio : $('#ehapotasio').val(),
			creatinina : $('#ehacreatinina').val(),
			uroanalisis : $('#ehauroanalisis').val(),
			ekg : $('#ehaekg').val(),
			id_medicamento : $('#ehaid_medicamento').val(),
			edu_grupal : $('#ehaedu_grupal').val(),
			observaciones : $('#ehaobservaciones').val(),
			acciones_realizar : $('#ehaacciones_realizar').val(),
			
		}
		ActualizarHipertension_Arterial(datos);
		$('#EditarHipertension_Arterial').addClass('hidden');
		return false;
});

function ActualizarHipertension_Arterial(datos){
	alerta = '';
	$.post('../../ApiREST/Hipertension_ArterialCtrl/Actualizar', 
			{datos: datos}, 
			function(data) {
				if(data.estado == 1){
					alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
					$('#EditarHipertension_Arterial').addClass('hidden');
					listarHipertension_Arterial();
				}else{
					alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
				}

				$('#alertas_hipertension_arterial').html(alerta);
			}
		);
} 


function listarHipertension_Arterial(){
	$.post('../../ApiREST/Hipertension_ArterialCtrl/Listar',
		{datos: null},
		function(data) {
			if(data.estado == 1){
				$('#Hipertension_Arterial_detalle').html('');
				Hipertension_Arterial = data.Hipertension_Arterial;
				$.each(Hipertension_Arterial, function(index, val) {
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
					cade += '<td>'+val.nombrem+'</td>';
					cade += '<td class="edit" onclick="EditarHipertension_Arterial('+index+')"><center><span class="glyphicon glyphicon-pencil"></span></center></td>';
					cade +='</tr>';
					$('#Hipertension_Arterial_detalle').append(cade);
				});
			}
		}
	);
}
