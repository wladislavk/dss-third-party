<?php

namespace Data;

use Contexts\BehatException;

class Pages
{
    const VUE_URL_PREFIX = '/vue';

    const PAGES = [
        [
            'name' => 'Login',
            'url' => '/manage/login',
            'vue' => true,
        ],
        [
            'name' => 'Main',
            'url' => '/manage/main/index',
            'vue' => true,
        ],
        [
            'name' => 'Tutorials',
            'url' => '/manage/main/sw-tutorials',
            'vue' => true,
        ],
        [
            'name' => 'Scheduler',
            'url' => '/manage/calendar.php',
            'vue' => false,
        ],
        [
            'name' => 'Support',
            'url' => '/manage/support.php',
            'vue' => false,
        ],
    ];

    /**
     * @param string $page
     * @return string
     * @throws BehatException
     */
    public static function getUrl($page)
    {
        foreach (self::PAGES as $aPage) {
            if ($aPage['name'] == $page) {
                $url = $aPage['url'];
                if ($aPage['vue']) {
                    $url = self::VUE_URL_PREFIX . $url;
                    return $url;
                }
                $url = 'http://' . SUT_HOST . $url;
                return $url;
            }
        }
        throw new BehatException("Page with name $page not found");
    }
}
