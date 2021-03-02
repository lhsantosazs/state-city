<?php

namespace App\Services;

use App\Models\State;

class StateService
{
    const SAVED = 'Estado salvo com sucesso';
    const FAIL = 'Falha ao salvar estado';
    const DUPLICATED = 'Estado duplicado';

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
        return State::filterById($id)->get()->toArray();
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
    public function getStateByNameAndAbbreviation(string $name, string $abbreviation)
    {
        return State::filterByName($name)->filterByAbbreviation($abbreviation)->first();
    }
}
