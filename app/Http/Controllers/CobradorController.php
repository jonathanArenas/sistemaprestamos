<?php

namespace App\Http\Controllers;
use App\User;
use App\Http\Requests\CobradorRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CobradorController extends Controller
{

    public function __construct(){
        $this->middleware(['auth', 'role:SuperUser|Prestamista|Administrador']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cobradores = User::role('Cobrador')->get();
        return view('auth.cobradores.index', compact('cobradores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('auth.cobradores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CobradorRequest $request)
    {
        $data = $request->validated();
        try {
            $cobrador = new User;
            $cobrador->username  = $data['username'];
            $cobrador->email = $data['email'];
            $cobrador->password = bcrypt($data['password']); 
            $cobrador->nombre = $data['nombre'];
            $cobrador->paterno = $data['paterno'];
            $cobrador->materno = $data['materno'];
            $cobrador->fecha_na = Carbon::parse($data['nacimiento']);
            $cobrador->save();
            $cobrador->assignRole('Cobrador');
            return redirect()->route('cobradores.index')->with('success', 'El nuevo registro se ha guardado correctamente');
        } catch (Exception $e) {
    
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            try{ 
            $cobrador = User::find($id);
        
            if($cobrador == "" || strval($cobrador->hasRole('Cobrador')) !=1){
                throw new \Exception;
            }
          

                return view('auth.cobradores.edit', compact('cobrador'));

            } catch (\Exception $e) {
                return abort('500');
            }
        
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
        $cobrador = User::find($id);
            $data = $this->validate(Request(),[
                'username' => 'required|string|unique:usuarios,username,'.$cobrador->id,
                'email' => 'required|email|unique:usuarios,email,'.$cobrador->id,
                'nombre' => 'required|string',
                'paterno' => 'required|string',
                'materno' => 'required|string',
                'nacimiento' => 'required|date',
            ]);
        try{

            if($cobrador == "" || strval($cobrador->hasRole('Cobrador')) !=1){
                throw new \Exception;
            }
            $cobrador->username = $data['username'];
            $cobrador->email = $data['email'];
            $cobrador->nombre = $data['nombre'];
            $cobrador->paterno = $data['paterno'];
            $cobrador->materno = $data['materno'];
            $cobrador->fecha_na = Carbon::parse($data['nacimiento']);
            $cobrador->save();    
                return redirect()->route('cobradores.edit', $id)->with('success','El registro se ha modificado correctamente');
        } catch (\Exception $e) {
            return abort('500');
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
        $cobrador= user::find($id);
        try {
            if($cobrador == "" || strval($cobrador->hasRole('Cobrador')) !=1){
                throw new \Exception;
            }
            $cobrador->delete();
            return redirect()->route('cobradores.index')->with('success', 'El registro se ha eliminado correctamente');
        } catch (\Exception $th) {
            return abort('500');
        }

       
    }

    public function updatePassword(Request $request, $id){
        $cobrador = user::find($id);
        $data = $this->validate(Request(),[
            'current_password' => 'required|string',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ]);
        try {
            if($cobrador == "" || strval($cobrador->hasRole('Cobrador')) !=1){
                throw new \Exception;
            }
                $user = User::find($id);
                if(Hash::check($data['current_password'], $user->password )){
                    $user->password = Hash::make($data['password']);
                    $user->save();
                    return redirect()->route('user.edit', $user->id)->with('success', 'La contraseña se ha actualizado');
                }else{
                    return redirect()->back()->withErrors(['La contraseña actual no coincide']);
                }
        } catch (Exception $e) {
             return abort('500');
        }
        
    }

    public function cobradorShowAjax(Request $request){
        if($request->ajax()){
            $data = $this->validate(Request(),[
                'query' => 'nullable|string'
            ]);
            $query = $data['query']; 
            if ($query != '') {
                $data = User::role('Cobrador')->where('nombre', 'like', $query.'%')
                ->orWhere('paterno', 'like', $query.'%')
                ->orWhere('materno', 'like', $query.'%')
                ->orWhere('email', 'like', $query.'%')->get();
            }else{
                $data = User::role('Cobrador')->get();
            }
            return response()->json(['data' => $data]);
        }
    }
}
