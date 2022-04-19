<?php
if (!function_exists('round_down')) {
    function round_down($number, $nearest)
    {
        return $number - fmod($number, $nearest);
    }
}
