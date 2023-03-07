<?php

namespace App\Http\Controllers\PostControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\returnSelf;

class AccountController extends Controller
{
    public function signUp(Request $request)
    {
        $errs = [];
        $request->flashOnly(['email', 'name', 'surname']);
        if ($request->input('email') == '') $errs['email'] = 'Почта обязательное поле!';
        if ($request->input('password') == '') $errs['password'] = 'Пароль обязательное поле!';
        if ($request->input('name') == '') $errs['name'] = 'Имя обязательное поле!';
        if ($request->input('surname') == '') $errs['surname'] = 'Фамилия обязательное поле!';
        if ($request->input('confirmPassword') == '') $errs['confirm-password'] = 'Подтверждение пароля обязательное поле!';
        if ($request->input('confirmPassword') != $request->input('password')) $errs['password'] = 'Пароли не совпадают!';

        if (sizeof(User::where('email', $request->input('email'))->get())) $errs['email'] = 'Данная почта уже используется!';

        if ($errs) return redirect()->back()->withInput()->withErrors([$errs]);

        $user = new User();
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->password = $request->input('password');
        $user->save();

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return redirect()->route('account.personal');
        } else {
            return 'error';
        };
    }

    public function login(Request $request)
    {
        $errs = [];
        $request->flashOnly(['email', 'remember']);
        if ($request->input('email') == '') $errs['email'] = 'Почта обязательное поле!';
        if ($request->input('password') == '') $errs['password'] = 'Пароль обязательное поле!';

        if ($errs) return redirect()->back()->withInput()->withErrors($errs);

        $remember = $request->has('remember') ? true : false;

        // dd($remember);

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember)) {
            return redirect()->route('account.personal');
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'Пользователь не найден']);
        };
    }

    public function editInformation(Request $request)
    {
        $errs = [];
        // if($request->input('email') == '')

        if (Auth::user()->email != $request->input('email') && User::where('email', $request->input('email'))->first()) $errs['email'] = 'Данная почта уже кем-то используется!';

        if ($errs) {
            $errs['personal'] = true;
            return redirect()->back()->withErrors($errs);
        };

        $user = User::find(Auth::user()->id);
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->save();

        return redirect()->back()->with(['for' => 'personal', 'success' => 'Изменения сохранены!']);
    }

    public function editPassword(Request $request)
    {
        $errs = [];

        if(!Hash::check($request->input('oldPassword'), Auth::user()->password)) $errs['oldPassword'] = 'Старый пароль не верный!';
        if($request->input('newPassword') != $request->input('confirmNewPassword')) $errs['confirmPassword'] = 'Пароли не совпадают!';

        if($errs) {
            $errs['password'] = true;
            return redirect()->back()->withErrors($errs);
        }

        $user = User::find(Auth::user()->id);
        $user->password = $request->input('newPassword');
        $user->save();
        
        return redirect()->back()->with(['for' => 'password', 'success' => 'Изменения сохранены!']);
    }
}
