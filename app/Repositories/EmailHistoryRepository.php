<?php

namespace App\Repositories;

use App\Models\EmailHistory;
use App\Repositories\BaseRepository;

/**
 * Class EmailHistoryRepository
 * @package App\Repositories
 * @version November 24, 2022, 6:27 pm UTC
*/

class EmailHistoryRepository extends BaseRepository
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
        return EmailHistory::class;
    }

}
