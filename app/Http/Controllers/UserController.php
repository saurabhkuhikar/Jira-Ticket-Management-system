<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Components\Helper;
use App\Models\User;
use Session;
use Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userData = User::where('active',1)->orderBy('id', 'desc')->paginate(5);
        $userStatusArr = Helper::getStatusArr();
        $genderArr = Helper::genderArr();
        return view('user.index',compact('userData','userStatusArr','genderArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userRoleArr = Helper::getUserRoleArr();
        return view('user.add',compact('userRoleArr'))->render();
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
        //
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
     * Authenticate user for log in application.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            return true;
        }
        return false;
    }

    public function logPage()
    {
        return view('user.login');
    }
    /**
     * Logout the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

     /**
     * Authenticate user for log in application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logSubmit(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, ['email' => ['required', 'email'], 'password' => 'required']);
        if ($validator->fails()) {
            Session::flash('message', 'Data is not updated!');
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::back()->withErrors($validator, 'apply')->withInput();
        }
        $authStatus = $this->authenticate($request);

        if ($authStatus == false) {
            return redirect()->route('login')->with('loginError','Please provide valid credential.')->withInput();
        }
        
        return redirect()->route('home_page');
    }
}
