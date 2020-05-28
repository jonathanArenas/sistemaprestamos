<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UserController extends Controller
{
   public function __construct(){
         $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = Auth()->user()->getRoleNames();
        //return $userRole;
        if($userRole[0] == 'SuperUser'){
            $users = User::all();
        }elseif($userRole[0] == 'Administrador'){
            $users = User::role('Gerente')->get();
            $users =  $users->merge(User::role('Cobrador')->get());
        }elseif($userRole[0] == 'Gerente'){
            $users = User::role('Cobrador')->get();
        }
        
        return view('auth.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $hasRoles = Role::all();
       return view('auth.user.create', compact('hasRoles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate(Request(),[
            'nombre' => 'required|string',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|min:8',
            'password_confirm' => 'required|same:password',
            'role' => ['required', Rule::in(['SuperUser','Administrador','Gerente','Cobrador']),]
        ]);
        try {
            $user = new User;
            $user->nombre = $data['nombre'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']); 
            $user->save();
            $user->assignRole($data['role']);
            return redirect()->route('user.index')->with('success', 'El usuario se ha creado correctame');
        } catch (Exception $e) {
            return $e->getMessage();
        }
       
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

    public function showAjax(Request $request){

        if($request->ajax()){
            $query = $request->get('query');
            if($query != '')    {
                   $data = User::where('nombre', 'like', $query.'%')
                     ->orWhere('email', 'like', $query.'%')
                     ->get();
                    return response()->json(['data' =>  $data]);
              }else{
                   $data = User::all();
                   return  response()->json(['data' =>  $data]);  
              }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roleName = $user->getRoleNames();
        $hasRoles = Role::all();
        return view('Auth.user.edit', compact('user', 'hasRoles', 'roleName'));
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
        $data = $this->validate(Request(),[
            'nombre' => 'required|string',
            'email' => 'required|email',
            'role' => ['required', Rule::in(['SuperUser','Administrador','Gerente','Cobrador']),]
        ]);
        try {
            $user = User::find($id);
            $user->nombre = $data['nombre'];
            $user->email = $data['email'];
            $role = $user->getRoleNames();
            $user->removeRole($role[0]);
            $user->assignRole($data['role']);
            $user->save();
            return redirect()->route('user.index')->with('success', 'Los datos se han actualizado correctamente');
        } catch (Exception $e){
            return $e->getMessage();
        }
        
        
        
    }

    public function updatePassword(Request $request, $id){
        $data = $this->validate(Request(),[
            'current_password' => 'required|string',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ]);
        try {
                $user = User::find($id);
                if(Hash::check($data['current_password'], $user->password )){
                    $user->password = Hash::make($data['password']);
                    $user->save();
                    return redirect()->route('user.edit', $user->id)->with('success', 'La contraseña se ha actualizado');
                }else{
                    return redirect()->back()->withErrors(['La contraseña actual no coincide']);
                }
        } catch (Exception $e) {
            //throw $th;
        }
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();
         return redirect()->route('user.index')->with('success', 'El usuario se ha eliminado correctamente');
    }
}
