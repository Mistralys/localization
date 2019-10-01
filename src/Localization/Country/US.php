<?php
/**
 * File containing the {@link Localization_Country_US} class.
 * @package Application
 * @subpackage Localization
 * @see Localization_Country_US
 */

namespace AppLocalize;

/**
 * Country class with the definitions for Germany.
 *
 * @package Application
 * @subpackage Localization
 * @author Sebastian Mordziol <s.mordziol@mistralys.com>
 * @link http://www.mistralys.com
 */
class Localization_Country_US extends Localization_Country
{
    public function getNumberThousandsSeparator()
    {
        return ',';
    }

    public function getNumberDecimalsSeparator()
    {
        return '.';
    }

    public function getLabel()
    {
        return t('United States');
    }

    public function getCurrencyID()
    {
        return 'CAD';
    }
}