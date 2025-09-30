<?php

function Role ($role){
    switch ($role):
        case 'super_admin':
            $rol = 'مدیر ارشد';
            break;
        case 'admin':
            $rol = 'مدیر پروژه';
            break;
        case 'developer':
            $rol = 'توسعه دهنده';
            break;
        case 'user':
            $rol = 'کاربر عادی';
            break;  
        default:
            $rol = "";
            break;
    endswitch;

    return $rol;
}

function color_preference_style ($preference){
                        
    switch ($preference) :
        case 'بالا' :
            $color = 'high';
            break;
        case 'متوسط' :
            $color = 'medium';
            break;
        case 'پایین' :
            $color = 'low';
            break;
    endswitch;

    return $color;
}

function color_status_style ($preference){
                        
    switch ($preference) :
        case 'برای انجام' :
            $color = 'todo';
            break;
        case 'در حال انجام' :
            $color = 'inprogress';
            break;
        case 'بازبینی' :
            $color = 'review';
            break;
        case 'انجام شده' :
            $color = 'done';
            break;
    endswitch;

    return $color;
}

function status ($status){
    switch ($status):
        case 'active':
            $result = 'فعال';
            break;
        case 'inactive':
            $result = 'غیرفعال';
            break;
    endswitch;

    return $result;
}