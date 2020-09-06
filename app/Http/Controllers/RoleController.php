<?php

namespace App\Http\Controllers;
use App\Role;
use App\Permiso;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{


    public function __construct(){
        $this->middleware(['auth', 'role:SuperUser']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $roles = Role::all();
        return view('auth.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$haspermiso = Permiso::all();
        return view('auth.roles.create', compact('haspermiso'));
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
            'name' => 'required|string',
            'descripcion' => 'required|string',
        ]);
        $role = new \App\Role;
        $role->name = $data['name'];
        $role->guard_name = 'web';
        $role->descripcion = $data['descripcion'];
        $role->save();
        //iteramos todos los permisos que se enviarón con el array del checkbox y se los asiganamos al rol a crear
        /*foreach ($request->get('permisos') as $key => $permiso) {
         $role->givePermissionTo($permiso);
        }*/
        return redirect()->route('roles.index')->with('success', 'El Role se ha creado correctame');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $role = Role::find($id);// buscamos el role correspondiente al id
      /*$permisos = DB::table('roles')->join('model_has_permissions', 'roles.id', '=','model_has_permissions.model_id')->join('permissions','permission_id','=','permissions.id')->select('permissions.name', 'permissions.descripcion')->where('roles.id','=',$id)->get()->toArray(); //buscamos los permisos que corresponden al role y lo devolvemos en un array
     
        $allPermisos = Permiso::all(); //extraemos todos los permisos que existen en nuestra tabla 
        $permisosCheck = array(); // creamos un array limpio para volverlo a llenar con los permisos que pertenecen al role
        for ($i=0; $i < count($permisos); $i++) {//iteramos los permisos de la consulta
                $permisosCheck[$i] = $permisos[$i]->name; //los guardamos en el nuevo array
        }*/
        return view('auth.roles.edit', compact('role'));
      
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
        try {

        $role = Role::find($id);
        $role->name = $request->get('name');
        $role->guard_name = 'web';
        $role->descripcion = $request->get('descripcion');
        $role->save();
        /*
        $allPermisos = Permiso::all();
        foreach ($allPermisos as $key => $permiso) {
            $role->revokePermissionTo($permiso->name);//removemos todos los permisos del role
        }

        foreach ($request->get('permisos') as $key => $permiso) {
         $role->givePermissionTo($permiso);//asignamos los nuevos permisos
        
        $role->hasPermissionTo($permiso);

        }*/
    
        return redirect()->route('roles.index')->with('success', 'El Role se ha modificado correctame');
            
        } catch (Exception $e) {
            
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
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'El Rol se ha eliminado correctamente');
        
    }

     // //funcion recursiva para comparar los valores de un array bidemencional
    private  function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
 
    return false;
}

    
}
