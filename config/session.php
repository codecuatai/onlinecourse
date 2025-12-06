<?php
function setSession($key, $value)
{
    if (!empty(session_id())) {
        $_SESSION[$key] = $value;
        return true;
    }
    return false;
}

function getSession($key = '')
{
    if (empty($key)) {
        return $_SESSION;
    } else {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }
    return False;
}

function removeSession($key = '')
{
    if (empty($key)) {
        session_destroy();
        return true;
    } else {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
        return true;
    }
    return False;
}

//tạo session flash
function setSessionFlash($key, $value)
{
    $key1 = $key . "Flash";

    $rel = setSession($key1, $value);
    return $rel;
}
function getSessionFlash($key = '')
{
    $key1 = $key . "Flash";
    $rel = getSession($key1);

    removeSession($key1);
    return $rel;
}
