<?php
/**
name pattern
    AbstractFactory
Description
    AbstractFactory относиться к классу порождающих паттернов. Его основное назначение - предоставить интерфейс для создания семейства взаимосвязанных объектов, не специфицируя их классы.
 php code example
*/

 /* Form */

 abstract class FormAbstract
 {
 }

 class WindowsForm extends FormAbstract
 {
 }

 class LinuxForm extends FormAbstract
 {
 }

 class WebForm extends FormAbstract
 {
 }

 /* Button */

 abstract class ButtonAbstract
 {
 }

 class WindowsButton extends ButtonAbstract
 {
 }

 class LinuxButton extends ButtonAbstract
 {
 }

 class WebButton extends ButtonAbstract
 {
 }

 /* Label */

 abstract class LabelAbstract
 {
 }

 class WindowsLabel extends LabelAbstract
 {
 }

 class LinuxLabel extends LabelAbstract
 {
 }

 class WebLabel extends LabelAbstract
 {
 }

 /* Factory */

 abstract classFormBuilder
 {
     abstract public function createForm();

     abstract public function createButton();

     abstract public function createLabel();
 }

 class WindowsFormBuilder extends FormBuilder
 {
     public function createForm()
     {
         return new WindowsForm();
     }

     public function createButton()
     {
         return new WindowsButton();
     }

     public function createLabel()
     {
         return new WindowsLabel();
     }
 }

 class LinuxFormBuilder extends FormBuilder
 {
     public function createForm()
     {
         return newLinuxForm();
     }

     public function createButton()
     {
         return new LinuxButton();
     }

     public function createLabel()
     {
         return new LinuxLabel();
     }
 }

 class WebFormBuilder extends FormBuilder
 {
     public function createForm()
     {
         return new WebForm();
     }

     public function createButton()
     {
         return new WebButton();
     }

     public function createLabel()
     {
         return new WebLabel();
     }
 }

 $builder = new LinuxFormBuilder();
 $form = $builder->createForm();
 $button = $builder->createButton();
 $label = $builder->createLabel();
 function createScreen(
     FormAbstract $form,
     ButtonAbstract $button,
     LabelAbstract $label
 )
 {
     //create screen
 }

 createScreen($form, $button, $label);
```