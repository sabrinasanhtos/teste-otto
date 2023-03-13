<?php
namespace App\Services;

use App\Models\Pedido;
use Carbon\CarbonInterval;
use DB;

class Pmweb_Orders_Stats_Services
{
    public $startDate = '2017-08-24';
    public $endDate = '2020-01-13';

    public function setStartDate($date) : void
    {
        $this->startDate = $date;
    }

    public function setEndDate($date) : void
    {
        $this->endDate = $date;
    }

    public static function getOrdersRetailPrice($date_start, $date_end) : float
    {
        $receita = self::getOrdersRevenue($date_start, $date_end);
        $quantidade = self::getOrdersQuantity($date_start, $date_end);

        $preco_medio = $receita/$quantidade;
        return $preco_medio;
    }

    public static function getOrdersAverageOrderValue($date_start, $date_end) {

        $receita = self::getOrdersRevenue($date_start, $date_end);
        $total_pedidos = self::getOrdersCount($date_start, $date_end);

        $ticket_medio = $receita/$total_pedidos;
        return $ticket_medio;
    }
    
    public static function getOrdersCount($date_start, $date_end)
    {
        return Pedido::whereBetween(
            'order_date',
            [
                $date_start,
                $date_end
            ]
        )
        ->count();
    }

    public static function getOrdersRevenue($date_start, $date_end)
    {
        $result = Pedido::select(DB::raw('sum(quantity * price) as total'))
            ->whereBetween('order_date', [$date_start, $date_end])
            ->first();

        return $result->total;
    }

    public static function getOrdersQuantity($date_start, $date_end)
    {
        $result = Pedido::select(DB::raw('sum(quantity) as quantidade'))
            ->whereBetween('order_date', [$date_start, $date_end])
            ->first();
        
        return $result->quantidade;
    }

    public static function getOrdersByDate($date_start, $date_end)
    {
        $period = CarbonInterval::days(1)->toPeriod($date_start, $date_end);
        $data  = [];

        foreach ($period as $date) {
            $data[$date->format('Y-m-d')] = self::getOrdersCount($date->format('Y-m-d'), $date->format('Y-m-d'));
        }

        return $data;
    }
}
