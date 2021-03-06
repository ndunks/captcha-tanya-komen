jQuery(function ($) {
    var field_count = 0;
    function ctk_add(tanya, jawab) {
        var field = $($('template#ctk-field')[0].content.cloneNode(true));
        if (typeof tanya == 'string') field.find('.ctk-field-tanya').val(tanya);
        if (typeof jawab == 'string') field.find('.ctk-field-jawab').val(jawab);
        field.find('tr').addClass('ctk-bind-' + field_count++);
        field.find('.ctk-action button').on('click', ctk_del);

        $('#ctk-setting table.form-table tbody').append(field);
    }
    function ctk_del() {
        if (confirm("Hapus pertanyaan ini?")) {
            $('.' + $(this).parents('tr').attr('class')).remove();
        }
    }

    $('#ctk-setting').data('values').forEach((v, i, a) => {
        ctk_add(v.tanya, v.jawab);
    });
    $('.ctk-button-add').on('click', ctk_add);
})