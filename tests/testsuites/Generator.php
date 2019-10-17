<?php

use PHPUnit\Framework\TestCase;

use AppLocalize\Localization;
use AppUtils\FileHelper;

final class GeneratorTest extends TestCase
{
    protected function setUp(): void
    {
        Localization::reset();
        
        $this->clearFiles();
    }
    
   /**
    * Clear the client library files that were written to disk.
    */
    protected function clearFiles() : void
    {
        $folder = Localization::getClientLibrariesFolder();
        
        $d = new DirectoryIterator($folder);
        
        foreach($d as $item) {
            if($item->isFile()) {
                FileHelper::deleteFile($item->getPathname());
            }
        }
    }

   /*
    * Files should be written for each locale, plus
    * the required libraries.
    */
    public function test_writeFiles()
    {
        Localization::addAppLocale('fr_FR');
        Localization::addAppLocale('de_DE');

        $generator = Localization::createGenerator();

        $files = $generator->getFilesList();
        
        // two locales + 2 library files
        $this->assertEquals(4, count($files));
        
        $generator->writeFiles();
        
        foreach($files as $file)
        {
            $this->assertTrue(file_exists($file));
        }
    }
    
   /**
    * When an empty string is specified as the client
    * libraries folder, nothing should be written to disk.
    * It should effectively disable those libraries.
    */
    public function test_writeFiles_disabled()
    {
        Localization::addAppLocale('fr_FR');
        Localization::addAppLocale('de_DE');
        
        $previous = Localization::getClientLibrariesFolder();
        $generator = Localization::createGenerator();
        
        // Get the list of files that would usually be created
        $files = $generator->getFilesList();
        
        // reset the client libraries folder
        // to disable the generation, to simulate
        // setting the folder to en empty string when
        // calling configure().
        Localization::setClientLibrariesFolder('');
        
        // create a new instance that will use the updated
        // client libraries folder.
        $generator = Localization::createGenerator();
        $generator->writeFiles();
        
        // None of the files should have been written to disk.
        foreach($files as $file)
        {
            $this->assertFalse(file_exists($file));
        }
        
        // restore the original folder for the other tests
        Localization::setClientLibrariesFolder($previous);
    }
}