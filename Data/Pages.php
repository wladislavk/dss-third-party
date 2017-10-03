<?php

namespace Data;

use Contexts\BehatException;

class Pages
{
    const VUE_URL_PREFIX = '/vue';

    const PAGES = [
        [
            'name' => 'Login',
            'url' => '/login',
            'vue' => true,
        ],
        [
            'name' => 'Main',
            'url' => '/',
            'vue' => true,
        ],
        [
            'name' => 'Pending Claims',
            'url' => '/login',
            'vue' => true,
        ],
        [
            'name' => 'Device Selector',
            'url' => '/login',
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
                }
                return $url;
            }
        }
        throw new BehatException("Page with name $page not found");
    }
}
