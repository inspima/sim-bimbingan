<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
    
function formtext($type, $name, $value, $required) {
    $form = '<input type="'.$type.'" name="'.$name.'" value="'.$value.'" class="form-control" placeholder="" '.$required.'>';
    return($form); 
}

function formtext_angka($type, $name, $value, $required) {
    $form = '<input type="'.$type.'" name="'.$name.'" value="'.$value.'" class="form-control" placeholder="" onkeypress="return hanyaAngka(event)"'.$required.'>';
    return($form); 
}

function formtext_password($type, $name, $value, $required) {
    $form = '<input type="'.$type.'" name="'.$name.'" value="'.$value.'" class="form-control" placeholder="" onkeypress="return hanyaAngka(event)"'.$required.'>';
    return($form); 
}


function formtext_datepicker($name, $value, $required){
    $form = '<input type="text" name="'.$name.'" value="'.$value.'" class="form-control pull-right" id="datepicker" '.$required.'>';
    return($form); 
}

function formtext_datemask($type, $name, $value, $required) {
    $alias = 'alias';
    $format = 'dd/mm/yyyy';
    $form = '
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                <input type="'.$type.'" name="'.$name.'" value="'.$value.'" class="form-control" data-inputmask="'.'&#39;'.$alias.'&#39;'.':'.'&#39;'.$format.'&#39;'.'" data-mask required>
            </div>';
    return($form); 
}

function formeditor($name, $required, $value){
    $form = '<textarea class="form-control" name="'.$name.'" '.$required.'>'.$value.'</textarea>';
    return($form); 
}

function formareacount($name, $required){
    $form = '<textarea class="form-control" name="'.$name.'" id="description" maxlength="150" onKeyDown="textCounter(this.description.description,this.form.countDisplays);" onKeyUp="textCounter(this.form.deskripsi,this.form.countDisplays);" '.$required.'></textarea>';
    return($form); 
}

function formfile($name, $value, $required) {
    $form = '<input type="file" name="'.$name.'" class="form-control" '.$required.'>';
    return($form); 
}


                  

?>
