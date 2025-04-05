$(function () {
    $('.btn-sign-in').click(function (event) {
        event.preventDefault();
        var login = $('#login').val();
        var clave = $('#clave').val();
        $.ajax({
            type: "POST",
            url: "../negocio/NUsuario.php?funcion=login",
            data: {login: login, clave: clave},

            success: function (data) {
                if (parseInt(data) === 1) {
                    location.href = '../vista/insumos/index_insumo.php';

                } else {
                    alert('Usuario no registrado');
                }
            }

        });
    });
});