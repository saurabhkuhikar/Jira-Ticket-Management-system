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
        $userData = User::orderBy('id', 'desc')->paginate(5);
        $userStatusArr = Helper::getStatusArr();
        $genderArr = Helper::genderArr();
        $userRoleArr = Helper::getUserRoleArr();
        return view('user.index',compact('userData','userStatusArr','genderArr','userRoleArr'));
    }

    public function search(Request $request)
    {
        // if (isset($name) and !empty($name)) {
        //     $userData->orWhere('name','Like',"'%{$name}%'");
        // }
        // if (isset($email) and !empty($email)) {
        //     $userData->orWhere('email','Like',"%{$email}%");
        // }
        // if (isset($type) and !empty($type)) {
        //     $userData->orWhere('type','=',$type);
        // }
        $inputArr = $request->except("_token");
        $userDataObj = new User();
        if (!empty($inputArr['name'])) {
            $userDataObj->append('name','LIKE',"%{$inputArr['name']}%");
        }
        if (!empty($inputArr['type'])) {
            // $userDataObj->orWhere('role','=',"{$inputArr['type']}");
        }
        // ->orWhere('email','Like',"%{$inputArr['email']}%")
        $userData = $userDataObj->toSql();
        $userData = $userDataObj->orderBy('id', 'desc')->paginate(5);
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
        $userDataArr = User::find(decrypt($id));
        $userRoleArr = Helper::getUserRoleArr();
        $genderArr = Helper::genderArr();
        return view('user.view',compact('userDataArr','userRoleArr','genderArr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userDataArr = User::find(decrypt($id));
        $userRoleArr = Helper::getUserRoleArr();
        return view('user.edit',compact('userDataArr','userRoleArr'));
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
        $finalData = $request->except("_token");
        $validator = Validator::make($finalData, ['name' => ['required','min:3', 'max:50'], 'email' => ['required','min:3', 'max:50','email'],'gender' => ['required'],'role'=>['required']]);
        if ($validator->fails()) {
            Session::flash('user_update', 'Data is not updated!');
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::back()->withErrors($validator, 'apply')->withInput();
        }
        $clientsMsg = "User update succesfully.";
        $className = 'alert-success';
        $saveStatus = User::find($id);
        if (!$saveStatus->update($finalData)) {
            $clientsMsg = "User not updated.";
            $className = 'alert-danger';
        }
        Session::flash('user_update', $clientsMsg);
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
    
    /**
     * User acitve status update
     * @return json
     */
    public function updateUserStutus(Request $request)
    {
        $dataArr = $request->all();
        $userId =  $dataArr['userId'];
        $userStatus = 0;
        $submitArr = [];

        if($dataArr['userStatus'] == 0){
            $userStatus = 1;
        }
        $userStatusArr = Helper::getStatusArr();

        $updateStatus = User::where('id',$userId);
        $submitArr['code'] = 500;
        $submitArr['success'] = false;
        if($updateStatus->update(['active'=>$userStatus])){
            $submitArr['code'] = 200;
            $submitArr['success'] = true;
            $submitArr['status'] = $userStatus;
            $submitArr['value'] = $userStatusArr[$userStatus];
        }
        return json_encode($submitArr);
    }
}