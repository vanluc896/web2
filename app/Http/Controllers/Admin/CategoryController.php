<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    public function index()
    {
        // $list = DB::table('categories')->orderBy('catename')->get();


        //th1: lấy tất cả dl
        // $list=Category::all();

        //th2:có sắp xếp
        //$list = Category::orderBy('catename')->get()
        //th3: Có phân trang 

        $trashCount = Category::onlyTrashed()->count();
        $list = Category::orderBy('catename')->paginate(5);

        return view('admin.category.index', compact('list', 'trashCount'));

    }
    public function create()
    {

        return view('admin.category.create');
    }
    public function store(Request $request)
    {

        // TH1: nếu Tên input trùng với tên column trong bảng
        // Category::create($request->all());
        $request->validate([
            'catename' => 'required|min:10|max:50|unique:categories,catename',
            'slug' => 'required|min:10|max:50|unique:categories,slug|regex:/^[a-zA-Z0-9-]+$/',
            //-----------//
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|extensions:jpg,jpeg,png|max:100'
        ], [
            'catename.required' => 'Tên loại sản phẩm không được để trống',
            'catename.min' => 'Tên phải có độ dài tối thiểu :min ký tự',
            'catename.max' => 'Tên phải có độ dài tối đa :max ký tự',
            'catename.unique' => 'Tên đã tồn tại',
            'slug.required' => 'Slug không được để trống',
            'slug.min' => 'Slug phải có độ dài tối thiểu :min ký tự',
            'slug.max' => 'Slug phải có độ dài tối đa :max ký tự',
            'slug.unique' => 'Slug đã tồn tại',
            'slug.regex' => 'Slug chỉ gồm chữ, số và dấu gạch ngang (-)',
            //---
            'thumbnail.image' => 'File phải là hình ảnh',
            'thumbnail.mimes' => 'Chỉ chấp nhận jpg,jpeg,png',
            'thumbnail.extensions' => 'Chỉ chấp nhận jpg,jpeg,png',
            'thumbnail.max' => 'Ảnh tối đa 100kb'
        ]);
        // TH2: nếu không trùng tên


        try {
            $filename = 'default.png';
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                //tạo tên file tránh trùng
                //có sd tvien str tạo slug, tvien uniqid tạo id
                $filename = uniqid() . '_' . Str::slug($request->catename) . '.' . $file->extension();
                //lưu file vào storage/app/public/categories
                $file->storeAs('categories', $filename, 'public');
            }
            Category::create([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'description' => $request->des,
                //--
                'thumbnail' => $filename,
                'status' => $request->has('status') ? 1 : 0
            ]);
            return redirect()->route('ad.cate.index');
        } catch (QueryException $e) {
            //Trường hợp thực hiện lưu thất bại
            //+quay về trang trước
            //+kèm session flash 'message'
            //+giữ lại dữ liệu người dùng đã nhập
            return back()
                ->with('message', 'Lỗi DB: Thực hiện thất bại')
                ->withInput();
        }


    }
    public function edit($id)
    {
        $model = Category::find($id);
        return view('admin.category.edit', compact('model'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'catename' => 'required|min:10|max:50|unique:categories,catename,' . $id . ',cateid',
            'slug' => 'required|min:10|max:50|regex:/^[a-zA-Z0-9-]+$/|unique:categories,slug,' . $id . ',cateid',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|extensions:jpg,jpeg,png|max:100'
        ], [
            'catename.required' => 'Tên loại sản phẩm không được để trống',
            'catename.min' => 'Tên phải có độ dài tối thiểu :min ký tự',
            'catename.max' => 'Tên phải có độ dài tối đa :max ký tự',
            'catename.unique' => 'Tên đã tồn tại',
            'slug.required' => 'Slug không được để trống',
            'slug.min' => 'Slug phải có độ dài tối thiểu :min ký tự',
            'slug.max' => 'Slug phải có độ dàu tối đa :max ký tự',
            'slug.unique' => 'Slug đã tồn tại',
            'slug.regex' => 'Slug chỉ gồm chữ, số và dấu gạch ngang (-)',
            //---
            'thumbnail.image' => 'File phải là hình ảnh',
            'thumbnail.mimes' => 'Chỉ chấp nhận jpg,jpeg,png',
            'thumbnail.extensions' => 'Chỉ chấp nhận jpg,jpeg,png',

            'thumbnail.max' => 'Ảnh tối đa 100kb'
        ]);

        try {
            // TH1: tìm dữ liệu theo khóa chính
            $model = Category::find($id);
            // xử lý update file
            //giữ lại ảnh cũ
            $filename = $model->thumbnail;
            //nếu có ảnh mới
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                //tạo tên file tránh trùng
                //có sd tvien str tạo slug, tvien uniqid tạo id
                $filename = uniqid() . '_' . Str::slug($request->catename) . '.' . $file->extension();
                //lưu file vào storage/app/public/categories
                $file->storeAs('categories', $filename, 'public');
                //Xóa ảnh cũ trừ default
                if ($model->thumbnail && $model->thumbnail != 'default.png') {
                    Storage::disk('public')->delete('categories/' . $model->thumbnail);
                }
            }
            // TH2: tìm dữ liệu
            // $model = Category::where('cateid', $id);

            // TH1: nếu Tên input trùng với tên column trong bảng
            // $model->update($request->all());

            // TH2: nếu không trùng tên
            $model->update([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'description' => $request->des,
                //--
                'thumbnail' => $filename,
                'status' => $request->has('status') ? 1 : 0

            ]);
            return redirect()->route('ad.cate.index');
        } catch (QueryException $e) {
            // truong hop thuc hien 
            /**
             * quay ve trang truoc
             * kem session flash 'message'
             * giu lai du lieu nguoi dung da nhap
             */
            return back()
                ->with('message', 'Lỗi DB: Thực hiện thất bại')
                ->withInput();
        }

    }

    // public function destroy($id)
    // {
    //     // TH1: xóa theo khóa chính
    //     Category::destroy($id);

    //     // TH2: Tìm rồi xóa
    //     // Category::find($id)->delete();

    //     // TH3: xóa bằng where
    //     // Category::where('cateid', $id)->delete();

    //     return redirect()->route('ad.cate.index');
    // }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return redirect()
            ->route('ad.cate.index')
            ->with('message', 'Đã chuyển vào thùng rác');
    }

    public function trash()
    {
        $list = Category::onlyTrashed()
            ->orderByDesc('deleted_at')
            ->paginate(5);
            $trashCount = Category::onlyTrashed()->count();
        return view('admin.category.trash', compact('list', 'trashCount'));
    }

    public function restore($id)
    {
        Category::onlyTrashed()
            ->where('cateid', $id)
            ->restore();

        return redirect()
            ->route('ad.cate.trash')
            ->with('message', 'Khôi phục thành công');
    }

    public function forceDelete($id)
    {
        $model = Category::onlyTrashed()->where('cateid', $id)->firstOrFail();

        if ($model->thumbnail && $model->thumbnail != 'default.png') {
            Storage::disk('public')->delete('categories/' . $model->thumbnail);
        }

        $model->forceDelete();

        return redirect()
            ->route('ad.cate.trash')
            ->with('message', 'Đã xóa vĩnh viễn');
    }
}
