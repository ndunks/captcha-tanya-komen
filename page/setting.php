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