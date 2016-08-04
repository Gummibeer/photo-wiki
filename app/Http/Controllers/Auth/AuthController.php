<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Jrean\UserVerification\Exceptions\TokenMismatchException;
use Jrean\UserVerification\Exceptions\UserIsVerifiedException;
use Jrean\UserVerification\Exceptions\UserNotFoundException;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins, VerifiesUsers;

    protected $redirectTo = '/';
    protected $redirectIfVerificationFails = 'auth/login';

    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'getVerificationError', 'getVerification']]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nickname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:'.User::PASSWORD_MIN_LENGTH,
            'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getVerification(Request $request, $token)
    {
        $this->validateRequest($request);

        try {
            \UserVerification::process($request->input('email'), $token, $this->userTable());
        } catch (UserNotFoundException $e) {
            return redirect($this->redirectIfVerificationFails());
        } catch (UserIsVerifiedException $e) {
            return redirect($this->redirectIfVerified());
        } catch (TokenMismatchException $e) {
            return redirect($this->redirectIfVerificationFails());
        }

        $user = User::byEmail($request->input('email'))->first();
        \Auth::login($user);

        \Alert::success(trans('alerts.verification_success'))->flash();

        return redirect($this->redirectAfterVerification());
    }

    public function getVerificationError()
    {
        if (\Auth::check()) {
            \Auth::logout();
        }
        \Alert::danger(trans('alerts.verification_failed'))->flash();

        return $this->showLoginForm();
    }

    protected function authenticated(Request $request, User $user)
    {
        if ($user->verified) {
            return redirect()->intended($this->redirectPath());
        }

        return $this->getVerificationError();
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        \UserVerification::generate($user);
        \UserVerification::send($user, __('Photo-Wiki Bastätigungsemail'));

        \Alert::success(trans('alerts.verification_send'))->flash();

        return redirect($this->redirectPath());
    }
}
