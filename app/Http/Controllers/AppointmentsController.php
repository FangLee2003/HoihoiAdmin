<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Reviews;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //retrieve all appointments from the user
        $appointment = Appointments::where('user_id', Auth::user()->id)->get();

        //sorting appointment and doctor details
        //and get all related appointment
        foreach ($appointment as $data) {
            $doctor = User::where('type', 'doctor')->where('id', $data->doc_id)->first();
            $details = $doctor->doctor;
            if ($doctor) {
                $data['doctor_name'] = $doctor['name'];
                $data['doctor_profile'] = $doctor['profile_photo_url']; //typo error found
                $data['category'] = $details['category'];
            }
        }

        return $appointment;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addApp(Request $request)
    {
        //this controller is to store booking details post from mobile app
        $appointment = new Appointments();
        $appointment->user_id = Auth::user()->id;
        $appointment->doc_id = $request->get('doctor_id');
        $appointment->date = $request->get('date');
        $appointment->day = $request->get('day');
        $appointment->time = $request->get('time');
        $appointment->location= $request->get('location');
        $appointment->status = 'booked'; //new appointment will be saved as 'upcoming' by default
        $appointment->save();

        //if successfully, return status code 200
        return response()->json([
            'success' => 'New Appointment has been made successfully!',
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function cancelApp(Request $request)
    {
        $appointment = Appointments::where('id', $request->appointment_id)->first();
        $appointment->status = "cancel";
        $appointment->update();

        return response()->json(['success' => 'Appointment canceled!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
