<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            return view('messagerie.index');
        } else {
            return redirect()->route('annonce.show');
        }
    }

    public function inbox()
    {
        if (Auth::check()) {
            $messages = Message::select(['users.*', 'messages.*', 'messages.id AS message_id','users.id AS user_id'])->where('user_id_receiver', Auth::id())->leftjoin('users', 'messages.user_id_sender', 'users.id')->get();
            return view('messagerie.inbox')->with('messages', $messages);
        } else {
            return redirect()->route('annonce.show');
        }
    }

    public function new()
    {
        if (Auth::check()) {
            $users = User::where('id', '<>', Auth::id())->get();
            return view('messagerie.new')->with('users', $users);
        } else {
            return redirect()->route('annonce.show');
        }
    }

    public function read(Request $request)
    {
        // dd($request->message_id);
        if ( isset($request->message_id) && $request->message_id != '') {
            $message = Message::find($request->message_id);
            $message->seen = 1;
            $message->save();
            return redirect()->route('message.inbox')->with('read', 'Your message has been marked as read.');
        } else {
            return redirect()->route('message.inbox');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validateThis($request);

        $message = new Message([
            'title' => $request->title,
            'content' => $request->content,
            'user_id_receiver' => $request->user_id_receiver,
            'user_id_sender' => Auth::id(),
        ]);
        $message->save();
        return redirect()
            ->route('message.new')
            ->with('success', 'Your message has been sent.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public static function notif()
    {
        $messages = Message::where('user_id_receiver', Auth::id())->where('seen', '0')->get();
        if (($nbr = count($messages)) > 0) {
            return "({$nbr})";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }


    private function validateThis($request)
    {
        return tap(
            $this->validate($request, [
                'user_id_receiver' => 'required',
                'title' => 'required|min:10',
                'content' => 'required|min:10',
            ])
        );
    }
}
