<?php

namespace App\Repositories;

use App\Models\TicketSettings;
use App\Repositories\BaseRepository;

/**
 * Class TicketSettingsRepository
 * @package App\Repositories
 * @version February 1, 2022, 9:57 am UTC
*/

class TicketSettingsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ticket_name',
        'ticket_desc',
        'ticket_price',
        'ticket_discount',
        'ticket_start_number'
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
        return TicketSettings::class;
    }
}
