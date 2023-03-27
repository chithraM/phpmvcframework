<?php
//use app\core\form\Form;
/** @var $model \app\models\User */
?>
<h1>Login</h1>
<?php
 $form= \app\core\form\Form::begin('','post');?>
<?php
echo $form->field($model,'email');
echo $form->field($model,'password')->passwordField();
?>
    <button class="btn btn-primary" type="submit">Submit</button>
<?php
  \app\core\form\Form::end();
?>
