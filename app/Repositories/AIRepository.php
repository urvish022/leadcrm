<?php

namespace App\Repositories;

use App\Models\AI;
use App\Repositories\BaseRepository;

/**
 * Class AIRepository
 * @package App\Repositories
 * @version December 26, 2022, 7:06 am UTC
*/

class AIRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        '[[id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AI::class;
    }
}
