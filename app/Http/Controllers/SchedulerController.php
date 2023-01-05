<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SchedulerController extends Controller
{
    public $emailScheduleRepository;
    public function __construct(EmailScheduleRepository $emailScheduleRepository){
        $this->emailScheduleRepository = $emailScheduleRepository;
    }

    public function index()
    {
        $events = [];

        
        foreach ($this->sources as $source) {
            foreach ($source['model']::all() as $model) {
                $crudFieldValue = $model->getAttributes()[$source['date_field']];

                if (!$crudFieldValue) {
                    continue;
                }

                $events[] = [
                    'title' => trim($source['prefix'] . ' ' . $model->{$source['field']} . ' ' . $source['suffix']),
                    'start' => $crudFieldValue,
                    'url'   => route($source['route'], $model->id),
                ];
            }
        }

        return view('scheduler.calendar', compact('events'));
    }
}
