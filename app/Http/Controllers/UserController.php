<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalBPA = User::where('role_id', 1)->count();
        $totalWarek = User::where('role_id', 2)->count();
        $totalAlumni = User::where('role_id', 3)->count();

        $users = User::all();

        return view('frontend.dashboard.users.index')
            ->with([
                'users' => $users,
                'totalBPA' => $totalBPA,
                'totalWarek' => $totalWarek,
                'totalAlumni' => $totalAlumni,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('frontend.dashboard.users.create')
            ->with([
                'roles' => $roles,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'role_id' => 'required',
            'name' => 'required|min:3',
            'reg_number' => 'required|min:3|unique:users,reg_number',
            'password' => 'required|min:8|confirmed'
        ];

        $ruleMessages = [
            'role_id.required' => 'Hak Akses harus dipilih',
            'name.required' => 'Nama harus diisi',
            'name.min' => 'Nama minimal 3 karakter',
            'reg_number.required' => 'ID Pengguna harus diisi',
            'reg_number.min' => 'ID Pengguna minimal 3 karakter',
            'reg_number.unique' => 'ID Pengguna sudah terdaftar',
            'password.required' => 'Sandi baru harus diisi',
            'password.min' => 'Sandi baru minimal 8 karakter',
            'password.confirmed' => 'Sandi baru tidak cocok',
        ];

        $this->validate($request, $rules, $ruleMessages);

        $role = $request->role_id;
        $name = $request->name;
        $regNumber = $request->reg_number;
        $password = $request->password;

        DB::beginTransaction();

        try {

            $user = new User();

            $user->role_id = $role;
            $user->name = $name;
            $user->reg_number = $regNumber;
            $user->password = Hash::make($password);

            $user->save();

            DB::commit();

            return redirect()
                ->route('user.index')
                ->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return redirect()
                ->back()
                ->with('error', 'Auch, ada yang salah!');
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
        $user = User::findOrFail($id);

        $roles = Role::all();

        return view('frontend.dashboard.users.edit')
            ->with([
                'user' => $user,
                'roles' => $roles,
            ]);
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
        $rules = [
            'role_id' => 'required',
            'name' => 'required|min:3',
            'reg_number' => 'required|min:3|unique:users,reg_number,' . $id,
        ];

        $ruleMessages = [
            'role_id.required' => 'Hak Akses harus dipilih',
            'name.required' => 'Nama harus diisi',
            'name.min' => 'Nama minimal 3 karakter',
            'reg_number.required' => 'ID Pengguna harus diisi',
            'reg_number.min' => 'ID Pengguna minimal 3 karakter',
            'reg_number.unique' => 'ID Pengguna sudah terdaftar',
        ];

        $this->validate($request, $rules, $ruleMessages);

        $role = $request->role_id;
        $name = $request->name;
        $regNumber = $request->reg_number;

        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            $user->role_id = $role;
            $user->name = $name;
            $user->reg_number = $regNumber;

            $user->save();

            DB::commit();

            return redirect()
                ->route('user.index')
                ->with('success', 'Pengguna berhasil diperbarui!');
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return redirect()
                ->back()
                ->with('error', 'Auch, ada yang salah!');
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
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'message' => 'Pengguna berhasil dihapus',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8|confirmed|different:old_password'
        ];

        $ruleMessages = [
            'old_password.requred' => 'Sandi lama harus diisi',
            'old_password.min' => 'Sandi lama minimal 8 karakter',
            'new_password.required' => 'Sandi baru harus diisi',
            'new_password.min' => 'Sandi baru minimal 8 karakter',
            'new_password.confirmed' => 'Sandi baru tidak cocok',
            'new_password.different' => 'Sandi baru harus berbeda'
        ];

        $this->validate($request, $rules, $ruleMessages);

        $oldPassword = $request->old_password;
        $newPassword = $request->new_password;
        $idUser = $request->user_id;

        $user = User::find($idUser);

        if (Hash::check($oldPassword, $user->password)) {

            DB::beginTransaction();
            try {
                $user->password = Bcrypt($newPassword);

                $user->save();

                DB::commit();

                return redirect()
                    ->route('user.index')
                    ->with('info', 'Kata sandi telah diganti!');
            } catch (Exception $e) {
                DB::rollback();
                Log::error($e);

                return redirect()
                    ->back()
                    ->with('error', 'Auch, ada yang salah!');
            }
        } else {

            return redirect()
                ->back()
                ->with('error', 'Sandi tidak cocok!');
        }
    }
}
