<?php

function GetSecretKey($path)
{

    $key = file_get_contents($path);

    return $key;

}
