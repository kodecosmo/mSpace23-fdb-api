<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Gender;
use App\Models\PerAccessToken;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Closure;

class UserController extends Controller
{
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required',
            'remember_me' => 'required|boolean',
            'token'=> 'exclude_if:remember_me,false|uuid',
        ]);
 
        if ($validator->fails()) {
             
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validator->errors(),
            ], 401);
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
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => ['required', 'email:rfc,dns', function (string $attribute, mixed $value, Closure $fail) {
                if ($value === 'foo') {
                    $fail("The {$attribute} is allready taken.");
                }
            }],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'whatsapp_number' => 'required',
            'description' => 'string|nullable',
            'gender_id' => 'exists:genders,id',
            'asset_id' => 'exists:assets,id',
            'remember_me' => 'required|boolean',
        ]);

        if ($validator->fails()) {
             
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validator->errors(),
            ]);
        }

        // Validated data may be accessed as an array...
        $user = $request->safe();
        
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $email = $user['email'];
        $password = $user['password'];
        $whatsapp_number = $user['whatsapp_number'];
        $description = $user['description'];
        $gender_id = $user['gender_id'];
        $asset_id = $user['asset_id'];
        $remember_me = $user['remember_me'];

        $authResult = $this->auth(['email' => $email]);

        // Check the user...
        if($authResult['success'] == false){

            try {
                
                $user = new User;
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->email = $email;
                $user->password = Hash::make($password);
                $user->whatsapp_number = $whatsapp_number;
                $user->description = $description;
                $user->gender()->associate(Gender::find($gender_id));
                $user->image()->associate(Asset::find($asset_id));
                $user->remember_me = $remember_me;
                $user->save();

                if($remember_me){

                    // token authentification should be checked first...
                    $token = new PerAccessToken;
                    $token->id = Str::uuid();
                    $token->last_used_at = now();
                    $token->save();

                    $user->lastToken()->associate($token);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'user created',
                    'data' => $user,
                ]);
            } catch (\Throwable $th) {
                
                return response()->json([
                    'success' => false,
                    'message' => 'unexpected error occured',
                ]);
            }
                
        }else{

            return response()->json([
                'success' => false,
                'message' => 'user account allready exists',
                'errors' => ['email' => 'user account allready exists'],
            ]);
        }

    }

    // Authentification...
    protected function auth(array $user){

        // token user verification
        $token = $user['token'];
        $email = $user['email'];
        $password = $user['password'];
        $remember_me = $user['remember_me'];

        /*  
        / If the user havent clicked the remember me option do not send the token. It will not generate a token.
        */
        if (isset($token)) {
            $rememberToken = PerAccessToken::whereId($token);

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


        // normal user verification...
        $user = User::where('email', $email);

        if ($user->exists()) {
                   
            if (Hash::check($password, $user->first()->password)) {

                try{
    
                    if($remember_me){

                        // token authentification should be checked first...
                        $token = new PerAccessToken;
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
                } catch (\Throwable $th) {
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'unexpected error occured',
                    ]);
                }

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
