<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'title' => 'required|min:5|max:255',
            'slug' => 'required|min:5|max:255|regex:/^[a-zA-Z0-9-]+$/|unique:posts,slug,' . $id,
            'content' => 'required|min:10',
            'userid' => 'required|exists:users,id',
            'image' => $id ? 'nullable|image|mimes:jpg,jpeg,png|max:2048'
                           : 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:0,1'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống',
            'title.min' => ':attribute phải có ít nhất :min ký tự',
            'title.max' => ':attribute tối đa :max ký tự',
            'slug.min' => ':attribute phải có ít nhất :min ký tự',
            'slug.max' => ':attribute tối đa :max ký tự',
            'slug.unique' => 'Slug đã tồn tại',
            'slug.regex' => 'Slug chỉ chứa chữ, số và dấu -',
            'content.min' => ':attribute phải có ít nhất :min ký tự',
            'image.image' => 'File phải là hình ảnh',
            'image.mimes' => 'Chỉ chấp nhận jpg, jpeg, png',
            'userid.exists' => 'User không tồn tại',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề',
            'slug' => 'Slug',
            'content' => 'Nội dung',
            'userid' => 'Người đăng',
            'image' => 'Hình ảnh',
            'status' => 'Trạng thái'
        ];
    }
}
