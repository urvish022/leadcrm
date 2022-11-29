<?php

namespace App\Repositories;

use App\Models\TaxSettings;
use App\Repositories\BaseRepository;

/**
 * Class TaxSettingsRepository
 * @package App\Repositories
 * @version February 1, 2022, 10:24 am UTC
*/

class TaxSettingsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tax_name',
        'cgst_amount',
        'cgst_amount',
        'igst_amount',
        'default'
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
        return TaxSettings::class;
    }
}
