<?php

namespace App\Http\Controllers;

use App\Repositories\Order\OrderRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    protected $dashboardRepo;
    protected $orderRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo
    ){
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        $orders = $this->orderRepo->latest(5);
        if (Auth::user()->role > 1) {
                abort(403);
        }
        return view('admin.dashboard', compact('orders'));
    }

    // public function report(Request $request)
    // {
    //     try{
    //         switch($request->option){
    //             case 'last_week':
    //                 $response = $this->dashboardRepo->getReportByWeek();
    //                 break;
    //             case 'this_month':
    //                 $response = $this->dashboardRepo->getReportByMonth(0);
    //                 break;
    //             case 'last_month':
    //                 $response = $this->dashboardRepo->getReportByMonth(1);
    //                 break;
    //             case 'two_month':
    //                 $response = $this->dashboardRepo->getReportByMonth(2);
    //                 break;
    //             case 'range':
    //                 $response = $this->dashboardRepo->getReportByRange($request->from, $request->to);
    //                 break;
    //             default:
    //                 abort(500);
    //             break;
    //         }
    //         return response()->json([
    //             'data' => $response
    //         ]);
    //     }
    //     catch(Exception $ex){
    //         throw $ex;
    //     }
    // }

    // public function reportDownload(Request $request){
    //     $from = $request->query('from');
    //     $to = $request->query('to');
    //     $option = $request->query('option');

    //     switch($option){
    //         case 'last_week':
    //             $reports = $this->dashboardRepo->getReportByWeek();
    //             break;
    //         case 'this_month':
    //             $reports = $this->dashboardRepo->getReportByMonth(0);
    //             break;
    //         case 'last_month':
    //             $reports = $this->dashboardRepo->getReportByMonth(1);
    //             break;
    //         case 'two_month':
    //             $reports = $this->dashboardRepo->getReportByMonth(2);
    //             break;
    //         case 'range':
    //             $reports = $this->dashboardRepo->getReportByRange($from, $to);
    //             break;
    //         default:
    //             abort(500);
    //         break;
    //     }
    //     if($reports->isEmpty()){
    //         return back()->withErrors(['Không có báo cáo cho khoảng thời gian nay']);
    //     }

    //     $from = (new Carbon($reports->first()->created_at))->format('d/m/Y');
    //     $to = (new Carbon($reports->last()->created_at))->format('d/m/Y');

    //     $view = mb_convert_encoding(View::make('report.statistics', compact(
    //         'from',
    //         'to',
    //         'option',
    //         'reports'
    //     )), 'HTML-ENTITIES', 'UTF-8');
    //     $pdf = \PDF::loadHtml($view);
    //     // $pdf = \PDF::loadView('report.test', ['test'=>'hello']);
    //     return $pdf->download('report.pdf');
    // }
}
