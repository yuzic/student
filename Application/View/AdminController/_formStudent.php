<form class="registration-form" method="post" id="registration-form">
  <fieldset>
    <legend>Добавление/редактирование студента</legend>
      <fieldset>
          <input type="email" name="email" placeholder="email" required>
      </fieldset>
      <fieldset>
          <input type="password" name="password" placeholder="Пароль" required>
      </fieldset>
      <fieldset>
        <input type="text" name="firstName" placeholder="Имя" required>
      </fieldset>
      <fieldset>
        <input type="text" name="surname" placeholder="Фамилия" required>
      </fieldset>
      <fieldset>
          <input type="text" name="groupId" placeholder="№ Группы" value="1" required>
      </fieldset>
      <fieldset>
          <input type="date" name="dob" placeholder="Дата рождения">
      </fieldset>
      <fieldset>
          <input type="submit" value="Отправить">
      </fieldset>
  </fieldset>
</form>
