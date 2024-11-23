<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActiveAccountRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResendCodeRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Mail\WelcomeEmail;
use App\Models\Media;
use App\Models\RankPoint;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\UserPoints;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
//        $code = mt_rand(100000, 999999);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'remember_token' => Str::random(50),
            'password' => hash::make($request->password),
            'country' => $request->country,
            'gender' => $request->gender,
            'avatar_id' => $request->avatar ? $request->avatar : 1,
            'role_id' => 2,
//            'verify_code' => $code
        ]);

        $this->sendCode($user, 'Welcome to Our Application');
//        Mail::to($request->email)->send(new WelcomeEmail($code));

        return response()->json([
            'status' => 'success',
            'message' => 'The activation code has been sent to the email you entered, Please Active account to login',
            'data' => ['email' => $request->email],
            'token' => ''
        ], 200);
    }

    public function activeAccount(ActiveAccountRequest $request)
    {
        $email = $request->email;
        $userData = User::query()->where('email', $email)->first();

        if (!isset($userData)) {
            return response()->json([
                'status' => 'error',
                'message' => 'The provided credentials are incorrect.',
                'data' => [],
                'token' => ''
            ], 400);
        }

        if ($userData->verify_code != $request->code) {
            return response()->json([
                'status' => 'error',
                'message' => 'The activation code is invalid',
                'data' => [],
                'token' => ''
            ], 400);
        }
        $userData->verify_code = null;
        $userData->email_verified_at = date('Y-m-d H:i:s');
        $userData->save();

        Auth::login($userData);

        $this->addPoints(auth()->user()->id, 10);
        UserLogin::create([
            'user_id' => $userData->id,
            'login_date' => Carbon::today()
        ]);
        $token = $userData->createToken('mobileApp');
        $data = [
            'username' => $userData->username,
            'email' => $userData->email,
            "country" => $userData->country,
            "gender" => $userData->gender,
            'avatar' => $userData->avatar_id,
            'overall_rank' => $userData->overall_rank,
            'monthly_rank' => $userData->monthly_rank,
            'week_rank' => $userData->week_rank,
            'app_week_rank' => $userData->app_week_rank,
        ];

        $media = Media::query()->where('category_id','signUp')->where('avatar_id',auth()->user()->avatar_id)->get();

        if(count($media) > 0){
            $rand = rand(0,count($media)-1);
            $media = $media[$rand];
            return response()->json([
                'status' => 'success',
                'message' => 'The account has been activated successfully',
                'data' => $data,
                'media' =>[
                    'link' => $media->link,
                    'type' => $media->type,
                    'duration' =>$media->duration,
                    'avatar_id' => $media->avatar_id,
                    'category_id' => $media->category_id
                ],
                'token' => $token->plainTextToken
            ], 200);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'The account has been activated successfully',
            'data' => $data,
            'media' =>[
                'link' => '',
                'type' => '',
                'duration' =>0,
                'avatar_id' => auth()->user()->avatar_id,
                'category_id' => 'signUp'
            ],
            'token' => $token->plainTextToken
        ], 200);

//        return response()->json([
//            'status' => 'success',
//            'message' => 'The account has been activated successfully',
//            'data' => $data,
//            'token' => $token->plainTextToken
//        ], 200);

    }

    public function resendCode(ResendCodeRequest $request)
    {
        $user = User::query()->where('email', $request->email)->first();
        $this->sendCode($user, 'New Activation Code');

        return response()->json([
            'status' => 'success',
            'message' => 'The activation code has been sent to the email you entered, Please Active account to login',
            'data' => ['email' => $request->email],
            'token' => ''
        ], 200);
    }

    public function forgetPassword(ResendCodeRequest $request)
    {
        $user = User::query()->where('email', $request->email)->first();
        $this->sendCode($user, 'Confirmation Code');

        return response()->json([
            'status' => 'success',
            'message' => 'The Confirmation code has been sent to the email you entered',
            'data' => ['email' => $request->email],
            'token' => ''
        ], 200);
    }

    public function verifyCode(ActiveAccountRequest $request)
    {
        $email = $request->email;
        $userData = User::query()->where('email', $email)->first();

        if (!isset($userData)) {
            return response()->json([
                'status' => 'error',
                'message' => 'The provided credentials are incorrect.',
                'data' => [],
                'token' => ''
            ], 400);
        }

        if ($userData->verify_code != $request->code) {
            return response()->json([
                'status' => 'error',
                'message' => 'The confirmation code is invalid',
                'data' => [],
                'token' => ''
            ], 400);
        }
        $userData->verify_code = null;
        $userData->remember_token = Str::random(50);
        $userData->save();


        return response()->json([
            'status' => 'success',
            'message' => 'The confirmation code is valid',
            'data' => ['email' => $request->email],
            'token' => $userData->remember_token
        ], 200);

    }

    public function resetPassword(ResetPasswordRequest $request)
    {

        $user = User::where('remember_token', $request->token)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(50);
            $user->save();

            Auth::login($user);

            $this->userPoint(auth()->user()->id);
            $user = auth()->user();
            $user->tokens()->delete();
            $token = $user->createToken('mobileApp');
            $data = [
                'username' => $user->username,
                'email' => $user->email,
                "country" => $user->country,
                "gender" => $user->gender,
                'avatar' => $user->avatar_id,
                'overall_rank' => $user->overall_rank,
                'monthly_rank' => $user->monthly_rank,
                'week_rank' => $user->week_rank,
                'app_week_rank' => $user->app_week_rank,
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'The password changed successfully',
                'data' => $data,
                'token' => $token->plainTextToken
            ], 200);

        }
        {
            return response()->json([
                'status' => 'error',
                'message' => 'The provided data are incorrect.',
                'data' => [],
                'token' => ''
            ], 400);
        }


    }

    public function sendCode($user, $subject): void
    {
        $code = mt_rand(100000, 999999);

        $user->verify_code = $code;
        $user->save();

        Mail::to($user->email)->send(new WelcomeEmail($code, $subject));

    }

    public function login(LoginRequest $request)
    {

        $email = $request->email;
        $userData = User::query()->where('email', $email)->first();

        if (!isset($userData)) {
            return response()->json([
                'status' => 'error',
                'message' => 'The provided credentials are incorrect.',
                'data' => [],
                'token' => ''
            ], 400);
        }

        if (is_null($userData->email_verified_at)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please Active account to login',
                'data' => [],
                'token' => ''
            ], 400);
        }

        $credentials = $request->only('email', 'password');

        $data = [
            'username' => $userData->username,
            'email' => $userData->email,
            "country" => $userData->country,
            "gender" => $userData->gender,
            'avatar' => $userData->avatar_id,
            'overall_rank' => $userData->overall_rank,
            'monthly_rank' => $userData->monthly_rank,
            'week_rank' => $userData->week_rank,
            'app_week_rank' => $userData->app_week_rank,
        ];
        if (Auth::attempt($credentials)) {
            $this->userPoint(auth()->user()->id);
            $media = Media::query()->where('category_id','logIn')->where('avatar_id',auth()->user()->avatar_id)->get();
            $user = auth()->user();
            $user->tokens()->delete();
            $token = $userData->createToken('mobileApp');
            if(count($media) > 0){
                $rand = rand(0,count($media)-1);
                $media = $media[$rand];
                return response()->json([
                    'status' => 'success',
                    'message' => '',
                    'data' => $data,
                    'media' =>[
                        'link' => $media->link,
                        'type' => $media->type,
                        'duration' =>$media->duration,
                        'avatar_id' => $media->avatar_id,
                        'category_id' => $media->category_id
                    ],
                    'token' => $token->plainTextToken
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => '',
                'data' => $data,
                'media' =>[
                    'link' => '',
                    'type' => '',
                    'duration' => 0,
                    'avatar_id' => auth()->user()->avatar_id,
                    'category_id' => 'logIn'
                ],
                'token' => $token->plainTextToken
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'The provided credentials are incorrect.',
                'data' => [],
                'token' => ''
            ], 400);
        }

    }


    public function userPoint($user_id)
    {

        $today = Carbon::today();

        // تحقق مما إذا كان هناك تسجيل دخول سابق في نفس اليوم
        $loginExists = UserLogin::where('user_id', $user_id)
            ->whereDate('login_date', $today)
            ->exists();

        if (!$loginExists) {
            // تسجيل الدخول الجديد لليوم
            UserLogin::create([
                'user_id' => $user_id,
                'login_date' => $today
            ]);

            // إضافة نقطة لتسجيل الدخول اليومي
            $this->addPoints($user_id, 1);

            // تحقق من تسجيل الدخول الأسبوعي والشهري
            $this->checkAndAddWeeklyAndMonthlyPoints($user_id);
        }
    }

    private function addPoints($user_id, int $points)
    {
        $userPoint = UserPoints::firstOrCreate(['user_id' => $user_id]);
        RankPoint::create([
            'user_id' => $user_id,
            'points' => $points,
            'type' => 'normal'
        ]);
        $userPoint->points += $points;
        $userPoint->save();
    }

    private function checkAndAddWeeklyAndMonthlyPoints($user_id)
    {
        $today = Carbon::today();

        // جلب آخر تسجيل دخول
        $lastLogin = UserLogin::where('user_id', $user_id)
            ->orderBy('login_date', 'desc')
            ->first();

        if ($lastLogin) {
            // تحويل تاريخ تسجيل الدخول الأخير إلى كائن Carbon
            $lastLoginDate = Carbon::parse($lastLogin->login_date);

            // إذا فات يوم
            if ($lastLoginDate->diffInDays($today) > 1) {
                // حذف تسجيلات الدخول القديمة إذا فات يوم
                UserLogin::where('user_id', $user_id)
                    ->where('login_date', '<', $today->subDays(6))
                    ->delete();
            }
        }

        // حساب عدد الأيام المتتالية التي قام فيها المستخدم بتسجيل الدخول
        $consecutiveLogins = UserLogin::where('user_id', $user_id)
            ->whereDate('login_date', '>=', $today->subDays(6))
            ->count();

        if ($consecutiveLogins == 7) {
            // إضافة نقاط الأسبوع المتواصل
            $this->addPoints($user_id, 5);
        }

        // حساب عدد الأيام المتتالية في الشهر
        $monthlyConsecutiveLogins = UserLogin::where('user_id', $user_id)
            ->whereDate('login_date', '>=', $today->subDays(29))
            ->count();

        if ($monthlyConsecutiveLogins == 30) {
            // إضافة نقاط الشهر المتواصل
            $this->addPoints($user_id, 15);
        }
    }


    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $userData = User::where(['id' => Auth::guard('sanctum')->user()->id])->first();
            $userData->update([
                'username' => $request->username,
                'avatar_id' => $request->avatar
            ]);
            if (isset($request->password)) {
                $userData->password = Hash::make($request->password);
                $userData->save();
            }
            $data = [
                'username' => $userData->username,
                'email' => $userData->email,
                "country" => $userData->country,
                "gender" => $userData->gender,
                'avatar' => $userData->avatar_id,
                'overall_rank' => $userData->overall_rank,
                'monthly_rank' => $userData->monthly_rank,
                'week_rank' => $userData->week_rank,
                'app_week_rank' => $userData->app_week_rank,
            ];
            return response()->json([
                'status' => 'success',
                'message' => '',
                'data' => $data,
                'token' => ""
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred, please try again',
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out of application.',
            'data' => [],
            'token' => ''
        ], 200);
    }

    public function testAuth()
    {

        return Auth::user();

    }


}
