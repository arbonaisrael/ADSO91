var Hipertension_Arterial = [];
var Pacientes = [];
var Medicamentos = [];

$('#CancelarCrearHipercolesterolemia').click(function(event) {
	$('#CrearNuevoHipercolesterolemia').addClass('hidden');
});

$('#CancelarActualizarHipercolesterolemia').click(function(event) {
	$('#EditarHipercolesterolemia').addClass('hidden');
});


$('#agregarHipercolesterolemia').click(function(event) {
	$('#CrearNuevoHipercolesterolemia').removeClass('hidden');
	$('#EditarHipercolesterolemia').addClass('hidden');

    $.post('../../ApiREST/PacientesCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#nhid_cedula').html('');
				Pacientes = data.lpacientes;
				$.each(Pacientes, function(index, val) {
						cade = '';
						cade += '<option value="'+val.id_cedula+'">'+val.nombres+' '+ val.apellidos +'</option>';
						$('#nhid_cedula').append(cade);
				});
			}
		}
	);

	$.post('../../ApiREST/MedicamentosCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#nhid_medicamento1').html('');
				Medicamentos = data.lmedicamento;
				$.each(Medicamentos, function(index, val) {
						cade = '';
						cade += '<option value="'+val.lis_id_medicamento+'">'+val.lis_nombre+'</option>';
						$('#nhid_medicamento1').append(cade);
				});
			}
		}
	);

	$.post('../../ApiREST/MedicamentosCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#nhid_medicamento2').html('');
				Medicamentos = data.lmedicamento;
				$.each(Medicamentos, function(index, val) {
						cade = '';
						cade += '<option value="'+val.lis_id_medicamento+'">'+val.lis_nombre+'</option>';
						$('#nhid_medicamento2').append(cade);
				});
			}
		}
	);

});

$('#CrearNuevoHipercolesterolemia').submit(function(event) {
	    alerta = '';
		datos = {
			id_cedula : $('#nhid_cedula').val(), 
		    fec_realizacion_exa : $('#nhfec_realizacion_exa').val(), 
			cons_medico_general : $('#nhcons_medico_general').val(), 
			cons_enfermeria : $('#nhcons_enfermeria').val(), 
			cons_nutricion : $('#nhcons_nutricion').val(), 
			glicemia_basal : $('#nhglicemia_basal').val(), 
			hemoglobin : $('#nhhemoglobin').val(), 
			hematocritos : $('#nhhematocritos').val(), 
			colesterol_total : $('#nhcolesterol_total').val(), 
			colesterol_hdl : $('#nhcolesterol_hdl').val(), 
			trigliceridos : $('#nhtrigliceridos').val(),  
			creatinina : $('#nhcreatinina').val(), 
			uroanalisis : $('#nhuroanalisis').val(), 
			ekg : $('#nhekg').val(), 
			id_medicamento1 : $('#nhid_medicamento1').val(),
			id_medicamento2 : $('#nhid_medicamento2').val(),			 
			edu_grupal : $('#nhedu_grupal').val(), 
			observaciones : $('#nhobservaciones').val(), 
			acciones_realizar : $('#nhacciones_realizar').val() 
		}

		$.post('../../ApiREST/HipercolesterolemiaCtrl/Registrar', 
			{datos: datos}, 
			function(data) {
				if(data.estado == 1){
					alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
					$('#CrearNuevoHipercolesterolemia').addClass('hidden');
					listarHipercolesterolemia();
				}else{
					alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
				}

				$('#alertas_hipercolesterolemia').html(alerta);
			}
		);	
		return false;
});

function EditarHipercolesterolemia(index){
	$('#EditarHipercolesterolemia').removeClass('hidden');
	$('#CrearNuevoHipercolesterolemia').addClass('hidden');

    $.post('../../ApiREST/PacientesCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#ehid_cedula').html('');
				Pacientes = data.lpacientes;
				$.each(Pacientes, function(index, val) {
						cade = '';
						cade += '<option value="'+val.id_cedula+'">'+val.nombres+' '+ val.apellidos +'</option>';
						$('#ehid_cedula').append(cade);
				});
			}
		}
	);

	$.post('../../ApiREST/MedicamentosCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#ehid_medicamento1').html('');
				Medicamentos = data.lmedicamento;
				$.each(Medicamentos, function(index, val) {
						cade = '';
						cade += '<option value="'+val.lis_id_medicamento+'">'+val.lis_nombre+'</option>';
						$('#ehid_medicamento1').append(cade);
				});
			}
		}
	);

	$.post('../../ApiREST/MedicamentosCtrl/Listar',
		{datos: null},
		function(data) {		
			if(data.estado == 1){
				$('#ehid_medicamento2').html('');
				Medicamentos = data.lmedicamento;
				$.each(Medicamentos, function(index, val) {
						cade = '';
						cade += '<option value="'+val.lis_id_medicamento+'">'+val.lis_nombre+'</option>';
						$('#ehid_medicamento2').append(cade);
				});
			}
		}
	);

    $('#ehid_hipercolesterolemia').val(Hipercolesterolemia[index].id_hipercolesterolemia);
	$('#ehid_cedula').val(Hipercolesterolemia[index].id_cedula); 
    $('#ehfec_realizacion_exa').val(Hipercolesterolemia[index].fec_realizacion_exa);
	$('#ehcons_medico_general').val(Hipercolesterolemia[index].cons_medico_general); 
	$('#ehcons_enfermeria').val(Hipercolesterolemia[index].cons_enfermeria); 
	$('#ehcons_nutricion').val(Hipercolesterolemia[index].cons_nutricion);
	$('#ehglicemia_basal').val(Hipercolesterolemia[index].glicemia_basal); 
	$('#ehhemoglobin').val(Hipercolesterolemia[index].hemoglobin);
	$('#ehhematocritos').val(Hipercolesterolemia[index].hematocritos);
	$('#ehcolesterol_total').val(Hipercolesterolemia[index].colesterol_total);
	$('#ehcolesterol_hdl').val(Hipercolesterolemia[index].colesterol_hdl);
	$('#ehtrigliceridos').val(Hipercolesterolemia[index].trigliceridos);
	$('#ehcreatinina').val(Hipercolesterolemia[index].creatinina);
	$('#ehuroanalisis').val(Hipercolesterolemia[index].uroanalisis);
	$('#ehekg').val(Hipercolesterolemia[index].ekç);
	$('#ehid_medicamento1').val(Hipercolesterolemia[index].id_medicamento1);
	$('#ehid_medicamento2').val(Hipercolesterolemia[index].id_medicamento2);	 
    $('#ehedu_grupal').val(Hipercolesterolemia[index].edu_grupal);
	$('#ehobservaciones').val(Hipercolesterolemia[index].observaciones);
	$('#ehacciones_realizar').val(Hipercolesterolemia[index].acciones_realizar);
}

$('#EditarHipercolesterolemia').submit(function(event) {
		alerta = '';
		datos = {
            id_hipercolesterolemia : $('#ehid_hipercolesterolemia').val(), 
			id_cedula : $('#ehid_cedula').val(),  
			fec_realizacion_exa : $('#ehfec_realizacion_exa').val(), 
			cons_medico_general : $('#ehcons_medico_general').val(),
			cons_enfermeria : $('#ehcons_enfermeria').val(),
			cons_nutricion : $('#ehcons_nutricion').val(),
			glicemia_basal : $('#ehglicemia_basal').val(),
			hemoglobin : $('#ehhemoglobin').val(),
			hematocritos : $('#ehhematocritos').val(),
			colesterol_total : $('#ehcolesterol_total').val(),
			colesterol_hdl : $('#ehcolesterol_hdl').val(),
			trigliceridos : $('#ehtrigliceridos').val(),
			creatinina : $('#ehcreatinina').val(),
			uroanalisis : $('#ehuroanalisis').val(),
			ekg : $('#ehekg').val(),
			id_medicamento1 : $('#ehid_medicamento1').val(),
			id_medicamento2 : $('#ehid_medicamento2').val(),
			edu_grupal : $('#ehedu_grupal').val(),
			observaciones : $('#ehobservaciones').val(),
			acciones_realizar : $('#ehacciones_realizar').val()
			
		}
		ActualizarHipercolesterolemia(datos);
		$('#EditarHipercolesterolemia').addClass('hidden');
		return false;
});




function ActualizarHipercolesterolemia(datos){
	alerta = '';
	$.post('../../ApiREST/HipercolesterolemiaCtrl/Actualizar', 
			{datos: datos}, 
			function(data) {
				if(data.estado == 1){
					alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
					$('#EditarHipercolesterolemia').addClass('hidden');
					listarHipercolesterolemia();
				}else{
					alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
					alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alerta += data.mensaje+'</div>';
				}

				$('#alertas_hipercolesterolemia').html(alerta);
			}
		);
} 


function listarHipercolesterolemia(){
	$.post('../../ApiREST/HipercolesterolemiaCtrl/Listar',
		{datos: null},
		function(data) {
			if(data.estado == 1){
				$('#Hipercolesterolemia_detalle').html('');
				Hipercolesterolemia = data.Hipercolesterolemia;
				$.each(Hipercolesterolemia, function(index, val) {
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
					cade += '<td class="edit" onclick="EditarHipercolesterolemia('+index+')"><center><span class="glyphicon glyphicon-pencil"></span></center></td>';
					cade +='</tr>';
					$('#Hipercolesterolemia_detalle').append(cade);
				});
			}
		}
	);
}
