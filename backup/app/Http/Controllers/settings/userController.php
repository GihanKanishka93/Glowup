<?php

namespace App\Http\Controllers\settings;


use App\Models\User;
use App\Models\location;
use Illuminate\Http\Request;
use App\Mail\AdminResetEmail;
use App\Mail\UserCreatedEmail;
use App\DataTables\userDataTable;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\DataTables\suspendUsersDataTable;

class userController extends Controller
{
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
          $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
          $this->middleware('permission:user-create', ['only' => ['create','store']]);
          $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
          $this->middleware('permission:user-delete', ['only' => ['destroy']]);
          $this->middleware('permission:user-reset-password', ['only' => ['resetpass']]);
          $this->middleware('permission:suspend-user-list', ['only' => ['suspendusers','react']]);
      //    $this->middleware('permission:profile',['only'=>['profile','updatePassword']]);
     }
    /**
     * Display a listing of the resource.
     */
    public function index(userDataTable $dataTable)
    {
        return $dataTable->render('settings.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        if (Auth::user()->hasRole('Admin')) {
            $role = Role::all();  
        }else{
            $role = Role::whereNot('name','SAdmin')->get(); 
        }
         
        return view('settings.user.create',compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'contact_number' => 'required|min:9|max:12',
            'user_name'=> 'required|unique:users,user_name',
            'email' => 'required|email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ],[
            'email.unique' => 'Email Already Exists, Please reset your password.',
        ]
    );

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);    

        $user = User::create($input);
        $user->assignRole($request->input('roles'));    



        Mail::to($user->email)->send(new UserCreatedEmail($user,$request->password));
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
      //  Mail::to($user->email)->send(new UserCreatedEmail($user));
     
        return view('settings.user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (Auth::user()->hasRole('Admin')) {
            $role = Role::all();  
        }else{
            $role = Role::whereNot('name','SAdmin')->get(); 
        }
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('settings.user.edit',compact('user','role','userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name'=> 'required',
            'user_name'=> 'required|unique:users,user_name,'.$user->id,
            'email' => 'required|email',
            'contact_number' => 'required|min:9|max:12',
            'roles' => 'required'
        ],[
            'email.unique' => 'Email Already Exists, Please reset your password.',
        ]);
 
    
        $input = $request->all();

        $user->update($input);
        $user->syncRoles($request->input('roles'));
  
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->deleted_by = Auth::user()->id;
        $user->save();

        $user->delete();
        return redirect()->route('users.index')->with('danger','user account deleted');
    }

    public function suspendusers(suspendUsersDataTable $dataTable){
        return $dataTable->render('settings.user.suspend');
    }

    public function react(int $id){
      $user =  User::withTrashed()->where('id', $id)->first();
       $user->deleted_by = 0;
       $user->save();
       $user->restore();       
        return redirect()->route('users.suspendusers')->with( 'message',' account activated');
    }
 
    public function resetpass(User $user){
      //  $num = rand(0,100);
        $password = Hash::make('sims@123'); 

        $user->update(['password' => $password]); 

       // $mail = new AdminResetEmail($user,'sims@123');  
        Mail::to($user->email)->send(new AdminResetEmail($user,'sims@123'));
        return redirect()->route('users.index')->with( 'message', ' Password Reset as sims@123');
    }

    public function profile(){
        $user = Auth::user();
        return view('settings.user.profile',compact('user'));
    }

    public function updatePassword(){

    }


}
