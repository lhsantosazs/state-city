<?php

namespace App\Services;

use App\Models\State;

class StateService
{
    const DELETED = 'Estado deletado com sucesso';
    const DUPLICATED = 'Estado duplicado';
    const FAIL = 'Falha ao salvar estado';
    const NOT_FOUND = 'Estado inexistente';
    const SAVED = 'Estado salvo com sucesso';

    /**
     * Create a state
     * @param array $params
     * @return array
     */
    public function create(array $params) : array
    {
        //Check duplicates
        $exists = $this->getStateByNameAndAbbreviation($params['name'], $params['abbreviation']);
        if (!empty($exists)) {
            return ['msg' => self::DUPLICATED];
        }

        $state = new State();
        $state->name = $params['name'];
        $state->abbreviation = $params['abbreviation'];

        return $this->save($state);
    }

    /**
     * Read state(s)
     * @param array $params
     * @return array
     */
    public function read(array $params) : array
    {
        $id = isset($params['id']) ? $params['id'] : null;

        return $this->getStateByIdWithCities($id);
    }

    /**
     * Update a state
     * @param array $params
     * @param int $stateId
     * @return array
     */
    public function update(array $params, int $stateId) : array
    {
        $state = $this->getStateById($stateId);
        if (empty($state)) {
            return ['msg' => self::NOT_FOUND];
        }

        $state->name = isset($params['name']) ? $params['name'] : $state->name;
        $state->abbreviation = isset($params['abbreviation']) ? $params['abbreviation'] : $state->abbreviation;

        return $this->save($state);
    }

    /**
     * Update a state
     * @param array $params
     * @param int $stateId
     * @return array
     */
    public function delete(int $stateId) : array
    {
        $state = $this->getStateById($stateId);
        if (empty($state)) {
            return ['msg' => self::NOT_FOUND];
        }

        $state->delete();
        return ['msg' => self::DELETED];
    }

    /**
     * Save state data in database
     * @param State $state
     * @return Array
    */
    protected function save(State $state) : array
    {
        $saved = $state->save();

        return [
            'msg' => $saved ? self::SAVED : self::FAIL,
            'state' => $state
        ];
    }

    /**
     * Get state by name and abbreviation
     * @param string $name
     * @param string $abbreviation
     * @return State|null
     */
    protected function getStateByNameAndAbbreviation(string $name, string $abbreviation)
    {
        return State::filterByName($name)->filterByAbbreviation($abbreviation)->first();
    }

    /**
     * Get state by id
     * @param ?int $id
     * @return State|null
     */
    protected function getStateById(?int $id)
    {
        return State::filterById($id)->first();
    }

    /**
     * Get state by id with cities
     * @param ?int $id
     * @return State|null
     */
    protected function getStateByIdWithCities(?int $id)
    {
        return State::filterById($id)->with('cities')->get()->toArray();
    }
}
