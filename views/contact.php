<?php
//use app\core\view;
/* @var $model \app\models\ContactForm */

use app\core\form\TextareaFiled;

$this->title='Contact';
?>
<h1>Contact</h1>
<?php
 $form= \app\core\form\Form::begin('','post');?>
<?php
echo $form->field($model,'subject');
echo $form->field($model,'email');
echo new TextareaFiled($model,'body');
?>
    <button class="btn btn-primary" type="submit">Submit</button>
<?php
  \app\core\form\Form::end();
?>
