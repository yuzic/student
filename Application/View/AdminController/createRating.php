<form method="post" id="subject-form">
<fieldset>
    <legend>Добавление/редактирование оценок пользователя <?php echo $this->user['email'];?></legend>
    <?php foreach ($this->subjectList as $data):?>
        <fieldset><label><?php echo $data['name'];?> </label><br>
                  <input name="subject_<?php echo $data['id'];?>">
        </fieldset>
    <?php endforeach; ?>
    <fieldset>
        <input type="hidden" name="userId" value="<?php echo $this->user['id'];?>">
        <input type="submit" value="Сохранить">
    </fieldset>
</fieldset>
</form>
