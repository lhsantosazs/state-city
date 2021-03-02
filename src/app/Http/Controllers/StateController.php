<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateStateRequest;
use App\Http\Requests\ListStateRequest;
use App\Http\Requests\UpdateStateRequest;
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

        $stateCreated = $this->stateService->create($params);

        return response()->json($stateCreated);
    }

    /**
     * Read state(s)
     * @param ListStateRequest $listStateRequest
     * @return JsonResponse
     */
    public function read(ListStateRequest $listStateRequest) : JsonResponse
    {
        $params = $listStateRequest->all();

        $states = $this->stateService->read($params);

        return response()->json($states);
    }

    /**
     * Update a state
     * @param UpdateStateRequest $updateStateRequest
     * @param int $stateId
     * @return JsonResponse
     */
    public function update(UpdateStateRequest $updateStateRequest, int $stateId) : JsonResponse
    {
        $params = $updateStateRequest->all();

        $stateUpdated = $this->stateService->update($params, $stateId);

        return response()->json($stateUpdated);
    }
}
