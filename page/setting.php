<style type="text/css">
#ctk-setting table.form-table tr:nth-child(odd) td {
    padding-bottom: 2px;
}

#ctk-setting table.form-table tr:nth-child(even) {
    border-bottom: 2px solid #dddddd;
}

#ctk-setting table.form-table tr td:nth-child(2) input {
    width: 100%;
}

#ctk-setting .ctk-button-add {
    margin-top: 22px;
    display: block;
    margin-right: auto;
    margin-left: auto;
    line-height: 20px;
}

#ctk-setting .ctk-action {
    float: right;
}
</style>
<template id="ctk-field">
    <tr>
        <td>Pertanyaan
            <div class="ctk-action">
                <button type="button" class="ctk-button-del dashicons-before dashicons-trash"></button>
            </div>
        </td>
        <td>
            <input name="tanya[]" class="ctk-field-tanya" type="text" class="regular-text" />
        </td>
    </tr>
    <tr>
        <td>Jawaban</td>
        <td>
            <input name="jawab[]" class="ctk-field-jawab" type="text" class="regular-text" />
        </td>
    </tr>
</template>
<form method="POST" id="ctk-setting" data-values="<?php echo esc_attr(json_encode(self::$config['pertanyaan'])) ?>">
    <h1>Pengaturan Pertanyaan Keamanan</h1>
    <p>Pertanyaan ini bertujuan untuk meminimalisir spam komentar, sehingga akan tampil secara acak pada kolom komentar.
    </p>
    <p>Huruf besar dan kecil tidak berpengaruh.</p>
    <table class="form-table">
        <tbody>
        </tbody>
    </table>
    <button type="button" class="button ctk-button-add dashicons-before dashicons-plus">Tambah Pertanyaan</button>
    <p class="submit">
        <input type="submit" name="submit" class="button button-primary" value="Simpan">
    </p>
</form>
<script type="text/javascript">
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
</script>