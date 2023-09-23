<?php

namespace App\Http\Controllers;

use App\Models\PersonalAccessTokens;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'remember_me' => 'required|boolean',
            'token'=> 'exclude_if:remember_me,false|uuid',
        ]);
 
        if ($validator->fails()) {
             
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validator->errors(),
            ]);
        }
        
        // Validated data may be accessed as an array...
        $validated = $request->safe();
        
        $email = $validated['email'];
        $password = $validated['password'];
        $remember_me = $validated['remember_me'];
        $token = $validated['token'];

        $authResult = $this->auth([
            'email' => $email, 
            'password' => $password, 
            'remember_me' => $remember_me,
            'token' => $token,
        ]);

        return response()->json($authResult);

    }

    public function register(Request $request){
        
    }

    // Authentification
    protected function auth(array $user){

        // token user verification
        $token = $user['token'];
        $email = $user['email'];
        $password = $user['password'];
        $remember_me = $user['remember_me'];


        if (isset($token)) {
            $rememberToken = PersonalAccessTokens::whereId($remember_me);

            if ($rememberToken->exists()){

                $user = User::with('lastToken')->whereId($rememberToken->user);
                
                if ($user->exists()){

                    return [
                        'success' => true,
                        'message' => 'user logged',
                        'data' => [
                            $user->first()
                        ],
                    ];

                }else{

                    return [
                        'success' => false,
                        'message' => 'these credentials do not match our records',
                        'errors' => [
                            'email' => 'these credentials do not match our records',
                        ],
                    ];
                }

            }else{

                return [
                    'success' => false,
                    'message' => 'invalid token',
                    'errors' => [
                        'token' => 'invalid token',
                    ],
                ];
            }

        }


        // normal user verification
        $user = User::where('email', $email);

        if ($user->exists()) {
                   
            if (Hash::check($password, $user->first()->password)) {

                if($remember_me){

                    // token authentification should be checked first...
                    $token = new PersonalAccessTokens;
                    $token->id = Str::uuid();
                    $token->last_used_at = now();
                    $token->save();

                    $user->lastToken()->associate($token);
                }
     
                return [
                    'success' => true,
                    'message' => 'user logged',
                    'data' => [
                        $user->first()
                    ],
                ];

            }else{
                        
                return [
                    'success' => false,
                    'message' => 'incorrect password',
                    'errors' => [
                        'password' => 'incorrect password',
                    ],
                ];
            }
        }else{
            
            return [
                'success' => false,
                'message' => 'these credentials do not match our records',
                'errors' => [
                    'email' => 'these credentials do not match our records',
                ],
            ];
        }
    }
}
