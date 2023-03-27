<?php
//use app\core\form\Form;
/** @var $model \app\models\User */
?>
<h1>Register</h1>
<?php
 $form= \app\core\form\Form::begin('','post');?>
 <div class="row">
    <div class="col">
      <?php echo $form->field($model,'firstname');?>
    </div>
    <div class="col">
      <?php echo $form->field($model,'lastname');?>
    </div>
</div>
<?php
echo $form->field($model,'email');
echo $form->field($model,'password')->passwordField();
echo $form->field($model,'confirmpassword')->passwordField();?>
<div class="form-group">
    <button class="btn btn-primary" type="submit">Submit form</button>
  </div>
<?php
  \app\core\form\Form::end();
?>
