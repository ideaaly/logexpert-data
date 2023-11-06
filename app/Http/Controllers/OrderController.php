<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

// Inertia
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


// Models
use App\Models\Order;
use App\Models\User;
// Packages
use Carbon;
use DateTime;

class OrderController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all()->where('status', 2);
        $data = $orders;
        
        $created_at = $orders->pluck('created_at');

        return Inertia::render('Orders/List', ['data' => $data]);
    }

    /**
     * Render the orders list by months
     */
    public function orderByMonths($month): \Inertia\Response
    {
        // Get confirmed orders
        // !TODO Load order data & Compute total by month
        $orders = Order::where('status', 2) // 2 = confirmed
            ->whereMonth('created_at', $month)
            ->with('inventory.user')
            ->with('inventory.tenant')
            ->orderBy('created_at')
            ->get()
            ->toArray();
        $total = 0;
        //sum total_price
        foreach ($orders as $order) {
            $total += $order['total_price'];
        }

        //foreach Order::   
        
            
        
        $chartData = $this->createOrderChart();
 

        return Inertia::render('Orders/ListMonth', [
            'orders' => $orders,
            'total' => $total,
            'chart' => $chartData,

        ]);
        
    }
    
    function showChart()
    {
        $orders = Order::where('status', 2) // 2 = confirmed
        ->get();

        $chartData = [];
        $labels = [];
        $data = [];

        foreach ($orders as $order) {
            $labels[] = $order->created_at->format('M Y');
            $data[] = $order->total_price;
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Price',
                    'data' => $data,
                ],
            ],
        ];

        return Inertia::render('Orders/Chart', [
            'chartData' => $chartData,
        ]);
    }

   
}
