<?php

namespace App\Services;

use App\Models\City;

class CityService
{
    const DELETED = 'Cidade deletada com sucesso';
    const DUPLICATED = 'Cidade duplicada';
    const FAIL = 'Falha ao salvar cidade';
    const NOT_FOUND = 'Cidade inexistente';
    const SAVED = 'Cidade salva com sucesso';

    /**
     * Create a City
     * @param array $params
     * @return array
     */
    public function create(array $params) : array
    {
        //Check duplicates
        $exists = $this->getCityByNameAndStateId($params['name'], $params['state_id']);
        if (!empty($exists)) {
            return ['msg' => self::DUPLICATED];
        }

        $city = new City();
        $city->name = $params['name'];
        $city->state_id = $params['state_id'];

        return $this->save($city);
    }

    /**
     * Read city(s)
     * @param array $params
     * @return array
     */
    public function read(array $params) : array
    {
        $id = isset($params['id']) ? $params['id'] : null;
        return $this->getCityById($id)->with('state')->get()->toArray();
    }

    /**
     * Update a city
     * @param array $params
     * @param int $cityId
     * @return array
     */
    public function update(array $params, int $cityId) : array
    {
        $city = $this->getCityById($cityId)->first();
        if (empty($city)) {
            return ['msg' => self::NOT_FOUND];
        }

        $city->name = isset($params['name']) ? $params['name'] : $city->name;
        $city->state_id = isset($params['state_id']) ? $params['state_id'] : $city->state_id;

        return $this->save($city);
    }

    /**
     * Update a city
     * @param array $params
     * @param int $cityId
     * @return array
     */
    public function delete(int $cityId) : array
    {
        $city = $this->getCityById($cityId)->first();
        if (empty($city)) {
            return ['msg' => self::NOT_FOUND];
        }

        $city->delete();
        return ['msg' => self::DELETED];
    }

    /**
     * Save city data in database
     * @param City $city
     * @return Array
    */
    protected function save(City $city) : array
    {
        $saved = $city->save();

        return [
            'msg' => $saved ? self::SAVED : self::FAIL,
            'city' => $city
        ];
    }

    /**
     * Get city by name and state_id
     * @param string $name
     * @param string $state_id
     * @return City|null
     */
    public function getCityByNameAndStateId(string $name, string $state_id)
    {
        return City::filterByName($name)->filterByStateId($state_id)->first();
    }

    /**
     * Get city by id
     * @param ?int $id
     * @return City|null
     */
    public function getCityById(?int $id)
    {
        return City::filterById($id);
    }
}
