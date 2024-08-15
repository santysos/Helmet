<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empresa;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('empresa')->paginate(20);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $empresas = Empresa::all();
        $roles = Role::all();
        return view('users.create', compact('empresas', 'roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'empresa_id' => 'required|exists:empresas,id',
            'role' => 'required|exists:roles,name',  // Validar el rol
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'empresa_id' => $request->empresa_id,
        ]);

        // Asignar el rol al usuario
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Usuario creado con éxito.');
    }

    public function show($id)
    {
        $user = User::with('empresa')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $empresas = Empresa::all();
        $roles = Role::all();
        return view('users.edit', compact('user', 'empresas', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'empresa_id' => 'required|exists:empresas,id',
            'role' => 'required|exists:roles,name',  // Validar el rol
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->empresa_id = $request->empresa_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Asignar el rol al usuario
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado con éxito.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado con éxito.');
    }
}
