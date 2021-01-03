<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {
        return view('frontend.dashboard.profile');
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail(Auth()->user()->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->reg_number = $request->nim;
            $user->linked_in = $request->linked_in;
            $user->save();

            DB::commit();
            return redirect()
                ->route('profile')
                ->with('success', 'Data berhasil dirubah');
        } catch (\Exception $error) {
            DB::rollback();
            Log::error($error);
        }
    }
}
