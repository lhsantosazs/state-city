<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\City\CreateCityRequest;
use App\Http\Requests\City\ListCityRequest;
use App\Http\Requests\City\UpdateCityRequest;
use Illuminate\Http\JsonResponse;
use App\Services\CityService;

class CityController extends Controller
{
    /**
     * Constructor to instantiate Request
     * @param CityService $cityService
     */
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * Create a city
     * @param CreateCityRequest $createCityRequest
     * @return JsonResponse
     */
    public function create(CreateCityRequest $createCityRequest) : JsonResponse
    {
        $params = $createCityRequest->all();

        $cityCreated = $this->cityService->create($params);

        return response()->json($cityCreated);
    }

    /**
     * Read City(s)
     * @param ListCityRequest $listCityRequest
     * @return JsonResponse
     */
    public function read(ListCityRequest $listCityRequest) : JsonResponse
    {
        $params = $listCityRequest->all();

        $citys = $this->cityService->read($params);

        return response()->json($citys);
    }

    /**
     * Update a City
     * @param UpdateCityRequest $updateCityRequest
     * @param int $cityId
     * @return JsonResponse
     */
    public function update(UpdateCityRequest $updateCityRequest, int $cityId) : JsonResponse
    {
        $params = $updateCityRequest->all();

        $cityUpdated = $this->cityService->update($params, $cityId);

        return response()->json($cityUpdated);
    }

    /**
     * Delete a City
     * @param int $cityId
     * @return JsonResponse
     */
    public function delete(int $cityId) : JsonResponse
    {
        $cityDeleted = $this->cityService->delete($cityId);

        return response()->json($cityDeleted);
    }
}
