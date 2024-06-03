<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class AdminController extends Controller
{
    public function index()
    {
        $productCount = Product::all()->count();
        $userCount = User::where('role', 'user')->count();
        $orderCount = Order::where('status', '!=', null)->where('status', '!=', 'pending')->count();
        $reservationCount = Reservation::all()->count();
        $reservations = Reservation::where('date', Carbon::today()->format('Y-m-d'))->get();
        return view('admin.dashboard', [
            'productCount' => $productCount,
            'userCount' => $userCount,
            'orderCount' => $orderCount,
            'reservationCount' => $reservationCount,
            'reservations' => $reservations
        ]);
    }
    public function getOrderData()
    {
        $currentDate = Carbon::now();
        $startDate = $currentDate->copy()->subYear()->startOfMonth();

        $orders = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
            ->where('status', 'success')
            ->whereBetween('created_at', [$startDate, $currentDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($orders);
    }

    public function getProductTypeData()
    {
        $productTypes = Product::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get();

        return response()->json($productTypes);
    }

    public function getReservationsByDate(Request $request)
    {
        $dateFilter = $request->query('date');
        $date = Carbon::today();

        switch ($dateFilter) {
            case 'yesterday':
                $date = Carbon::yesterday();
                break;
            case 'tomorrow':
                $date = Carbon::tomorrow();
                break;
            case '3-days-later':
                $date = Carbon::today()->addDays(3);
                break;
            case '1-week-later':
                $date = Carbon::today()->addWeek();
                break;
        }

        $reservations = Reservation::whereDate('date', $date)->get();

        return response()->json($reservations);
    }
}
