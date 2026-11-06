<?php

function oldValue($field)
{
    if (isset($_SESSION[$field])) {
        $value =  $_SESSION[$field];
        unset($_SESSION[$field]);
        return $value ; 
    }
    
}
