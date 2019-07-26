<?php 

function create($class, $attr = [])
{
    return factory($class)->create($attr);
}

function make($class, $times)
{
    return factory($class)->times($times)->create();
}