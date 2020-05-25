<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class UserController extends Controller
{
    use Notifiable, HasApiTokens;
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
            return response()->json(['errors'=>$validator->errors()],
                Response::HTTP_UNAUTHORIZED);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        // $user->sendApiEmailVerificationNotification();

        $message = 'Registration successful. Please verify account through the sent email.';
        return  response(compact('message', 'user'), 201);
    }

    public function login(Request $request)
    {
        //find oauth table where id = 2
        $passport = DB::table('oauth_clients')->where('id', 2)->first();


        //start a new guzzle client instance
        $http = new \GuzzleHttp\Client;

        //try to create access token
        try {
            $response = $http->post('http://localhost:8001/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $passport->id,
                    'client_secret' => $passport->secret,
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);

            //if token is successful grab the token body
            $token = $response->getBody();

            //decode the token
            $data = json_decode($token, true);

            return response()->json(['access_token' => $data['access_token'],]);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                if ($e->getCode() === 400) {

                    return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());

                } else if ($e->getCode() === 401) {

                    return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
                }
            return response()->json('Oops...Something went wrong.', $e->getCode());
        }

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
