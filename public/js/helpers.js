jQuery.fn.extend({
    hideModal: function () {
        var modal = $(this);
        modal.modal('hide');
    },
    setDateTime: function () {
        var input = $(this);
        input.datetimepicker({
            locale: 'es',
            format: 'DD/MM/YYYY',
        }).inputmask('dd/mm/yyyy');

    },
    clearInput: function () {
        var input = $(this);
        input.val('');
    },
    getCosto: function (subtotal, cantidad) {
        if (subtotal && cantidad) {
            var input = $(this);
            var result = parseFloat(subtotal) / parseFloat(cantidad);
            input.val(result.toFixed(2));
        }
    },

});