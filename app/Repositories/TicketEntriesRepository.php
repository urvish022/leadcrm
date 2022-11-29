<?php

namespace App\Repositories;

use App\Models\TicketEntries;
use App\Repositories\BaseRepository;

/**
 * Class TicketEntriesRepository
 * @package App\Repositories
 * @version February 1, 2022, 10:53 am UTC
*/

class TicketEntriesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'entry_date',
        'entry_desc',
        'subtotal_amount',
        'total_discount_amount',
        'extra_tickets_desc',
        'extra_tickets',
        'total'
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
        return TicketEntries::class;
    }
}
