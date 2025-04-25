<?php

namespace App\Http\Controllers;

use App\Models\HrdKaryawan;
use App\Models\SsoRole;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'karyawan'])->orderBy('kd_karyawan')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $employees = HrdKaryawan::whereDoesntHave('user')
            ->where('STATUS_PEG', 1)
            ->orderBy('KD_KARYAWAN')
            ->get();

        $roles = SsoRole::all();

        return view('user.create', compact('employees', 'roles'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kd_karyawan'   => 'required',
                'password'      => 'required'
            ]);

            // check already user
            $user = User::where('kd_karyawan', $request->kd_karyawan)->first();
            if (!empty($user)) throw new Exception('Employee account already exists');

            // check employee data
            $employee = HrdKaryawan::where('KD_KARYAWAN', $request->kd_karyawan)->first();
            if (empty($employee)) throw new Exception('Employee not found');

            User::create([
                'kd_karyawan'   => $employee->KD_KARYAWAN,
                'name'          => $employee->NAMA,
                'email'         => $employee->EMAIL,
                'password'      => Hash::make($request->password),
                'sso_role_id'   => $request->sso_role_id,
                'is_active'     => 1
            ]);

            return to_route('user.index')->with('success', 'Employee account created successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($idEncrypt)
    {
        $id = decrypt($idEncrypt);

        $user = User::find($id);
        if (empty($user)) return back()->with('error', 'User not found');
        $roles = SsoRole::all();

        return view('user.edit', compact('user', 'roles'));
    }

    public function update($idEncrypt, Request $request)
    {
        try {
            $id = decrypt($idEncrypt);

            // check already user
            $user = User::find($id);
            if (empty($user)) throw new Exception('Employee account not found');

            // check employee data
            $employee = HrdKaryawan::where('KD_KARYAWAN', $user->kd_karyawan)->first();
            if (empty($employee)) throw new Exception('Employee not found');

            $data = [
                'kd_karyawan'   => $employee->KD_KARYAWAN,
                'name'          => $employee->NAMA,
                'email'         => $employee->EMAIL,
                'sso_role_id'   => $request->sso_role_id,
                'is_active'     => 1
            ];

            if (!empty($request->password)) $data['password'] = Hash::make($request->password);

            User::where('id', $user->id)->update($data);
            return to_route('user.index')->with('success', 'Employee account updated successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'id'    => 'required'
            ]);

            $id = decrypt($request->id);
            $user = User::find($id);
            if (empty($user)) throw new Exception('Employee account not found');

            $user->delete();

            return back()->with('success', 'Employee account deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
