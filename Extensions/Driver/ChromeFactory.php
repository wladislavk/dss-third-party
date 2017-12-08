<?php
namespace DentalSleepSolutions\Extensions\Driver;

use Behat\MinkExtension\ServiceContainer\Driver\DriverFactory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;

final class ChromeFactory implements DriverFactory
{
    /**
     * {@inheritdoc}
     */
    public function getDriverName()
    {
        return 'chrome';
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder->children()->scalarNode('api_url')->end()->end();
    }

    /**
     * {@inheritdoc}
     */
    public function buildDriver(array $config)
    {
        return new Definition(ChromeDriver::class, [$config['api_url'], null, '%mink.base_url%']);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsJavascript()
    {
        return true;
    }
}
