<?php
namespace Ds3ThirdParty\CaptchaSecurityImages;

/*
* File: CaptchaSecurityImages.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 03/08/06
* Updated: 07/02/07
* Requirements: PHP 4/5 with GD and FreeType libraries
* Link: http://www.white-hat-web-design.co.uk/articles/php-captcha.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/

class CaptchaSecurityImages
{

    const FONT = __DIR__ . '/monofont.ttf';
    const TEST_CODE = 'cg8ga';

    private $width;

    private $height;

    private $characters;

    private $code;

    private $image;

    public function __construct($width = 120, $height = 40, $characters = 6)
    {
        $this->width = $width;
        $this->height = $height;
        $this->characters = $characters;
    }

    public function formImage()
    {
        $this->code = $this->generateCode();
        /* font size will be 75% of the image height */
        $font_size = $this->height * 0.75;
        $this->image = @imagecreate($this->width, $this->height) or trigger_error('Cannot initialize new GD image stream', E_USER_ERROR);
        /* set the colours */
        $text_color = imagecolorallocate($this->image, 20, 40, 100);
        $noise_color = imagecolorallocate($this->image, 100, 120, 180);
        /* generate random dots in background */
        for ($i = 0; $i < ($this->width * $this->height) / 3; $i++) {
            imagefilledellipse($this->image, mt_rand(0, $this->width), mt_rand(0, $this->height), 1, 1, $noise_color);
        }
        /* generate random lines in background */
        for ($i = 0; $i < ($this->width * $this->height) / 150; $i++) {
            imageline($this->image, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $noise_color);
        }
        /* create textbox and add text */
        $textbox = imagettfbbox($font_size, 0, self::FONT, $this->code) or trigger_error('Error in imagettfbbox function', E_USER_ERROR);
        $x = ($this->width - $textbox[4]) / 2;
        $y = ($this->height - $textbox[5]) / 2;
        imagettftext($this->image, $font_size, 0, $x, $y, $text_color, self::FONT, $this->code) or trigger_error('Error in imagettftext function', E_USER_ERROR);
        return $this->image;
    }

    public function getCode()
    {
        return $this->code;
    }

    private function generateCode()
    {
        /**
         * Prepare captcha for automated testing
         */
        if (getenv('APP_ENV') === 'release') {
            return self::TEST_CODE;
        }

        /* list all possible characters, similar looking characters and vowels have been removed */
        $possible = '23456789bcdfghjkmnpqrstvwxyz';
        $code = '';
        $i = 0;
        while ($i < $this->characters) {
            $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
            $i++;
        }
        return $code;
    }

    public function __destruct()
    {
        imagedestroy($this->image);
    }
}
