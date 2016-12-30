<?php

namespace DentalSleepSolutions\Helpers;

// this class contains some functions from general_functions.php
class GeneralHelper
{
    public function function isSharedFile($name)
    {
        return strlen($name) && is_file(Q_FILE_FOLDER . $name);
    }

    public function formatPhone($data)
    {
        if (preg_match('/.*(\d{3}).*(\d{3}).*(\d{4}).*(\d*)$/', $data, $matches)) {
            $result = '(' . $matches[1] . ') ' . $matches[2] . '-' . $matches[3];
            if ($matches[4] != '') {
              $result .= ' x' . $matches[4];
            }

            return $result;
        }
    }

    /**
     * Retrieve template from the template folder
     *
     * @param string $filename
     * @return string
     */

    // need to rewrite to the structure of Laravel
    public function getTemplate($filename)
    {
        $templatePath = __DIR__ . '/../admin/includes/templates';

        $sections = explode('/', $filename);
        $sections = array_filter($sections);
        $sections = preg_replace('/[^a-z0-9_-]+/', '', $sections);

        $filename = join('/', $sections);

        if (!file_exists("$templatePath/$filename.tpl")) {
            return '';
        }

        return file_get_contents("$templatePath/$filename.tpl");
    }
}
