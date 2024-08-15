<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $roles = Role::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        })
        ->where('id', '!=', 1)  // Excluir el ID 0
        ->orderBy('id', 'asc')
        ->paginate(20);

        return view('roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $role = Role::create($request->only('name'));
            //la siguiente lines convierte el integer al $permissions para que pueda guardar en la base de datos
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            // $permissions = array_map('intval', $request->input('permissions', []));
            $role->syncPermissions($permissions);

            DB::commit();

            return redirect()->route('roles.index')->with('success', 'El rol se ha creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Ocurrió un error al crear el rol: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.show', compact('role'));
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        try {
            // Valida los datos del formulario
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
                'permissions' => 'array',
            ]);

            // Actualiza el nombre del rol
            $role->name = $request->name;

            // Actualiza los permisos asociados al rol
            $permissions = array_map('intval', $request->permissions ?: []);
            $role->syncPermissions($permissions);

            // Guarda los cambios
            $role->save();

            // Redirecciona al index de roles con un mensaje de éxito
            return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente');
        } catch (\Exception $e) {
            // En caso de error, redirecciona de vuelta al formulario de edición con un mensaje de error
            return redirect()->back()->with('error', 'Se produjo un error al actualizar el rol: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role eliminado con éxito.');
    }
}
