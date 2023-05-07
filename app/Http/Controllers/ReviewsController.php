<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Reviews;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Reviews::where('status', 'active')->get();

        foreach ($reviews as $data) {
            $user = User::where('id', $data->user_id)->first();
            if ($user) {
                $data['user_name'] = $user['name'];
                $data['user_profile'] = $user['profile_photo_url'];
            }
        }
        return $reviews;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function review(Request $request)
    {
        //this controller is to store booking details post from mobile app
        $reviews = new Reviews();
        //this is to update the appointment status from "upcoming" to "complete"
        $appointment = Appointments::where('id', $request->get('appointment_id'))->first();
        //change appointment status
        $appointment->status = 'complete';
        $appointment->save();

        $reviews->appointment_id = $request->get('appointment_id');
        $reviews->user_id = Auth::user()->id;
        $reviews->doc_id = $request->get('doctor_id');
        $reviews->ratings = $request->get('ratings');
        $reviews->reviews = $request->get('reviews');
        $reviews->reviewed_by = Auth::user()->name;
        $reviews->status = 'active';
        $reviews->save();

        return response()->json([
            'success' => 'The appointment has been completed and reviewed successfully!',
        ], 200);
    }
}
