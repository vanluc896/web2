<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'staff_code' => 'required|min:3|max:20|alpha_dash|unique:users,staff_code,' . $id,
            'username' => 'required|min:3|max:50|alpha_dash|unique:users,username,' . $id,
            'fullname' => 'required|min:3|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => $id
                ? 'nullable|min:6|max:50|regex:/^[a-zA-Z0-9]+$/'
                : 'required|min:6|max:50|regex:/^[a-zA-Z0-9]+$/',
            'role' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống',
            'staff_code.min' => ':attribute phải có ít nhất :min ký tự',
            'staff_code.max' => ':attribute tối đa :max ký tự',
            'staff_code.alpha_dash' => ':attribute chỉ gồm chữ, số, dấu gạch ngang và gạch dưới',
            'staff_code.unique' => ':attribute đã tồn tại',
            'username.min' => ':attribute phải có ít nhất :min ký tự',
            'username.max' => ':attribute tối đa :max ký tự',
            'username.alpha_dash' => ':attribute chỉ gồm chữ, số, dấu gạch ngang và gạch dưới',
            'username.unique' => ':attribute đã tồn tại',
            'fullname.min' => ':attribute phải có ít nhất :min ký tự',
            'fullname.max' => ':attribute tối đa :max ký tự',
            'email.email' => ':attribute không đúng định dạng',
            'email.unique' => ':attribute đã tồn tại',
            'password.min' => ':attribute ít nhất :min ký tự',
            'password.max' => ':attribute tối đa :max ký tự',
            'password.regex' => ':attribute chỉ được chứa chữ và số',
            'role.in' => ':attribute không hợp lệ',
        ];
    }

    public function attributes(): array
    {
        return [
            'staff_code' => 'Mã nhân viên',
            'username' => 'Tên đăng nhập',
            'fullname' => 'Họ tên',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'role' => 'Quyền',
        ];
    }
}
