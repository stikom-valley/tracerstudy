<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function show()
    {
        $idUser = auth()->user()->id;

        $user = User::findOrFail($idUser);

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_FOUND,
            'data' => $user,
        ]);
    }

    public function updateBio(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'gender' => 'required',
            'phone_number' => 'required',
            'address' => 'required|min:10',
            'is_married' => 'required',
            'birth_date' => 'required',
            'linked_in' => 'nullable|url',
        ];

        $ruleMessages = [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email salah',
            'gender.required' => 'Jenis Kelamin harus dipilih',
            'phone_number.required' => 'Nomor HP harus diisi',
            'address.required' => 'Alamat harus diisi',
            'address.min' => 'Alamat minimal 10 karakter',
            'is_married.required' => 'Status Nikah harus dipilih',
            'birth_date.required' => 'Tanggal Lahir harus dipilih',
            'linked_in.url' => 'Format URL tidak sesuai',
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all(),
            ]);
        }

        $idUser = auth()->user()->id;

        DB::beginTransaction();

        try {

            $user = User::findOrFail($idUser);

            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->phone_number = $request->phone_number;
            $user->address = $request->address;
            $user->is_married = $request->is_married;
            $user->birth_date = date('Y-m-d', strtotime($request->birth_date));
            $user->linked_in = $request->linked_in;

            $user->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_OK,
                'message' => 'Profile Anda telah diperbarui',
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Auch, ada yang salah',
            ]);
        }
    }

    public function updateAvatar(Request $request)
    {
        // dd($request->avatar);

        $rules = [
            'avatar' => 'nullable|image|max:2048',
        ];

        $ruleMessages = [
            'avatar.image' => 'Format foto tidak sesuai',
            'avatar.max' => 'Ukuran maksimum 2MB',
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all(),
            ]);
        }

        $idUser = auth()->user()->id;

        DB::beginTransaction();

        try {

            $filePath = 'public/uploads/avatar/';

            $storagePath = Storage::put($filePath, $request->avatar);

            $fileName = basename($storagePath);

            $user = User::findOrFail($idUser);

            if ($fileName != 'user.png') {
                Storage::delete($filePath . $user->avatar);
                $user->avatar = $fileName;
            }

            $user->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_OK,
                'message' => 'Foto profile Anda telah diperbarui',
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Auch, ada yang salah',
            ]);
        }
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'password' => 'required|min:8',
            'new_password' => 'required|min:8|confirmed'
        ];

        $ruleMessages = [
            'password.required' => 'sandi lama harus diisi',
            'password.min' => 'sandi lama minimal 8 karakter',
            'new_password.required' => 'sandi baru harus diisi',
            'new_password.min' => 'sandi baru minimal 8 karakter',
            'new_password.confirmed' => 'sandi baru tidak cocok',
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all(),
            ]);
        }

        $idUser = auth()->user()->id;

        $user = User::findOrFail($idUser);

        $hashedPassword = $user->password;
        $oldPassword = $request->password;
        $newPassword = $request->new_password;

        if (Hash::check($oldPassword, $hashedPassword)) {

            DB::beginTransaction();

            try {

                $user->password = Hash::make($newPassword);

                $user->save();

                DB::commit();

                return response()->json([
                    'status' => true,
                    'code' => Response::HTTP_OK,
                    'message' => 'Kata Sandi berhasil diganti'
                ]);
            } catch (Exception $e) {
                DB::rollback();
                Log::error($e);

                return response()->json([
                    'status' => false,
                    'code' => Response::HTTP_NOT_ACCEPTABLE,
                    'message' => 'Auch, ada yang salah!'
                ]);
            }
        } else {
            
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Sandi tidak cocok'
            ]);
        }
    }
}
