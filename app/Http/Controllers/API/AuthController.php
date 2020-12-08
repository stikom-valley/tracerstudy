<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = [
            'reg_number' => 'required|exists:users,reg_number',
            'password' => 'required|min:8',
        ];

        $ruleMessages = [
            'reg_number.required' => 'NIM harus diisi',
            'reg_number.exists' => 'NIM tidak terdaftar',
            'password.required' => 'Kata Sandi harus diisi',
            'password.min' => 'Kata Sandi minimal 8 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all(),
            ]);
        }

        $credentials = $request->only('reg_number', 'password');

        $user = User::where('reg_number', $credentials['reg_number'])
            ->firstOrFail();

        if ($user->role_id != 3) {

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Anda bukan Alumni'
            ]);
        }

        try {

            if (!$token = auth('api')->attempt($credentials)) {

                return response()->json([
                    'status' => false,
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => ''
                ]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'could_not_create_token'
            ]);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $idUser = auth()->user()->id;

        $user = User::with('education')
            ->with(['education.faculty' => function ($query) {
                $query->select('id', 'name');
            }])->with(['education.major' => function ($query) {
                $query->select('id', 'name');
            }])->with(['experiences' => function ($query) {
                $query->latest()->first();
            }])->findOrFail($idUser);

        $entryYear = $user->education->entry_year;

        $friends = User::whereHas('education', function ($query) use ($entryYear) {
            $query->where('entry_year', $entryYear);
        })->with(['education.faculty' => function ($query) {
            $query->select('id', 'name');
        }])->with(['education.major' => function ($query) {
            $query->select('id', 'name');
        }])->get();

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'data' => [
                'user' => $user,
                'friends' => $friends,
            ]
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $token = JWTAuth::getToken();

        if ($token) {
            JWTAuth::setToken($token)->invalidate();
        }

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'message' => 'Anda berhasil keluar',
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'message' => 'Anda berhasil Masuk',
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 320,
            'access_token' => $token,
        ]);
    }

    public function register(Request $request)
    {
        $rules = [
            'reg_number' => 'required|exists:users,reg_number',
            'name' => 'required|min:3',
            'password' => 'required|min:8|confirmed',
        ];

        $ruleMessages = [
            'reg_number.required' => 'NIM harus diisi',
            'reg_number.exists' => 'NIM sudah terdaftar',
            'name.required' => 'Nama harus diisi',
            'name.min' => 'Nama minimal 3 karakter',
            'password.required' => 'Kata Sandi harus diisi',
            'password.min' => 'Kata Sandi minimal 8 karakter',
            'password.confirmed' => 'Kata Sandi tidak cocok',
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all(),
            ]);
        } else {

            $user = new User();

            $user->role_id = 3;
            $user->reg_number = $request->get('reg_number');
            $user->name = $request->get('name');
            $user->password = Hash::make($request->get('password'));

            $user->save();

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_CREATED,
                'message' => 'Pendaftaran Sukses'
            ]);
        }
    }
}
