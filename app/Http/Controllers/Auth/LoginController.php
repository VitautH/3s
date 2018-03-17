<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{


    use AuthenticatesUsers;


    protected $redirectTo = '/timesheet';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'login';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // проверка на количество попыток ввода
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // проверка на заблокированного юзера
        if ($this->isBlocked($request)) {
            $message = Lang::get('auth.blocked');

            $errors = [$this->username() => $message];

            if ($request->expectsJson()) {
                return response()->json($errors, 423);
            }

            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors($errors);
        }

        // если правильно залогинился
        if ($this->attemptLogin($request)) {

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/timesheet';
    }

    public function authenticated()
    {
        return redirect('/timesheet');
    }

    protected function credentials(Request $request)
    {
        return $request->only('login', 'password');
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|email',
            'password' => 'required|string',
        ]);
    }

    protected function isBlocked(Request $request)
    {
        if ($user = User::where('login', $request->only('login')['login'])->first(['is_block'])) {
            return $user->getAttributes()['is_block'];
        }
    }

}
