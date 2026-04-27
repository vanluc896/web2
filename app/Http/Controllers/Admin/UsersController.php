<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('staff_code')->paginate(5);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserRequest $request)
    {
        try {
            User::create([
                'staff_code' => $request->staff_code,
                'username' => $request->username,
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return redirect()
                ->route('ad.users.index')
                ->with('message', 'Thêm người dùng thành công');
        } catch (QueryException $e) {
            return back()
                ->with('message', 'Lỗi DB: thực hiện thất bại')
                ->withInput();
        }
    }

    public function edit($id)
    {
        $model = User::findOrFail($id);

        return view('admin.users.edit', compact('model'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $model = User::findOrFail($id);

            $data = [
                'staff_code' => $request->staff_code,
                'username' => $request->username,
                'fullname' => $request->fullname,
                'email' => $request->email,
                'role' => $request->role,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $model->update($data);

            return redirect()
                ->route('ad.users.index')
                ->with('message', 'Cập nhật người dùng thành công');
        } catch (QueryException $e) {
            return back()
                ->with('message', 'Lỗi DB: thực hiện thất bại')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        if (auth()->id() == $id) {
            return redirect()
                ->route('ad.users.index')
                ->with('message', 'Bạn không thể tự xóa tài khoản đang đăng nhập');
        }

        User::destroy($id);

        return redirect()
            ->route('ad.users.index')
            ->with('message', 'Xóa người dùng thành công');
    }
}
