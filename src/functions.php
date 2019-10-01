<?php

namespace AppLocalize;

/**
 * Translates the specified string by looking up the
 * translations table. Returns the translated string
 * according to the current application locale.
 *
 * Not to confound with content locales! This function
 * serves only for translations within the UI itself,
 * not user contents.
 *
 * If no translation is found, returns the original string.
 *
 * Use the sister function {@link pt()} to translate
 * and echo a string directly.
 *
 * @return string
 * @see pt()
 */
function t()
{
    $arguments = func_get_args();
    
    return call_user_func_array(
        array(Localization::getTranslator(), 'translate'),
        $arguments
    );
}

/**
 * Same as the {@link t()} function, but echos the
 * translated string.
 *
 * @see t()
 */
function pt()
{
    $arguments = func_get_args();
    echo call_user_func_array(
        array(Localization::getTranslator(), 'translate'),
        $arguments
    );
}

/**
 * Translates the result of a dynamic string, e.g.
 *
 * td($stringName);
 *
 * This is required to avoid these calls showing up
 * as regular translateable strings when using the
 * translation scanner that searches for t() calls.
 *
 * @return mixed
 */
function td()
{
    $arguments = func_get_args();
    
    return call_user_func_array(
        array(Localization::getTranslator(), 'translate'),
        $arguments
    );
}

/**
 * Same as the {@link td()} function, but echos the translated string.
 *
 * @see td()
 */
function ptd()
{
    $arguments = func_get_args();
    echo call_user_func_array(
        array(Localization::getTranslator(), 'translate'),
        $arguments
    );
}