<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('users.changepass');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        $user = auth()->user();
        //  $user =  User::find(auth()->user()->id)->first();
        $user->update(['password' => Hash::make($request->new_password)]);


        Mail::html(
            '<html><body>Hi ' . $user->first_name . ' ' . $user->last_name . ',<br/><br/>
Your suwa arana login password has been updated at ' . date('Y-m-d h:i:s') . '.<br/><br/>
<ul>
<li>Name : ' . $user->first_name . ' ' . $user->last_name . '</li>
<li>User name : ' . $user->user_name . '</li>
<li>Password : ' . $request->new_password . '</li>
</ul>
Thank you <br/><br/>' . config('app.name') . '</body></html>',
            function ($message) use ($user) {
                $message->to($user->email)->subject('Password has been Updated.');
            }
        );


        return redirect()->route('users.profile')->with('message', 'Password change successfully.');
    }
}
