<?php
/**
 * File containing the {@link Localization_Country_DE} class.
 * @package Localization
 * @subpackage Countries
 * @see Localization_Country_DE
 */

namespace AppLocalize;

use AppLocalize\Localization\Countries\BaseCountry;

/**
 * Country class with the definitions for Germany.
 *
 * @package Localization
 * @subpackage Countries
 * @author Sebastian Mordziol <s.mordziol@mistralys.eu>
 * @link http://www.mistralys.com
 */
class Localization_Country_DE extends BaseCountry
{
    public const ISO_CODE = 'de';

    public function getCode(): string
    {
        return self::ISO_CODE;
    }

    public function getNumberThousandsSeparator() : string
    {
        return '.';
    }

    public function getNumberDecimalsSeparator() : string
    {
        return ',';
    }

    public function getLabel() : string
    {
        return t('Germany');
    }

    public function getCurrencyISO() : string
    {
        return Localization_Currency_EUR::ISO_CODE;
    }
}
