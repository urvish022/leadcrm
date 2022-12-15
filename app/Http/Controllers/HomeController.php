<?php

namespace App\Http\Controllers;
use App\Repositories\LeadsRepository;
use Illuminate\Http\Request;
use App\Models\UserSettings;
use App\Http\Controllers\AppBaseController;
use Session;

class HomeController extends AppBaseController
{
    private $leadsRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LeadsRepository $leadsRepo)
    {
        $this->middleware('auth');
        $this->leadsRepo = $leadsRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authId = auth()->id();

        $userSettings = UserSettings::where('user_id',auth()->id())->first();
        Session::put('user-settings', $userSettings);

        $data = $this->leadsRepo->getDashboardCounts($authId);
        return view('home')->with('statistics',$data);
    }
}
