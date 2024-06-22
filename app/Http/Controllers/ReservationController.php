<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Reservation;
use App\Models\ReservationMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.reservation.index', [
            'reservations' => Reservation::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!auth()->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Login to continue',
                'redirect' => '/login'
            ]);
        }

        if (auth()->user()->phone == null) {
            return response()->json([
                'success' => false,
                'message' => 'Please update your phone number first',
                'redirect' => '/profile'
            ]);
        }

        if (auth()->user()->email_verified_at == null) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify your email first',
                'redirect' => '/verify-email'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|min:10|max:15',
            'people' => 'required|min:1|max:10|numeric',
            'table' => 'required|min:1|max:10|numeric',
            'date' => 'required|date_format:d-M-Y', // Validasi format tanggal
            'time' => 'required|date_format:H:i', // Validasi format waktu
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Reservation failed',
                'errors' => $validator->errors(),
            ]);
        } else {
            $date = \Carbon\Carbon::createFromFormat('d-M-Y', $request->input('date'))->format('Y-m-d');
            $time = $request->input('time');
            $reservation = Reservation::where('date', $date)->where('time', $time)->where('table', $request->input('table'))->first();
            if ($reservation) {
                return response()->json([
                    'success' => "same",
                    'message' => 'Reservation with the same time and table already booked.',
                ]);
            } else {
                $newBook = Reservation::create([
                    'name' => $request->input('name'),
                    'user_id' => auth()->user()->id,
                    'phone' => $request->input('phone'),
                    'people' => $request->people,
                    'table' => $request->table,
                    'status' => 'pending',
                    'down_payment' => $request->down_payment,
                    'total_price' => $request->total_price,
                    'date' => $date,
                    'time' => $time
                ]);

                $book = Reservation::findOrFail($newBook->id);
                $dp = $book->down_payment;
                // Set your Merchant Server Key
                \Midtrans\Config::$serverKey = config('midtrans.serverKey');
                // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                \Midtrans\Config::$isProduction = config('midtrans.isProduction');
                // Set sanitization on (default)
                \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
                // Set 3DS transaction for credit card to true
                \Midtrans\Config::$is3ds = config('midtrans.is3ds');

                $params = array(
                    'transaction_details' => array(
                        'order_id' => $book->id,
                        'gross_amount' => $dp,
                    ),
                );
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                $book->update([
                    'snap_token' => $snapToken,
                    'status' => 'pending',
                ]);

                if ($request->has('menus')) {
                    foreach ($request->menus as $menu) {
                        ReservationMenu::create([
                            'reservation_id' => $book->id,
                            'product_id' => $menu['id'],
                            'quantity' => $menu['qty'],
                            'total' => $menu['total'],
                        ]);
                    }
                }

                $phone_number = $request->input('phone');

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.fonnte.com/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'target' => $phone_number,
                        'message' => "Hello, $request->name. \nYour reservation has been created successfully\nTable No: $request->table\nFor : $request->people People\nDate: $request->date\nTime: $time",
                        'countryCode' => '62', //optional
                    ),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: xNs9nSws9bqjaBxD04WQ' //change TOKEN to your actual token
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                return response()->json([
                    'success' => true,
                    'message' => 'Reservation created successfully',

                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */

    public function myReservation()
    {
        if (auth()->user()) {
            $cartCount = Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count();
        } else {
            $cartCount = 0;
        }
        $reservations = Reservation::where('user_id', auth()->user()->id)->latest()->get();
        return view('user.reservation.index', [
            'cartCount' => $cartCount,
            'reservations' => $reservations
        ]);
    }

    public function detailReservation($id)
    {
        $reservation = Reservation::find($id);
        $reservation->date = \Carbon\Carbon::parse($reservation->date)->format('d M Y');
        $reservation->time = \Carbon\Carbon::parse($reservation->time)->format('H:i');

        $reservation->menus = ReservationMenu::where('reservation_id', $id)->with('product')->get();

        $reservation->menus = $reservation->menus->map(function ($menu) {
            return [
                'id' => $menu->id,
                'quantity' => $menu->quantity,
                'total' => $menu->total,
                'product' => [
                    'product_name' => $menu->product->product_name,
                    'price' => $menu->product->price
                ]
            ];
        });

        return response()->json(
            [
                'success' => true,
                'reservation' => $reservation,
                'menus' => $reservation->menus
            ]
        );
    }

    public function payReservation($id)
    {
        $reservation = Reservation::find($id);
        if ($reservation->status == 'pending') {
            return response()->json([
                'success' => true,
                'token' => $reservation->snap_token
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Reservation already paid or cancelled'
            ]);
        }
    }
    public function successReservation($id)
    {
        $reservation = Reservation::find($id);
        $reservation->update([
            'status' => 'paid',
            'snap_token' => null
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Reservation paid successfully'
        ]);
    }
    public function failedReservation($id)
    {
        $reservation = Reservation::find($id);
        $reservation->update([
            'status' => 'failed',
            'snap_token' => null
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Reservation failed'
        ]);
    }
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reservation = Reservation::find($id);
        $reservation->date = \Carbon\Carbon::parse($reservation->date)->format('d-M-Y');
        $reservation->time = \Carbon\Carbon::parse($reservation->time)->format('H:i');
        return response()->json(
            [
                'success' => true,
                'reservation' => $reservation
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        $date = \Carbon\Carbon::createFromFormat('d-M-Y', $request->input('date'))->format('Y-m-d');
        $time = $request->input('time');
        $reservation->update([
            "name" => $request->name,
            "phone" => $request->phone,
            "people" => $request->people,
            "table" => $request->table,
            "status" => $request->status,
            "date" => $date,
            "time" => $time
        ]);
        $reservation->date = \Carbon\Carbon::parse($reservation->date)->format('d M Y');
        $reservation->time = \Carbon\Carbon::parse($reservation->time)->format('H:i');
        return response()->json(
            [
                'success' => true,
                'message' => 'Reservation updated successfully',
                'reservation' => $reservation
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        $reservation->delete();
        return response()->json(
            [
                'success' => true,
                'message' => 'Reservation deleted successfully'
            ]
        );
    }
}