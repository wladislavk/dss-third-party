<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Data\Pages;
use PHPUnit\Framework\Assert;

class DualApp extends BaseContext
{
    /**
     * @Given these pages are in Vue:
     *
     * @param TableNode $table
     */
    public function checkVueRoutes(TableNode $table)
    {
        $pageNames = array_column($table->getHash(), 'page');
        foreach (Pages::PAGES as $page) {
            if (in_array($page['name'], $pageNames)) {
                Assert::assertTrue($page['vue']);
            }
        }
    }

    /**
     * @Given these pages are in legacy:
     *
     * @param TableNode $table
     */
    public function checkLegacyRoutes(TableNode $table)
    {
        $pageNames = array_column($table->getHash(), 'page');
        foreach (Pages::PAGES as $page) {
            if (in_array($page['name'], $pageNames)) {
                Assert::assertFalse($page['vue']);
            }
        }
    }
}
