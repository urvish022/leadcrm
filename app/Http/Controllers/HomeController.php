<?php

namespace App\Http\Controllers;
use App\Repositories\LeadsRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        $data = $this->leadsRepo->getDashboardCounts($authId);
        return view('home')->with('statistics',$data);
    }
}
