var UsuarioActual = jQuery.parseJSON( sessionStorage.getItem('userLogin') );

$('#IniciarSesion').click( function (event) {
    event.preventDefault();
    alerta = '';
    data   = {
        username : $('#lusuario').val(),
        clave    : $('#lclave').val()
    };

    $.post('../../ApiREST/UsuariosCtrl/Logear',
        {datos : data},
        function (res) {
            if (res.estado == 1) {
                alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
                alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                alerta += res.mensaje + '</div>';
                sessionStorage.setItem('userLogin', JSON.stringify(res.usuario));
                Recargar("../../FrontEnd/PanelControl/");
            } else {
                alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
                alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                alerta += res.mensaje + '</div>';
            }
            $('#alertas').html('');
            $('#alertas').append(alerta);           
        }
    )
});

$('#CrearNuevoUser').click(function(event){
    event.preventDefault();

    if ( !( $('#regusuario').val() == '' || $('#regclave').val() == '' ) ) {
        alerta = '';
        data   = {
            regusuario : $('#regusuario').val(),
            regclave   : $('#regclave').val(),
            regrol     : $('#regrol').val(),
            regestado  : $('#regestado').val()
        };

        $.post('../../ApiREST/UsuariosCtrl/Registrar',
            { datos : data },
            function (res) {
                if (res.estado == 1) {
                    alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
                    alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    alerta += res.mensaje + '</div>';
                } else {
                    alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
                    alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    alerta += res.mensaje + '</div>';
                }
                $('#regalertas').append(alerta);
            }
        )
    }
});