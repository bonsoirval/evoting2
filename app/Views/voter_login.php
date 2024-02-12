<?php ?>
<br/><br/><br/><br/><br/><br/><br/><br/>

<div class="container">
  <h2><center>Imo State University, Online Voting System<center></h2>
  <?= validation_list_errors() ?>
	  <?= form_open(base_url('login'), $attributes = array('class'=>'', 'id' => ''))?>
    <?= csrf_field() ?>
    <div class="form-group">
      <label for="email">Email:</label>
      <?= form_input($username); ?>
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <?= form_input($password); ?>
    </div>
    <?= form_button($submit); ?>
  <?= form_close(); ?>
</div>