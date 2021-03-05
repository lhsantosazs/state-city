<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Services\CityService;
use App\Models\City;

class CityTest extends TestCase
{
    /*
    * Return race
    */
    private function getCity()
    {
        return [
            'id' => '1',
            'state_id' => 1,
            'name' => 'Minas Gerais',
        ];
    }

    /*
    * Return City
    */
    private function papulateCity(array $city) : City
    {
        $cityObj = new City();
        $cityObj->id = $city['id'];
        $cityObj->state_id = $city['state_id'];
        $cityObj->name = $city['name'];

        return $cityObj;
    }

    /*
    * Setup all needed services
    */
    private function setupServices()
    {
        $this->cityService = $this->getMockBuilder('App\Services\CityService')
        ->setMethods(['save', 'getCityByNameAndStateId','getCityById'])
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

        $city = $this->getCity();
        $saved = [
            'msg' => CityService::SAVED,
            'city' => $city
        ];

        $this->cityService->method('save')->will($this->returnValue($saved));
        $this->cityService->method('getCityByNameAndStateId')->will($this->returnValue(null));

        $result = $this->cityService->create($city);

        $this->assertEquals($result, $saved);
    }

    /**
     * @test
     * @group create
     */
    public function createDuplicated()
    {
        $this->setupServices();

        $city = $this->getCity();
        $duplicated = [
            'msg' => CityService::DUPLICATED
        ];

        $this->cityService->method('getCityByNameAndStateId')->will($this->returnValue(new City()));

        $result = $this->cityService->create($city);

        $this->assertEquals($result, $duplicated);
    }

    /**
     * @test
     * @group update
     */
    public function updateSuccess()
    {
        $this->setupServices();

        $city = $this->getCity();
        $cityObj = $this->papulateCity($city);
        $saved = [
            'msg' => CityService::SAVED,
            'city' => $city
        ];

        $this->cityService->method('save')->will($this->returnValue($saved));
        $this->cityService->method('getCityById')->will($this->returnValue($cityObj));

        $result = $this->cityService->update($city, $cityObj->id);

        $this->assertEquals($result, $saved);
    }
}
