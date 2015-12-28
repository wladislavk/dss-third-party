<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreAllergenRequest;
use DentalSleepSolutions\Http\Requests\UpdateAllergenRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\AllergenInterface;

class ApiAllergenController extends ApiBaseController
{
    /**
     * References the allergens interface
     * 
     * @var $allergens
     */
    protected $allergen;

    /**
     * 
     * @param AllergenInterface $allergens 
     */
    public function __construct(AllergenInterface $allergen)
    {
        $this->allergen = $allergen;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedAllergens = $this->allergen->all();

        if (!count($retrievedAllergens)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Allergens list.', $retrievedAllergens);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAllergenRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->allergen->store($postValues);

        return ApiResponse::responseOk('Allergen was added successfully.', $this->allergen->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAllergenRequest $request, $allergensId)
    {
        $this->allergen->update($allergensId, $request->all());

        return ApiResponse::responseOk('Allergen was updated successfully.', $this->allergen->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($allergensId)
    {
        $retrievedAllergen = $this->allergen->find($allergensId);

        if (empty($retrievedAllergen)) {
            return ApiResponse::responseError('Allergen not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved allergen by id.', $retrievedAllergen);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($allergensId)
    {
        return ApiResponse::responseOk('Allergen was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($allergensId)
    {
        $deletedAllergen = $this->allergen->destroy($allergensId);

        if (empty($deletedAllergen)) {
            return ApiResponse::responseError('Allergen not found.', 422);
        }

        return ApiResponse::responseOk('Allergen was deleted successfully.', $this->allergen->all());
    }
}
