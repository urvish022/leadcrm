<?php

namespace App\Repositories;

use App\Models\EmailSchedules;
use App\Repositories\BaseRepository;

/**
 * Class EmailScheduleRepository
 * @package App\Repositories
 * @version November 25, 2022, 12:44 am UTC
*/

class EmailScheduleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

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
        return EmailSchedules::class;
    }
}
