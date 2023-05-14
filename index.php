<?php

// Include the functions file
require_once('functions.php');

// Check if the user_name and user_email fields in the form have been filled out
if(@$_POST['user_name'] != "" && $_POST['user_email'] != "") {
    
    // Call the check_user function
    check_user();
}

// If the fields haven't been filled out, include the form_tpl.php file
else {
    include('form_tpl.php');
}