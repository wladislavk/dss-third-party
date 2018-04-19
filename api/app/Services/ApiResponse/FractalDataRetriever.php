<?php

namespace DentalSleepSolutions\Services\ApiResponse;

use DentalSleepSolutions\Exceptions\GeneralException;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class FractalDataRetriever
{
    const TRANSFORMER_NAMESPACE = 'DentalSleepSolutions\Http\Transformers\\';

    /** @var Manager */
    private $fractalManager;

    public function __construct(Manager $fractalManager)
    {
        $this->fractalManager = $fractalManager;
    }

    /**
     * @param mixed $data
     * @return mixed
     * @throws GeneralException
     */
    public function getFractalData($data)
    {
        $transformer = $this->getTransformer($data);
        if ($transformer) {
            return $this->createFractalData($data, $transformer);
        }
        return null;
    }

    /**
     * @param Model|array|\Traversable $resource
     * @param TransformerAbstract $transformer
     * @return mixed
     * @throws GeneralException
     */
    private function createFractalData($resource, TransformerAbstract $transformer)
    {
        $newResource = $this->createResource($resource, $transformer);
        $data = $this->fractalManager->createData($newResource)->toArray();
        if (!isset($data['data'])) {
            throw new GeneralException('Fractal result must have \'data\' property');
        }
        return $data['data'];
    }

    /**
     * @param Model|array|\Traversable $resource
     * @param TransformerAbstract $transformer
     * @return Collection|Item
     */
    private function createResource($resource, TransformerAbstract $transformer)
    {
        if ($resource instanceof Model) {
            return new Item($resource, $transformer);
        }
        return new Collection($resource, $transformer);
    }

    /**
     * @param mixed $data
     * @return TransformerAbstract|null
     */
    private function getTransformer($data)
    {
        if ($data instanceof Model) {
            return $this->getTransformerForModel($data);
        }
        if ($this->isCollection($data) && $data[0] instanceof Model) {
            return $this->getTransformerForModel($data[0]);
        }
        return null;
    }

    /**
     * @param Model $resource
     * @return TransformerAbstract|null
     */
    private function getTransformerForModel(Model $resource)
    {
        $transformer = self::TRANSFORMER_NAMESPACE . class_basename($resource);

        // class_exists() throws an exception if the class doesn't exist and autoload is enabled
        try {
            if (class_exists($transformer) && is_subclass_of($transformer, TransformerAbstract::class)) {
                return new $transformer();
            }
        } catch (\ErrorException $e) {
            return null;
        }

        return null;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    private function isCollection($data)
    {
        if (!is_array($data) && !$data instanceof \Traversable) {
            return false;
        }
        if (!isset($data[0])) {
            return false;
        }
        return true;
    }
}
