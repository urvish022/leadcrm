<?php

namespace App\Repositories;

use App\Models\LeadCategory;
use App\Repositories\BaseRepository;

/**
 * Class TicketEntriesRepository
 * @package App\Repositories
 * @version February 1, 2022, 10:53 am UTC
*/

class LeadCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_name',
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
        return LeadCategory::class;
    }

    public function getCountWithLeads()
    {
        return LeadCategory::withCount('leads')->get();
    }
}
