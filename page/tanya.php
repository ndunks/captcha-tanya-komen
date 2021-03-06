<div class="form-group comment-form-jawab">
    <h4>Pertanyaan Keamanan</h4>
    <label for="jawab"><?php echo $pertanyaan ?> <span class="required">*</span></label>
    <input id="jawab" name="jawab" type="text" class="form-control" required size="30" maxlength="200"/>
    <input name="tanya" type="hidden" value="<?= $tanya ?>"/>
</div>
