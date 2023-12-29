<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\RecoverRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Mail\RecoverPasswordMail;
use App\Models\InfoUser;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;
use Toastr;

class UserController extends Controller
{
    public function index()
    {
        return view('user.home', [
            'title' => 'Trang người dùng',
            'user' => Auth::user(),
        ]);
    }

    public function login()
    {
        return view('user.login.index', [
            'title' => 'Đăng nhập'
        ]);
    }

    public function forgot()
    {
        return view('user.forgot.index');
    }

    public function recover(RecoverRequest $request)
    {
        if (!$user = User::firstWhere('email', $request->input('email'))) {
            Toastr::error('Email không tồn tại!', 'Thông báo');

            return redirect()->back();
        }
        $source = [
            'a', 'b', 'c', 'd', 'e', 'g', 1, 2, 3, 4, 5, 6
        ];
        $new_password = '';
        foreach ($source as $s) {
            $new_password .= $source[rand(0, count($source) - 1)];
        }
        $reset_password = $user->update([
            'password' => Hash::make($new_password)
        ]);
        if ($reset_password) {
            Mail::to($request->input('email'))->send(new RecoverPasswordMail($new_password));
        }
        Toastr::success('Lấy mật khẩu thành công! Hãy kiểm tra email của bạn', 'Thông báo');

        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('users.login');
    }

    public function checkLogin(LoginRequest $request)
    {
        $tel_or_email = $request->input('tel_or_email');
        if (Auth::attempt([
            is_numeric($tel_or_email) ? 'name' : 'email' => $tel_or_email,
            'password' => $request->input('password')
        ])) {
            Toastr::success('Đăng nhập thành công', 'Thông báo');
            $user = Auth::user();

            return redirect()->route($user->role == 1 ? 'admin.index' : 'users.home');
        }
        Toastr::error('Tài khoản hoặc mật khẩu không chính xác', 'Thông báo');

        return redirect()->back();
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $rs = User::firstWhere('email', $request->input('email'))->update([
            'password' => Hash::make($request->input('password'))
        ]);
        if ($rs) {
            Toastr::success('Đổi mật khẩu thành công', 'Thông báo');

            return response()->json([
                'status' => 0,
                'message' => 'Đổi mật khẩu thành công'
            ]);
        }
        Toastr::error('Đổi mật khẩu thất bại', 'Thông báo');

        return response()->json([
            'status' => 1,
            'message' => 'Đổi mật khẩu thất bại'
        ]);
    }

    public function register()
    {
        return view('user.register.index', [
            'title' => 'Đăng ký',
        ]);
    }

    public function checkRegister(RegisterRequest $request)
    {
        $tel_or_email = $request->input('tel_or_email');
        $check = User::where(is_numeric($tel_or_email) ? 'name' : 'email', $tel_or_email)
            ->get();
        if ($check->count() > 0) {
            Toastr::error('Tài khoản đã có người đăng ký!', __('title.toastr.fail'));

            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $user = User::create([
                is_numeric($tel_or_email) ? 'name' : 'email' =>  $tel_or_email,
                'password' => Hash::make($request->input('password'))
            ]);
            InfoUser::create([
                'name' =>  $tel_or_email,
                'user_id' => $user->id
            ]);
            Toastr::success('Đăng ký thành công', 'Thông báo');
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Toastr::error(__('message.fail.register'), 'Thông báo');

            return redirect()->back();
        }

        return redirect()->route('users.login');
    }
}
