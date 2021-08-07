<?php

declare(strict_types=1);

namespace AppLocalize;

use AppUtils\FileHelper;
use DirectoryIterator;

class Localization_Source_Folder extends Localization_Source
{
   /**
    * The folder under which all translatable files are kept.
    * @var string
    */
    protected $sourcesFolder;
    
   /**
    * @var string
    */
    protected $id;

   /**
    * @param string $alias An alias for this source, to recognize it by.
    * @param string $label The human-readable label, used in the editor.
    * @param string $group A human-readable group label to group several sources by. Used in the editor.
    * @param string $storageFolder The folder in which to store the localization files.
    * @param string $sourcesFolder The folder in which to analyze files to find translatable strings.
    */
    public function __construct(string $alias, string $label, string $group, string $storageFolder, string $sourcesFolder)
    {
        parent::__construct($alias, $label, $group, $storageFolder);
        
        $this->sourcesFolder = $sourcesFolder;
        $this->id = md5($sourcesFolder);
    }
    
    public function getID() : string
    {
        return $this->id;
    }
    
    public function getSourcesFolder() : string
    {
        return $this->sourcesFolder;
    }

    /**
     * @var array<string,string[]>
     */
    protected $excludes = array(
        'folders' => array(),
        'files' => array()
    );
    
    public function excludeFolder(string $folder) : Localization_Source_Folder
    {
        if(!in_array($folder, $this->excludes['folders'])) {
            $this->excludes['folders'][] = $folder;
        }
        
        return $this;
    }
    
    public function excludeFolders(array $folders) : Localization_Source_Folder
    {
        foreach($folders as $folder) {
            $this->excludeFolder($folder);
        }
        
        return $this;
    }
    
    public function excludeFiles(array $files) : Localization_Source_Folder
    {
        $this->excludes['files'] = array_merge($this->excludes['files'], $files);
        return $this;
    }
    
    protected function _scan() : void
    {
        $this->processFolder($this->getSourcesFolder());
    }

    /**
     * Processes the target folder, and recurses into sub folders.
     * @param string $folder
     * @throws Localization_Exception
     */
    protected function processFolder(string $folder) : void
    {
        $d = new DirectoryIterator($folder);
        foreach ($d as $item) 
        {
            if ($item->isDot()) {
                continue;
            }
            
            $filename = $item->getFilename();
            
            if ($item->isDir() && !in_array($filename, $this->excludes['folders'])) {
                $this->processFolder($item->getPathname());
                continue;
            }
            
            if ($item->isFile() && $this->parser->isFileSupported($filename) && !$this->isExcluded($filename)) {
                $this->parseFile($item->getPathname());
            }
        }
    }
    
    protected function isExcluded(string $filename) : bool
    {
        foreach ($this->excludes['files'] as $search) {
            if (stristr($filename, $search)) {
                return true;
            }
        }
        
        return false;
    }
}
