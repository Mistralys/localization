<?php

namespace AppLocalize;

use AppLocalize\Localization\Countries\CountryInterface;
use AppLocalize\Localization\Currencies\BaseCurrency;

class Localization_Currency_USD extends BaseCurrency
{
    public const ISO_CODE = 'USD';

    public function getSingular() : string
    {
        return t('Dollar');
    }

    public function getSymbol() : string
    {
        return '$';
    }

    public function getPlural() : string
    {
        return t('Dollars');
    }
    
    public function getISO() : string
    {
        return self::ISO_CODE;
    }

    public function isNamePreferred() : bool
    {
        return false;
    }

    public function isSymbolOnFront() : bool
    {
        return true;
    }

    public function getStructuralTemplate(?CountryInterface $country=null) : string
    {
        return '-{symbol}{amount}';
    }
}