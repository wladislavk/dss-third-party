<?php

namespace DentalSleepSolutions\Listeners;

use DentalSleepSolutions\Contracts\TransformerInterface;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Exceptions\NamingConventionException;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\BindingSetter;
use Doctrine\Common\Inflector\Inflector;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Events\RouteMatched;

class RouteMatchedEventListener
{
    const NAME_PATTERN = '/^.+?\\\\([a-z0-9]+?)Controller@.+$/i';
    const PATTERN_MATCH = '$1';

    /** @var Application */
    private $app;

    /** @var Config */
    private $config;

    /** @var Inflector */
    private $inflector;

    /**
     * @param Application $app
     * @param Config $config
     * @param Inflector $inflector
     */
    public function __construct(Application $app, Config $config, Inflector $inflector)
    {
        $this->app = $app;
        $this->config = $config;
        $this->inflector = $inflector;
    }

    /**
     * @param RouteMatched $event
     * @throws NamingConventionException
     * @throws \ReflectionException
     */
    public function handle(RouteMatched $event): void
    {
        $inflectorRules = $this->config->get('inflector');
        $this->inflector->rules('plural', $inflectorRules);

        $modelName = $this->modelNameFromActionName($event->route->getActionName());
        if ($modelName) {
            $this->setBindings($modelName);
        }
    }

    /**
     * @param string $actionName
     * @return string|null
     */
    protected function modelNameFromActionName(string $actionName):? string
    {
        if (!preg_match(self::NAME_PATTERN, $actionName)) {
            return null;
        }
        $pluralModel = preg_replace(self::NAME_PATTERN, self::PATTERN_MATCH, $actionName);
        $singularModel = $this->singularModel($pluralModel);
        return $singularModel;
    }

    /**
     * @param string $modelName
     * @throws \DentalSleepSolutions\Exceptions\NamingConventionException
     * @throws \ReflectionException
     */
    protected function setBindings(string $modelName): void
    {
        $bindings = BindingSetter::setBindings($modelName);
        foreach ($bindings as $binding) {
            $this->app
                ->when($binding->getController())
                ->needs(AbstractRepository::class)
                ->give($binding->getRepository())
            ;
            $this->app
                ->when($binding->getController())
                ->needs(Request::class)
                ->give($binding->getRequest())
            ;

            if ($binding->getTransformer()) {
                $this->app
                    ->when($binding->getController())
                    ->needs(TransformerInterface::class)
                    ->give($binding->getTransformer())
                ;
            }
        }
        $externalBindings = BindingSetter::setExternalBindings();
        foreach ($externalBindings as $externalBinding) {
            $this->app
                ->when($externalBinding->getController())
                ->needs(AbstractRepository::class)
                ->give($externalBinding->getRepository())
            ;
        }
    }

    /**
     * @param string $pluralModel
     * @return string
     */
    private function singularModel(string $pluralModel): string
    {
        $snakeCaseModel = snake_case($pluralModel);
        $singularModel = str_singular($snakeCaseModel);
        /**
         * Singular === Plural: either there are no translations, or the phrase doesn't need translation
         */
        if (!$singularModel || $singularModel === $snakeCaseModel) {
            $modelParts = explode('_', $snakeCaseModel);
            $modelParts[sizeof($modelParts) - 1] = str_singular(last($modelParts));
            $singularModel = join('_', $modelParts);
        }
        $singularModel = camel_case($singularModel);
        $singularModel = ucfirst($singularModel);
        return $singularModel;
    }
}