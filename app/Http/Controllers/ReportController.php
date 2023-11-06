<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Inventory;
use App\Models\Tenant;
use App\Models\Order;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Cancellation;
use Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\GoogleCalendar\Event;

use Illuminate\Support\Facades\Mail;
use App\Mail\InventoryCancelled;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Get finished inventories for a precise month
        $inventories = Inventory::where('status', [5])->whereHas('appointment', function ($query) {
            $query->whereMonth('date', 7);
        })->get();

        // Get inventory details
        $inventoriesDetails = array();
        foreach ($inventories as $inventory) {
            $inventoriesDetails[] = $inventory->getDetails($inventory);
        }

        // Add inventory travel fees and save it to $inventoryReport
        $inventoryReport = array();
        foreach ($inventoriesDetails as $item) {
            // Travel fees are in orders
            $order = Order::where('inventory_id', '=', $item['id'])->first();
            if (isset($order->expense_travel)) {
                $item['travel_fees'] = $order->expense_travel;
            } else {
                $item['travel_fees'] = 0;
            }
            // Save
            $inventoryReport[] = $item;
        }

        // Creata data for report
        $reportData = array();
        $reportData['orders'] = count($inventoryReport);


        $totalsSales = array();
        $totalsTravelFees = array();
        foreach ($inventoryReport as $item) {
            $totalsSales[] =  $item['propertyType']['sale_price'];
            $totalsTravelFees[] = $item['travel_fees'];
        }
        $totalSales = array_sum($totalsSales);

        $reportData['total_sales'] = $totalSales;


        /* Count orders by date 
        *  for bar graph
        */

        // Get inventories
        $orderGraphInventories = Inventory::where('status', [5])->oldest()->get();

        // Get dates
        $orderDates = array();
        foreach ($orderGraphInventories as $inventory) {
            $orderGraph['dates'][] =
                \Carbon\Carbon::parse($inventory->created_at)->format('d-m-Y');
        }
        $allOrderDates = array_unique($orderGraph['dates']);
        foreach ($allOrderDates as $allOrderDate) {
            $orderDates[] = $allOrderDate;
        }

        // Count Orders
        $ordersCount = array();
        $orderGraph['orders'] = array_count_values($orderGraph['dates']);
        foreach ($orderGraph['orders'] as $order) {
            $ordersCount[] = $order;
        }

        return Inertia::render('Reports/Index', [
            'data' => $inventoryReport,
            'reportData' => $reportData,
            'orderDates' => $orderDates,
            'ordersCount' => $ordersCount
        ]);
    }
}
