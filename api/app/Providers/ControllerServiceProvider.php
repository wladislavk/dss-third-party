<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Contracts\TransformerInterface;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\BindingSetter;
use Doctrine\Common\Inflector\Inflector;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Prettus\Repository\Eloquent\BaseRepository;

// this class binds common RESTful request and model interfaces to controllers
class ControllerServiceProvider extends ServiceProvider
{
    const NAME_PATTERN = '/^.+?\\\\([a-z0-9]+?)Controller@.+$/i';
    const PATTERN_MATCH = '$1';

    public function register()
    {
        $inflectorRules = $this->app['config']->get('inflector');
        Inflector::rules('plural', $inflectorRules);

        $this->app['events']->listen('router.matched', function (Route $route, Request $request) {
            $modelName = $this->modelNameFromActionName($route->getActionName());
            if ($modelName) {
                $this->setBindings($modelName);
            }
        });
    }

    /**
     * @param string $actionName
     * @return string|null
     */
    protected function modelNameFromActionName($actionName)
    {
        if (!preg_match(self::NAME_PATTERN, $actionName)) {
            return null;
        }
        $pluralModel = preg_replace(self::NAME_PATTERN, self::PATTERN_MATCH, $actionName);
        $singularModel = $this->singularModel($pluralModel);
        return $singularModel;
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\NamingConventionException
     */
    protected function setBindings($modelName = null)
    {
        $bindings = BindingSetter::setBindings($modelName);
        foreach ($bindings as $binding) {
            $this->app
                ->when($binding->getController())
                ->needs(BaseRepository::class)
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
                ->needs(BaseRepository::class)
                ->give($externalBinding->getRepository())
            ;
        }
    }

    private function singularModel($pluralModel)
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
