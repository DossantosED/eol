<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function getFormValidationErrors($fields) {
    $errors = [];
    foreach ($fields as $field) {
        $error = form_error($field);
        if (!empty($error)) {
            $errors[$field] = strip_tags($error);
        }
    }
    return $errors;
}
