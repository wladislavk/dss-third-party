<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
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
     * Validation rules
     * 
     * @var $rules
     */
    private $rules = [
        'allergens'   => 'string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer'
    ];

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
    public function store()
    {
        $postValues = Input::all();
        $validator  = \Validator::make($postValues, $this->rules);

        if ($validator->fails()) {
            return ApiResponse::responseError($validator->errors(), 422);
        }

        $postValues = array_merge($postValues, [
            'adddate'    => Carbon::now(),
            'ip_address' => \Request::ip()
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
    public function update($allergensId)
    {
        $validator = \Validator::make(Input::all(), $this->rules);

        if ($validator->fails()) {
            return ApiResponse::responseError($validator->errors(), 422);
        }

        $this->allergen->update($allergensId, Input::all());

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
