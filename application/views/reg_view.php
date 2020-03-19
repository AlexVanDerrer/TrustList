<div class="container mx-auto text-center align-self-center">
    <div class="row">
        <div class="col">
        <h1 class='text-white'>Список доверия</h1>
        </div>
    </div>
    
</div>

<div class="container mx-auto text-center align-self-center form-center justify-content-center" >
<h3 class='text-white pb-3'>Регистрация</h3>
<?php echo form_open('registration'); ?>
<div class="form-group">
    <?php echo form_error('regUsername'); ?>
    <input value="<?php echo set_value('regUsername'); ?>" name="regUsername" type="text" class="form-control br-20 mx-auto" id="regUsername" placeholder="Логин">
  </div>
  <div class="form-group">
  <?php echo form_error('regEmail'); ?>
    <input value="<?php echo set_value('regEmail'); ?>" name="regEmail" type="email" class="form-control br-20 mx-auto" id="regEmail" aria-describedby="emailHelp" placeholder="example@gmail.com">
  </div>
  <div class="form-group">
  <?php echo form_error('regTel'); ?>
    <input value="<?php echo set_value('regTel'); ?>" name="regTel" type="tel" class="form-control br-20 mx-auto" id="regTel" placeholder="Телефон">
  </div>
  <div class="form-group">
  <?php echo form_error('regPassword'); ?>
    <input value="<?php echo set_value('regPassword'); ?>" name="regPassword" type="password" class="form-control br-20 mx-auto" id="regPassword" placeholder="Пароль">
  </div>
  <div class="form-group">
  <?php echo form_error('regPasswordConf'); ?>
    <input value="<?php echo set_value('regPasswordConf'); ?>" name="regPasswordConf" type="password" class="form-control br-20 mx-auto" id="regPasswordConf" placeholder="Подтверждение пароля">
  </div>

  <button type="submit" name="reg" value='ok' class="btn btn-light br-20">Зарегистрироваться</button>
</form>
</div>
