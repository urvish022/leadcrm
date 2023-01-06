<?php

namespace App\Http\Controllers;

use App\Repositories\EmailScheduleRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;


class SchedulerController extends Controller
{
    public $emailScheduleRepository;
    public $sources = [];
    public function __construct(EmailScheduleRepository $emailScheduleRepository){
        $this->emailScheduleRepository = $emailScheduleRepository;
    }

    public function index()
    {
        return view('scheduler.calendar');
    }

    public function getSchedulerData(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $result = $this->emailScheduleRepository->getSchedulerData($start,$end);
        $schedule_data = [];
        foreach($result as $value)
        {
            if($value->delivery_status == 'pending'){
                $bg_color = "#FFC107";
            } else if($value->delivery_status == 'success'){
                $bg_color = "#28A745";
            } else {
                $bg_color = "#DC3545";
            }
            $row['start'] = Carbon::parse($value->schedule_time)->format('Y-m-d');
            $row['title'] = $value->leads->company_name." - ".ucfirst($value->status);
            $row['backgroundColor'] = $bg_color;
            $row['borderColor'] = $bg_color;
            $row['textColor'] = "#FFFFFF";
            $row['extra_information'] = json_encode($value);
            $schedule_data[] = $row;
        }

        return response()->json(['status'=>true,'data'=>$schedule_data]);
    }

    public function deleteSchedulerData($id)
    {
        $this->emailScheduleRepository->delete($id);
        return response()->json(['status'=>true]);
    }
}
