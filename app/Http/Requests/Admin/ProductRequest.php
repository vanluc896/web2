<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
  // Lấy id từ route (update thì có, insert thì null)
  //trường hợp insert  -không có id =>$id=null
  //trường hợp update  -có id
        $id = $this->route('id');
        return [
            'proname' => 'required|max:255|unique:products,proname,' . $id,
            'slug' => 'required|max:255|regex:/^[a-zA-Z0-9-]+$/|unique:products,slug,' . $id,
            'price' => 'required|numeric|min:0|max:50000000',
            'cateid' => 'required|integer|exists:categories,cateid',
            'brandid' => 'nullable|integer|exists:brands,id',
 
            'thumbnail'=>'nullable|image|mimes:jpg,jpeg,png|extensions:jpg,jpeg,png|max:200',
            // 'image'=>'nullable|image|mimes:jpg,jpeg,png|extensions:jpg,jpeg,png|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã tồn tại',

            // 'proname.min' => ':attribute phải có ít nhất :min ký tự',
            'proname.max' => ':attribute tối đa :max ký tự',
            // 'slug.min' => ':attribute phải có ít nhất :min ký tự',
            'slug.max' => ':attribute tối đa :max ký tự',
            'slug.regex' => ':attribute chỉ chứa chữ, số và dấu gạch ngang (-)',
            'price.numeric' => ':attribute phải là số',
            'price.min' => ':attribute phải có ít nhất:min',
            'price.max' => ':attribute tối da:max',
            'cateid.exists' => ':attribute không tồn tại',
            'brandid.exists' => ':attribute không tồn tại',

            'thumbnail.image' => 'Ảnh đại diện phải là file ảnh',
            'thumbnail.mimes' => 'Ảnh đại diện phải có định dạng jpg, jpeg, png',
            'thumbnail.extensions'=>'Chỉ chấp nhận jpg,jpeg,png', 
            'thumbnail.max' => 'Ảnh đại diện tối đa 200kb',

            // 'image.image' => ':attribute phải là file ảnh',
            // 'image.mimes' => ':attribute phải có định dạng jpg, jpeg, png',
            // 'image.extensions'=>'Chỉ chấp nhận jpg,jpeg,png', 
            // 'image.max' => ':attribute tối đa 100kb',
        ];
    }
        public function attributes(): array
    {
        return [
            'proname' => 'Tên sản phẩm',
            'slug' => 'Slug',
            'price' => 'Giá',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            // 'thumbnail'=>'Ảnh đại diện',
            'images' => 'Hình ảnh',
        ];
    }


}
