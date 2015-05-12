<?php

include 'class.fax.php';
                $faxNumber = "18883935968";                                           //<--- IMPORTANT: Enter a valid fax number
                $fileName = "Page1.tif";                                              //<--- IMPORTANT: Enter a valid file name
                $filePath = getcwd() . "/Page1.tif";                  //<--- IMPORTANT: Enter a valid path to primary file to be faxed
                $fileType = "tif"; 
$fts = new FTSSamples();
$fts->OutboundFaxCreate($faxNumber, $fileName, $filePath, $fileType); 


?>
