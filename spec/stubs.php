<?php

function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)
{
    $actionParams = array($tag, $function_to_add, $priority, $accepted_args);
    return $actionParams;
}
