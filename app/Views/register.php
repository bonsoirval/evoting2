
<div class="container" style="padding:100px;">
    <div class="row">
        <div class="col-sm-12" style="border:2px outset gray;">
            <div class="page-header text-center">
                <h3 class="specialHead">Register!.. </h3>
            </div>
                    <?= session()->getFlashdata('error') ?>
                    <?php print(form_open('register')); ?>
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="email">First Name :</label>
                        <?php echo form_input($firstname); ?>
                    </div>																				
                    <div class="form-group">
                        <label for="lastname">Lastname : </label>
                        <?php echo form_input($lastname); ?>
                    </div>
                    <div class="form-group">	
                        <label for="email">Email : </label>
                        <?php echo form_input($email); ?>
                    </div>
                    <div class="form-group">
                        <label for="username">Username : </label>
                        <?php echo form_input($username); ?>
                    </div>
                    <div class="form-groupd">
                        <label for='state'>State : </label>
                        <?php print(form_dropdown('region', $options,'select', $extra = array('class' => 'form-control'))); ?>
                    </div>
                    <div class="form-group">
                        <label for="nin">NIN : </label>
                        <?php  echo form_input($nin); ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Password : </label>
                        <?php echo  form_input($password); ?>
                    </div>
                    <div class="form-group">
                        <label for="passconf">Repeat Password : </label>
                        <?php echo  form_input($passconf); ?>
                    </div>				
                    <div class="form-group">
                        <input id="register" name="register" type="submit" value="Register">
                    </div>

                    </form>
            <br><br>
        </div>
    </div>
</div>
