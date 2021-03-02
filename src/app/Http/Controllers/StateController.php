<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateStateRequest;
use App\Http\Requests\ListStateRequest;
use Illuminate\Http\JsonResponse;
use App\Services\StateService;

class StateController extends Controller
{
 /**
     * Constructor to instantiate Request
     * @param StateService $stateService
     */
    public function __construct(StateService $stateService)
    {
        $this->stateService = $stateService;
    }

    /**
     * Create a state
     * @param CreateStateRequest $createStateRequest
     * @return JsonResponse
     */
    public function create(CreateStateRequest $createStateRequest) : JsonResponse
    {
        $params = $createStateRequest->all();

        $raceCreated = $this->stateService->create($params);

        return response()->json($raceCreated);
    }

    /**
     * Read state(s)
     * @param ListStateRequest $listStateRequest
     * @return JsonResponse
     */
    public function read(ListStateRequest $listStateRequest) : JsonResponse
    {
        $params = $listStateRequest->all();

        $raceCreated = $this->stateService->read($params);

        return response()->json($raceCreated);
    }
}
