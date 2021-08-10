<?php

namespace AppLocalize\Locale;

use AppLocalize\Localization_Locale;
use function AppLocalize\t;

class de_AT extends Localization_Locale
{
    public function getLabel() : string
    {
        return t('German (Austria)');
    }
}
