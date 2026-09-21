<?php

namespace App\Http\Controllers;

use App\Traits\UsersAuthorizable;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

use App\DataTables\UserDataTable;

class UserController extends Controller
{
    use UsersAuthorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,UserDataTable $dataTable)
    {
        if($request->ajax()){
            return $dataTable->ajax();
        }
        return $dataTable->render('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['action'] = route('user.store');
        return view('user.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Hash Password sebelum disimpan
        $validatedData['password'] = Hash::make($validatedData['password']);

        // 3. Simpan ke Database
        $user = User::create($validatedData);

        // 4. User assign role User
        $user->assignRole('user');

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->data['user_data'] = $user;
        $this->data['action'] = route('user.update',$user->id);
        return view('user.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi Input (mengabaikan unique untuk user yang sedang diedit)
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // Password opsional saat update
        ]);

        // 2. Cek apakah password diisi atau tidak
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']); // Hapus dari array jika kosong agar tidak menimpa password lama
        }

        // 3. Update Data User
        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function role(User $user)
    {
        $this->data['roles'] = Role::all();
        $this->data['permissions'] = $user->getAllPermissions();
        $this->data['user'] = $user;
        //return $this->data['permissions'];
        $this->data['action'] = route('user.role.action',$user->id);
        return view('user.role', $this->data);
    }

    public function roleaction(Request $request, User $user)
    {
        $user->syncRoles($request['roles']);

        return redirect()->route('user.index')->with('success', 'Roles ' . $user->name . ' has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('User Banned'), 403);
    }
}
