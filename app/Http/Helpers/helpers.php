<?php

function toHrsView($minutes)
{
    $negative = false;
    if ($minutes < 0) {
        $negative = true;
        $minutes = abs($minutes);
    }
    $result = (intval($minutes / 60)) . ':' . (($minutes % 60 < 10) ? '0' . $minutes % 60 : $minutes % 60);
    $result = $negative ? "-" . $result : $result;

    return $result;
}

function fromDateView($date, $day = true)
{
    if ($day) {
        return date('l, d-m-Y', strtotime($date));
    }
    return date('d-m-Y', strtotime($date));

}

function notificatonsStatus($status)
{

    switch ($status) {
        case 1:
            return 'Submitted by Employee';
            break;
        case 2:
            return 'Aproved by Manager';
            break;
        default:
            return 'Open';
            break;
    }

}
