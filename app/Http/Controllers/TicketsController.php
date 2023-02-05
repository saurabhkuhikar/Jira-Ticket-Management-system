<?php

namespace App\Http\Controllers;

use App\Components\Helper;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
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
        $inputArr = request()->except("_token");

        $ticketData = Ticket::query()->leftJoin('users',function($join){
            $join->on(DB::raw("users.id = tickets.dev_user_id OR users.id = tickets.qa_user_id"));
        })->select('users.name','tickets.*');
        if (isset($inputArr['ticket_no']) and !empty($inputArr['ticket_no'])) {
            $ticketData->where('ticket_no','LIKE',"%{$inputArr['ticket_no']}%");
        }
        if (isset($inputArr['due_date']) and !empty($inputArr['due_date'])) {
            $ticketData->where('due_date','=',"{$inputArr['due_date']}");
        }
        if (isset($inputArr['status']) and !empty($inputArr['status'])) {
            $ticketData->where('status','=',$inputArr['status']);
        }
        if (isset($inputArr['qa_name']) and !empty($inputArr['qa_name'])) {
            $ticketData->where('users.name','LIKE',"%{$inputArr['qa_name']}%");
        }
        if (isset($inputArr['dev_name']) and !empty($inputArr['dev_name'])) {
            $ticketData->where('users.name','LIKE',"%{$inputArr['dev_name']}%");
        }
        $userStatusArr = Helper::getStatusArr();
        $allUserList = User::getAllUserList();
        $ticketStatusArr = Helper::getTicketStatusArr();
        $ticketData = $ticketData->orderBy('users.id', 'desc')->paginate(5);
        return view('ticket.index', compact('ticketData', 'userStatusArr', 'allUserList','ticketStatusArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (! Gate::allows('create-ticket')) {
        //     abort(403);
        // }
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
        if (! Gate::allows('delete-ticket')) {
            abort(403);
        }
        $deleteStatus = Ticket::find(decrypt($id))->delete();
        $userMsg = "User deleted successfully";
        $className = 'alert-success';
        if ($deleteStatus == false) {
            $userMsg = "User not deleted";
            $className = "alert-danger";
        }
        Session::flash('user_update', $userMsg);
        Session::flash('alert-class', $className);
        return redirect()->route('user_index');
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
