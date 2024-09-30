<?php

function currencyFormat($value)
{
    return number_format($value);
}

function invoiceNumber()
{
    return 'INV-' . rand(1000, 9999);
}

function statusToString($value)
{
    if ($value === 0) {
        return $value = 'Belum Lunas';
    }
    else if ($value === 1) {
        return $value = 'Lunas';
    }
}
