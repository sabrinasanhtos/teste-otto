<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Services\Pmweb_Orders_Stats_Services;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Pmweb_Orders_StatsController extends Controller
{
    public function getOrdersByDate(Request $request)
    {
        $datas = new Pmweb_Orders_Stats_Services();
        $datas->startDate = $request->data_start;
        $datas->endDate = $request->data_end;

        return response()->json(
            [
                'data' => Pmweb_Orders_Stats_Services::getOrdersByDate($datas->startDate, $datas->endDate)
            ],
            Response::HTTP_OK
        );
    }

    public function getStaticOrdersByDate(Request $request)
    {
        $datas = new Pmweb_Orders_Stats_Services();
        $datas->startDate = $request->data_start;
        $datas->endDate = $request->data_end;
        
        return response()->json(
            [
                'orders'=>
                [
                    "count"=> Pmweb_Orders_Stats_Services::getOrdersCount($datas->startDate, $datas->endDate),
                    "revenue"=> Pmweb_Orders_Stats_Services::getOrdersRevenue($datas->startDate, $datas->endDate),
                    "quantity"=> Pmweb_Orders_Stats_Services::getOrdersQuantity($datas->startDate, $datas->endDate),
                    "averageRetailPrice"=> Pmweb_Orders_Stats_Services::getOrdersRetailPrice(
                        $datas->startDate,
                        $datas->endDate
                    ),
                    "AverageOrderValue"=> Pmweb_Orders_Stats_Services:: getOrdersAverageOrderValue(
                        $datas->startDate,
                        $datas->endDate
                    )
                ]
            ],
            Response::HTTP_OK
        );
    }
}
