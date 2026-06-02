<?php 

use Carbon\Carbon;

/**
 * Format carbon
 * 
 * @param {String} $date.
 */
function carbon($date = null, $format = null)
{ 
    if (!$date)
        return Carbon::now();

    try
    {
        if (!$format)
            return Carbon::createFromFormat('Y-m-d H:i:s', $date);

        return Carbon::createFromFormat($format, $date);
    } 
    catch(\Exception $e)
    {
        return null;
    }
}

/**
 * Format carbon
 * 
 * @param {Integer} $price.
 */
function price($price, $decimal = 0) 
{
    return number_format($price / 100, $decimal, ',', ' ');
}