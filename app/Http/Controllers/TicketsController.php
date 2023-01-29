<?php

namespace App\Http\Controllers;

use App\Components\Helper;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Session;
use Auth;
class TicketsController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userStatusArr = Helper::getStatusArr();
        $allUserList = User::getAllUserList();
        $ticketData = Ticket::orderBy('id', 'desc')->paginate(5);
        return view('ticket.index', compact('ticketData', 'userStatusArr', 'allUserList'));
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
        $validator = Validator::make($finalData, ['ticket_no' => ['required', 'min:3', 'max:200'], 'summery' => ['required', 'min:1', 'max:100'], 'due_date' => ['required','date','after:tomorrow']]);
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
        return redirect()->route('ticket_index');
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
    public function edit($id,User $user)
    {
        if (! Gate::allows('update-ticket', $user)) {
            abort(403);
        }
        $qaUserList = User::getUserList("QA");
        $devUserData = User::getUserList("DEV");
        $ticketStatusArr = Helper::getTicketStatusArr();
        $ticketArr = Ticket::find(decrypt($id));
        return view('ticket.edit', compact('ticketArr', 'qaUserList', 'devUserData', 'ticketStatusArr'));
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
        $saveStatus = Ticket::find(decrypt($id));
        $finalData = $request->except("_token");
        $dueDateValidation = "";
        if ($finalData['due_date'] != $saveStatus['due_date']) {
            $dueDateValidation = 'after:tomorrow';
        }
        $validator = Validator::make($finalData, ['ticket_no' => ['required', 'min:3', 'max:200'], 'summery' => ['required', 'min:1', 'max:100'], 'due_date' => ['required','date', $dueDateValidation]]);
        if ($validator->fails()) {
            Session::flash('ticket_update', 'Data is not updated!');
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::back()->withErrors($validator, 'apply')->withInput();
        }
        $clientsMsg = "Ticket Details updated succesfully.";
        $className = 'alert-success';
        if (!$saveStatus->update($finalData)) {
            $clientsMsg = 'Ticket Details not updated!';
            $className = "alert-danger";
            return \Redirect::back()->withInput();
        }
        Session::flash('ticket_update', $clientsMsg);
        Session::flash('alert-class', $className);
        return \Redirect::back();
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
     * Assigned user
     * @param int $id
     *
     */
    public function assignTicketAdd($id = null)
    {
        $qaUserList = User::getUserList("QA");
        $devUserData = User::getUserList("DEV");
        $ticketArr = Ticket::find(decrypt($id));
        return view('ticket.assign_ticket_user', compact('id','qaUserList','devUserData','ticketArr'));
    }

    /**
     * Assigned user for a tickets
     * @param $request,$id 
     * @request Post
     */
    public function assignTicketStore(Request $request,$id)
    {
        $finalData = $request->except("_token");
        $validator = Validator::make($finalData, ['qa_user_id' => ['required'], 'dev_user_id' => ['required']],['qa_user_id.required' => 'Please selected QA.']);
        if ($validator->fails()) {
            Session::flash('ticket_update', 'Data is not updated!');
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::back()->withErrors($validator, 'apply')->withInput();
        }
        $ticketArr = Ticket::find(decrypt($id));
        $ticketNo = substr($ticketArr->ticket_no,0,8);
        $clientsMsg = "User assigned on ticket {$ticketNo} succesfully.";
        $className = 'alert-success';
        if (!$ticketArr->update($finalData)) {
            $clientsMsg = 'User not assigned!';
            $className = "alert-danger";
            return \Redirect::back()->withInput();
        }
        Session::flash('ticket_update', $clientsMsg);
        Session::flash('alert-class', $className);
        return \Redirect::back();
    }
}
