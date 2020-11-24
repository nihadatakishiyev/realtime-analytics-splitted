<?php

namespace App\Http\Controllers;

use App\Helpers\AnalyticsHelper;
use App\Models\Card;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    private $reporting;
    private $realtime;
    public function __construct()
    {
        $this->reporting = AnalyticsHelper::initAnalyticsReporting();
        $this->realtime = AnalyticsHelper::initAnalytics();
    }

    public function report($id){
        $response = AnalyticsHelper::getReport($this->reporting, $id);
        $info = Card::where('gid', $id)->get();
        return response()->json([
            "data"=>$response,
            "info"=> $info
        ]);
    }

    public function realtime($id){
        $res = $this->realtime->data_realtime->get("ga:".$id, "rt:activeUsers");
//        $info = Card::where('gid', $id)->get();
        return response()->json([
            "data"=>$res,
//            "info"=> $info
        ]);
    }

    public function combined($id){
        $report = AnalyticsHelper::getReport($this->reporting, $id);
        $realtime = $this->realtime->data_realtime->get("ga:".$id, "rt:activeUsers");
        $info = Card::where('gid', $id)->get();
        return response()->json([
            "info"=> $info,
            "report"=>$report,
            "realtime" => $realtime
        ]);
    }

    public function bringUserStats($id){
        $res = AnalyticsHelper::obtainUserStats($this->reporting, $id);

        return  response()->json([
            "data"=>$res
        ]);
    }

    public function bringSessionStats($id){
        $res = AnalyticsHelper::obtainSessionStats($this->reporting, $id);

        return  response()->json([
            "data"=>$res
        ]);
    }

    public function bringAgeStats($id){
        $res = AnalyticsHelper::obtainAgeStats($this->reporting, $id);

        return response()->json([
            "data"=>$res
        ]);
    }

    public function bringSessionDuration($id){
        $res = AnalyticsHelper::obtainSessionDuration($this->reporting, $id);

        return response()->json([
            "data"=>$res
        ]);
    }

    public function bringUserNewOld($id){
        $res = AnalyticsHelper::obtainUserNewOld($this->reporting, $id);

        return response()->json([
            "data" => $res
        ]);
    }

    public function bringUserGender($id){
        $res = AnalyticsHelper::obtainUserGender($this->reporting, $id);

        return response()->json([
            "data" => $res
        ]);
    }

    public function bringAcquisition($id){
        $res = AnalyticsHelper::obtainAcquisition($this->reporting, $id);

        return response()->json([
            "data" => $res
        ]);
    }
//
//    public function test($id){
//        $test = [1,2];
//    }
}
