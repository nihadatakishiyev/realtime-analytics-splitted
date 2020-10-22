<?php

namespace App\Http\Controllers;

use App\Helpers\AnalyticsHelper;
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
        return response()->json(["data"=>$response]);//
    }

    public function realtime($id){
        $res = $this->realtime->data_realtime->get("ga:".$id, "rt:activeUsers");
        return response()->json(["data"=>$res]);
    }
}
