<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Components\Helper;
use Illuminate\Support\Facades\Gate;
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
        if (! Gate::allows('view-user')) {
            abort(403);
        }
        $userData = User::where('active',1)->orderBy('id', 'desc')->paginate(5);
        $userStatusArr = Helper::getStatusArr();
        $genderArr = Helper::genderArr();
        $userRoleArr = Helper::getUserRoleArr();
        return view('user.index',compact('userData','userStatusArr','genderArr','userRoleArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('create-user')) {
            abort(403);
        }
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
        $finalData = $request->except("_token");
        $validator = Validator::make($finalData, ['name' => ['required','min:3', 'max:50'], 'email' => ['required','min:3', 'max:50','email'], 'password' => ['required', 'min:1', 'max:6'],'gender' => ['required'],'role'=>['required']]);
        if ($validator->fails()) {
            Session::flash('user_update', 'Data is not updated!');
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::back()->withErrors($validator, 'apply')->withInput();
        }
        $clientsMsg = "User created succesfully.";
        $className = 'alert-success';
        $finalData['password'] = (isset($finalData['password']) ? bcrypt($finalData['password']) : "");
        $finalData['remember_token'] = Str::random(20);
        $finalData['active'] = 1;
        $saveStatus = User::saveUser($finalData);
        if ($saveStatus == false) {
            $clientsMsg = "User not created.";
            $className = 'alert-danger';
        }
        Session::flash('user_update', $clientsMsg);
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
        if (! Gate::allows('delete-user')) {
            abort(403);
        }
        $deleteStatus = User::find(decrypt($id))->delete();
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
