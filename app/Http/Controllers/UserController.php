<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\User;


class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        return response(compact('users'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:password',

        ]);

        if ($validator->fails())  {
            return response()->json(['error'=>$validator->errors()],
                Response::HTTP_UNAUTHORIZED);
        }

        $user = User::create($request->all());

        // $user->sendApiEmailVerificationNotification();

        $message = 'Registration successful. Please verify account through the sent email.';
        return  response(compact('message', 'user'), 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // lets find the user
        $user = User::find($id);
        return response(compact('user'), 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::updateOrCreate(['id'=>$id],$request->all());
        $message ="Profile update successful";
        return response(compact('message'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        $message = "Account deleted successfully";
        return response(compact('message'), 200);
    }


    // Function for determining user access level
    public function accessLevel(Request $request)
    {
        $user = User::where('email', $request->username)->first();
        return response(compact('user'), 200);
    }


}
