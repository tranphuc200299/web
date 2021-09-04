<?php

namespace Package\Modules\Auth\Http\Controllers\Web;

use Core\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Modules\Auth\Services\ResetPasswordService;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $resetPasswordService;
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * ResetPasswordController constructor.
     *
     * @param  ResetPasswordService $resetPasswordService
     */
    public function __construct(ResetPasswordService $resetPasswordService)
    {
        $this->middleware('guest');
        $this->resetPasswordService = $resetPasswordService;
        $this->redirectTo = route('cp');
    }

    public function showResetForm(Request $request)
    {
        $query = $request->query();
        $email = (array_values($query))[1];
        $checkExpire = $this->resetPasswordService->checkExpire($email);
        if (is_null($checkExpire)) {
            return view('auth::passwords.expire_time');
        } else {
            return view('auth::passwords.reset')->with(
                ['token' => $request->token, 'email' => $request->email]
            );
        }
    }

    protected function resetPassword($user, $password)
    {
        $this->resetPasswordService->resetPassword($user, $password);
    }

    protected function rules()
    {
        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8|max:20',
        ];
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $broker = $this->broker();

        $response = $broker->reset($this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', trans('更新は完了しました。'));
        } else {
            return redirect()->route('login')->with('fail', trans('更新は失敗しました。'));
        }
    }
}
