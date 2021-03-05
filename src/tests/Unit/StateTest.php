<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Services\StateService;
use App\Models\State;

class StateTest extends TestCase
{
    /*
    * Return state
    */
    private function getState()
    {
        return [
            'id' => '1',
            'name' => 'Minas Gerais',
            'abbreviation' => 'MG'
        ];
    }

    /*
    * Return state
    */
    private function papulateState(array $state) : State
    {
        $stateObj = new State();
        $stateObj->id = $state['id'];
        $stateObj->name = $state['name'];
        $stateObj->abbreviation = $state['abbreviation'];

        return $stateObj;
    }

    /*
    * Setup all needed services
    */
    private function setupServices()
    {
        $this->stateService = $this->getMockBuilder('App\Services\StateService')
        ->setMethods(['save', 'getStateByNameAndAbbreviation','getStateById'])
        ->disableOriginalConstructor()
        ->getMock();
    }

    /**
     * @test
     * @group create
     */
    public function createSuccess()
    {
        $this->setupServices();

        $state = $this->getState();
        $saved = [
            'msg' => StateService::SAVED,
            'state' => $state
        ];

        $this->stateService->method('save')->will($this->returnValue($saved));
        $this->stateService->method('getStateByNameAndAbbreviation')->will($this->returnValue(null));

        $result = $this->stateService->create($state);

        $this->assertEquals($result, $saved);
    }

    /**
     * @test
     * @group create
     */
    public function createDuplicated()
    {
        $this->setupServices();

        $state = $this->getState();
        $duplicated = [
            'msg' => StateService::DUPLICATED
        ];

        $this->stateService->method('getStateByNameAndAbbreviation')->will($this->returnValue(new State()));

        $result = $this->stateService->create($state);

        $this->assertEquals($result, $duplicated);
    }

    /**
     * @test
     * @group update
     */
    public function updateSuccess()
    {
        $this->setupServices();

        $state = $this->getState();
        $stateObj = $this->papulateState($state);
        $saved = [
            'msg' => StateService::SAVED,
            'state' => $state
        ];

        $this->stateService->method('save')->will($this->returnValue($saved));
        $this->stateService->method('getStateById')->will($this->returnValue($stateObj));

        $result = $this->stateService->update($state, $stateObj->id);

        $this->assertEquals($result, $saved);
    }
}
