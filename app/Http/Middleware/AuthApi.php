<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\User\UserRepository;

class AuthApi
{

    protected $userRepository;

    public function __construct(UserRepository $user)
    {
        $this->userRepository = $user;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $auth = Str::replaceFirst('Basic ', '', $request->header('Authorization'));

            if(empty($auth)){
                throw new Exception("You must Login");
            }

            $userData = $this->decodeToken($auth);
            
            $request->user_id_from_header = $userData[0];
            $user                         = $this->userRepository->requiredById($userData[0]);
            $request->user                = $user;

            if ($user->api_token != $userData[1]) {
                throw new Exception('Wrong credentials');
            }

            return $next($request);

        } catch (Exception $exception) {
            $content = [
                'code' => 401,
                'code_message' => trans('auth.failed'),
                'code_type' => 'unauthorized',
                'data' => ['authorization' => $request->header('Authorization')],
            ];

            return response()->json($content, 401);
        }
    }

    private function decodeToken($token)
    {
        $auth       = base64_decode($token);
        $extract    = explode(":", $auth);
        
        return $extract;
    }
}
