<?php
return [
   'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
   'checkboxContainer' => '<div class="form-group {{required}}">{{content}}</div>',
   'inputContainerError' => '<div class="form-group input {{type}}{{required}} error">{{content}}{{error}}</div>',
   'error' => '<div class="error-message">{{content}}</div>',
   'label' => '<label{{attrs}}>{{text}}</label>',
   'input' => '<input type="{{type}}" name="{{name}}"{{attrs}} />',
   'formGroup' => '{{label}}{{input}}',
   'checkboxFormGroup' => '<div class="icheck"><div class="square-blue single-row"><div class="checkbox icheckCheckboxFrame">{{checkbox}}{{label}}</div></div></div>',
   'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
   'optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
   'select' => '<select name="{{name}}"{{attrs}} class="form-control">{{content}}</select>',
   'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
   'button' => '<button class="btn btn-primary" {{attrs}}>{{text}}</button>'
];
?>