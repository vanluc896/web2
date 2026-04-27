<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AuthController extends Controller
{
    //Hiển thị trang đăng nhập
    public function showLogin()
    {
        if(Auth::check())
            {
                return redirect()->intended(route('ad.dashboard'));
            }
        return view('admin.login');
    }

    //Xử lý đăng nhập 
    public function login(Request $request)
    {
        
        // validate - kiểm tra dữ liệu đầu vào
        // bổ sung thêm một số ràng buộc khác - nếu có
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'username' => 'Tên đăng nhập',
                'password' => 'Mật khẩu',
            ]
        );

        // first(): lấy ra record đầu tiên khi truy vấn dữ liệu
        $user = User::where('username', $request->username)
         ->first();

        // Nếu không thấy người dùng trong bảng users
        if (!$user) 
            {
            // điều hướng về view login theo route name (đặt trong web.php)
            return back()
                ->with('message', 'Username không tồn tại')
                ->withInput();
            }

        // Nếu tìm thấy người dùng thì kiểm tra mật khẩu
        // do mật khẩu dùng Hash::make() để mã hóa, nên cần so sánh phải dùng với hàm Hash::check()
        $check = Hash::check($request->password, $user->password); // true hoặc false
        // trường hợp mật khẩu không khớp
        if (!$check) 
            {
            // điều hướng về view login theo route name (đặt trong web.php)
            return back()->with('message', 'Mật khẩu không đúng')->withInput();
            }

        // Nếu thông tin đăng nhập đúng thì lưu thông tin người dùng vào session với Auth::login($user)
        // Nếu biến $remember có giá trị true (nếu người dùng chọn nhớ tài khoản)
        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);
        $request->session()->regenerate();

        // sử dụng intended để điều hướng về URL mà người dùng muốn truy cập
        // nếu không có thì điều hướng về dashboard (route name dashboard được khai báo trong web.php)
        return redirect()->intended(route('ad.dashboard'));
        
    }

 public function logout(Request $request)
    {
        ///Lấy thông tin user đã đăng nhập
        $user=Auth::user();
        //Xóa remember_token của user trong bảng users
        if($user)
            {
                User::where('id', $user->id)->update([
                    'remember_token'=>null
                ]);
            }
            //Đăng xuất User
            Auth::logout();
            //Xóa session hiện tại
            $request->session()->invalidate();
            //Tạo lại csrf token mới
            $request->session()->regenerateToken();
            //redirect về trang login
            return redirect()->route('ad.login');

    }
     public function editPassword($id)
    {
        if (!Auth::check() || (Auth::id() != $id && Auth::user()->role != 1)) {
            abort(403, 'Bạn không có quyền truy cập');
        }

        $model = User::findOrFail($id);
        return view('admin.users.edit-password', compact('model'));
    }

    public function updatePassword(Request $request, $id)
{
    if (!Auth::check() || (Auth::id() != $id && Auth::user()->role != 1)) {
        abort(403, 'Bạn không có quyền truy cập');
    }

    $request->validate([
        'current_password' => 'required',
        'password' => 'required|min:6|max:20|confirmed',
    ], [
        'current_password.required' => 'Mật khẩu hiện tại không được để trống',
        'password.required' => 'Mật khẩu không được để trống',
        'password.min' => 'Mật khẩu tối thiểu :min ký tự',
        'password.max' => 'Mật khẩu tối đa :max ký tự',
        'password.confirmed' => 'Xác nhận mật khẩu không khớp',
    ]);

    $model = User::findOrFail($id);

    //kiểm tra mật khẩu hiện tại
    if (!Hash::check($request->current_password, $model->password)) {
        return back()->with('message', 'Mật khẩu hiện tại không đúng');
    }

    try {
        $model->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('ad.dashboard')
            ->with('message', 'Cập nhật mật khẩu thành công');

    } catch (QueryException $e) {
        return back()
            ->with('message', 'Lỗi DB: thực hiện thất bại')
            ->withInput();
    }
}

    // showForgot,forgot=>gửi mật khẩu về email
    public function showForgot()
    {
        return view('admin.forgot');
    }
    // xử lý quên mật khẩu
    public function forgot(Request $request)
    {
        // validate - kiểm tra dữ liệu đầu vào
        $request->validate(
            ['email' => 'required|email'],
            [
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
            ]
        );

        // Kiểm tra email tồn tại
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->route('ad.forgot')
                ->with('message', 'Email không tồn tại')
                ->withInput();
        }

        // Tạo mật khẩu mới
        $passrandom = Str::random(10);
        // Mã hóa mật khẩu
        $passencrypted = Hash::make($passrandom);
        // Lưu vào DB
        $user->update([
            'password' => $passencrypted
        ]);
        // Nội dung email
        $html = "<h2>Mật khẩu mới của bạn là: $passrandom</h2>
            <p>Vui lòng đổi mật khẩu sau khi đăng nhập </p>";
        // Gửi email
        Mail::html($html, function ($message) use ($request) {
        $message->to($request->email)
                ->subject('Đặt lại mật khẩu');
        });
        // điều hướng về rang forgot kèm thông báo
        return redirect()->route('ad.forgot')
            ->with('message', 'Đã Gửi mật khẩu mới. Bạn vui lòng kiểm tra email của bạn');
    }


    // forgotLink,showReset,resetPassord=> gửi link reset (reset bằng token link)
    public function forgotLink(Request $request)
    {
        $request->validate(
            ['email' => 'required|email'],
            [
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
            ]
        );

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->route('ad.forgot')
                ->with('message', 'Email không tồn tại')
                ->withInput();
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        $link = url('admin/reset-password?email=' . urlencode($request->email) . '&token=' . urlencode($token));

        $html = "<h2>Yêu cầu đặt lại mật khẩu</h2>
                <p>Bấm vào link bên dưới để đặt lại mật khẩu:</p>
                <p><a href='$link'>$link</a></p>";

        Mail::html($html, function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Đặt lại mật khẩu bằng link');
        });

        return redirect()->route('ad.forgot')
            ->with('message', 'Đã gửi link đặt lại mật khẩu. Vui lòng kiểm tra email');
    }
    public function showReset(Request $request)
    {
        $email = $request->email;
        $token = $request->token;

        $reset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$reset) {
            return redirect()->route('ad.forgot')->with('message', 'Link không hợp lệ');
        }

        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return redirect()->route('ad.forgot')->with('message', 'Link đã hết hạn');
        }

        return view('admin.reset', compact('email', 'token'));
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ], [
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->with('message', 'Token không hợp lệ');
        }

        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return back()->with('message', 'Token đã hết hạn');
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('ad.login')->with('message', 'Đổi mật khẩu thành công');
    }
    }
