<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($room)
    {
        //
        return Message::where('room_id', $room)->latest()->simplePaginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  lets validate that input
        $request->validate([
            'message'   =>  'required',
            'room_id'   =>  'required',
            'is_public' =>  'required|boolean',
            'from_id'   =>  'numeric'
        ]);

        //  send the message to users
        broadcast(new \App\Events\SendMessage(array_merge(
            $request->all(),
            [
                'created_at'=>date('c'),
                'id'=>md5(uniqid())
            ]
            ) )); 

        // queue message for saving
        dispatch(new \App\Jobs\SaveMessageHistory($request->all()));

        return 'ok';
    }

}
