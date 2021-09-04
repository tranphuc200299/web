<?php

namespace Modules\Auth\Http\Controllers\Web;

use Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Entities\Models\User;
use Modules\Auth\Services\UserService;

class SocialiteController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function authGoogleUrl()
    {
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();

        return redirect($url);
    }

    public function authGoogle(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        /* @var $user User*/
        $user = $this->userService->findByEmail($googleUser->getEmail());

        if (!$user) {
            $dataUser = [
                'name'     => $googleUser->getName(),
                'email'    => $googleUser->getEmail(),
                'status'   => AuthConst::USER_ENABLE,
                'gender'   => (!empty($googleUser->user['gender']) && $googleUser->user['gender'] == 'male') ? AuthConst::USER_GENDER_MALE : AuthConst::USER_GENDER_FEMALE,
                'password' => Hash::make('123456'),
            ];

            if (!empty($googleUser->user['picture'])) {
                $name = uniqid() . "-" . time() . '.png';

                $path = date('Y') . "/" . date('m') . "/" . date('d');

                Storage::put($path . "/" . $name, file_get_contents($googleUser->user['picture']));

                $dataUser['picture'] = $path . "/" . $name;
            }

            $user = $this->userService->create($dataUser);
        }

        if ($user && $user->isActive()) {
            Auth::login($user);

            return redirect('cp');
        }

        return redirect()->route('auth.login');
    }
}
