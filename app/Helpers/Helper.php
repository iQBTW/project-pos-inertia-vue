<?php

function currencyFormat($value)
{
    return number_format($value);
}

function invoiceNumber()
{
    return 'INV-' . rand(1000, 9999) . time();
}
