<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|min:10|max:15',
            'people' => 'required',
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
            $reservation = Reservation::where('date', $date)->where('time', $time)->first();
            if ($reservation) {
                return response()->json([
                    'success' => "same",
                    'message' => 'Reservation with the same date and time already booked.',
                ]);
            } else {
                Reservation::create([
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'people' => $request->people,
                    'date' => $date,
                    'time' => $time
                ]);
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
                        'message' => "Hello, $request->name. \nYour reservation has been created successfully\nFor : $request->people People\nDate: $request->date\nTime: $time",
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