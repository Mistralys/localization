<?php
/**
 * File containing the {@link Localization_Writer} class.
 * 
 * @package Localization
 * @subpackage Translator
 * @see Localization_Writer
 */

namespace AppLocalize;

use AppUtils\FileHelper;

/**
 * Utility used to write localized strings to an ini file.
 *
 * @package Localization
 * @subpackage Translator
 * @author Sebastian Mordziol <s.mordziol@mistralys.eu>
 */
class Localization_Writer
{
   /**
    * @var boolean
    */
    private $editable = false;
    
   /**
    * @var array<string,string>
    */
    private $hashes = array();
    
   /**
    * @var Localization_Locale
    */
    private $locale;
    
   /**
    * @var string
    */
    private $fileType;
    
   /**
    * @var string
    */
    private $filePath;
    
    public function __construct(Localization_Locale $locale, string $fileType, string $filePath)
    {
        $this->locale = $locale;
        $this->fileType = $fileType;
        $this->filePath = $filePath;
    }
    
    public function makeEditable() : Localization_Writer
    {
        $this->editable = true;
        
        return $this;
    }
    
    public function addHash(string $hash, string $text) : Localization_Writer
    {
        $this->hashes[$hash] = $text;
        
        return $this;
    }
    
    public function addHashes(array $hashes) : Localization_Writer
    {
        foreach($hashes as $hash => $text)
        {
            $this->addHash($hash, $text);
        }
        
        return $this;
    }
    
    public function writeFile() : void
    {
        $content = 
        $this->renderHead().
        $this->renderHashes();
        
        FileHelper::saveFile($this->filePath, $content);
    }
    
    private function renderHashes() : string
    {
        $hashes = $this->compileHashes();
        $lines = array();
        
        foreach($hashes as $entry)
        {
            $lines[] = sprintf(
                '%s= "%s"',
                $entry['hash'],
                addslashes($entry['text'])
            );
        }
        
        $lines[] = '';
        
        return implode(PHP_EOL, $lines);
    }
    
    private function renderHead() : string
    {
        $title = strtoupper($this->fileType).' TRANSLATION FILE FOR ' . strtoupper($this->locale->getLabel());
        
        $lines = array();
        
        $lines[] = '; -------------------------------------------------------';
        $lines[] = '; '. $title;
        $lines[] = '; -------------------------------------------------------';
        $lines[] = '; ';
        
        if($this->editable) 
        {
            $lines[] = '; You may edit text directly in this file under the following conditions:';
            $lines[] = '; ';
            $lines[] = '; 1) Do not to modify the keys (left hand side of the = sign)';
            $lines[] = '; 2) Save the file as UTF-8 without BOM';
        } 
        else 
        {
            $lines[] = '; Do NOT edit this file directly! It depends on the main translation file';
            $lines[] = '; and any changes will be lost. Edit the main file instead.';
        }
        
        $lines[] = PHP_EOL;
        
        return implode(PHP_EOL, $lines);
    }
    
    private function compileHashes() : array
    {
        $hashes = array();
        
        foreach($this->hashes as $hash => $text)
        {
            $hashes[] = array(
                'hash' => $hash,
                'text' => $text
            );
        }
        
        usort($hashes, array($this, 'callback_sortStrings'));
        
        return $hashes;
    }
    
   /**
    * Sort the strings to ensure they always appear in the same order:
    * first by text, and same strings by their hashes. This is important
    * for strings that have the same translation to avoid them changing
    * order between sorts.
    *
    * @param array $a
    * @param array $b
    * @return number
    */
    public function callback_sortStrings(array $a, array $b) : int
    {
        $result = strnatcasecmp($a['text'], $b['text']);
        
        if($result === 0) 
        {
            return strnatcmp($a['hash'], $b['hash']);
        }
        
        return $result;
    }
}
