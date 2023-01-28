<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Components\Helper;
use Session;
use Auth;
class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userStatusArr = Helper::getStatusArr();
        $ticketData = Ticket :: orderBy('id', 'desc')->paginate(5);
        return view('ticket.index',compact('ticketData','userStatusArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ticket.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $finalData = $request->except("_token");
        $finalData['active'] = 1;
        $finalData['remember_token'] = Str::random(20);
        $validator = Validator::make($finalData, ['ticket_no' => ['required','min:3', 'max:200'], 'summery' => ['required', 'min:1', 'max:100'],'due_date'=>['required']]);
        if ($validator->fails()) {
            Session::flash('ticket_update', 'Data is not updated!');
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::back()->withErrors($validator, 'apply')->withInput();
        }
        $clientsMsg = "Ticket created succesfully.";
        $className = 'alert-success';
        // dd($finalData);
        $saveStatus = Ticket::saveTicket($finalData);
        if ($saveStatus == false) {
            $clientsMsg = "Ticket not created.";
            $className = 'alert-danger';
        }
        Session::flash('ticket_update', $clientsMsg);
        Session::flash('alert-class', $className);
        return redirect()->route('user_index'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticketArr = Ticket::find(decrypt($id));
        return view('ticket.edit',compact('ticketArr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 
     */
    public function assignTicketAdd()
    {
        return view('ticket.assign_ticket');
    }
    public function assignTicketIndex()
    {
        return view('ticket.assign_index');
    }
}
