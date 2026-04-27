<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\BrandRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class BrandController extends Controller
{


    public function index()
    {
        // $brands = DB::table('brands')->orderBy('brandname')->get();
        // $brands = DB::table('categories')->orderBy('catename')->get();


        //th1: lấy tất cả dl
        // $brands=Brand::all();

        //th2:có sắp xếp
        //$brands = Brand::orderBy('catename')->get()
        //th3: Có phân trang 
        $trashCount = Brand::onlyTrashed()->count();
        $brands = Brand::orderBy('brandname')->paginate(5);
        return view('admin.brands.index', compact('brands', 'trashCount'));
    }
    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request)
    {
        // TH1: nếu Tên input trùng với tên column trong bảng
        // Brand::create($request->all());

        // TH2: nếu không trùng tên
        $filename = 'default.png';
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = uniqid() . '_' . Str::slug($request->brandname) . '.' . $file->extension();
            $file->storeAs('brands', $filename, 'public');
        }
        try {
            Brand::create([
                'brandname' => $request->brandname,
                'slug' => $request->slug,
                'description' => $request->des,
                'thumbnail' => $filename,
                'status' => $request->has('status') ? 1 : 0,
            ]);

            return redirect()->route('ad.brands.index');
        } catch (QueryException $e) {
            //Trường hợp thực hiện lưu thất bại
            //+quay về trang trước
            //+kèm session flash 'message'
            //+giữ lại dữ liệu người dùng đã nhập
            return back()
                ->with('message', 'Lỗi DB: thực hiện thất bại')
                ->withInput();
        }

    }

    public function edit($id)
    {
        $model = Brand::find($id);
        return view('admin.brands.edit', compact('model'));
    }
    public function update(BrandRequest $request, $id)
    {

        $model = Brand::find($id);
        $filename = $model->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = uniqid() . '_' . Str::slug($request->brandname) . '.' . $file->extension();
            $file->storeAs('brands', $filename, 'public');

            if ($model->thumbnail && $model->thumbnail != 'default.png') {
                Storage::disk('public')->delete('brands/' . $model->thumbnail);
            }
        }
        // TH1: tìm dữ liệu theo khóa chính
        try {

            // TH2: tìm dữ liệu
            // $model = Brand::where('id', $id);

            // TH1: nếu Tên input trùng với tên column trong bảng
            // $model->update($request->all());

            // TH2: nếu không trùng tên
            $model->update([
                'brandname' => $request->brandname,
                'slug' => $request->slug,
                'description' => $request->des,
                'thumbnail' => $filename,
                'status' => $request->has('status') ? 1 : 0,
            ]);

            return redirect()->route('ad.brands.index');
        } catch (QueryException $e) {
            // truong hop thuc hien 
            /**
             * quay ve trang truoc
             * kem session flash 'message'
             * giu lai du lieu nguoi dung da nhap
             */
            return back()
                ->with('message', 'Lỗi DB: thực hiện thất bại')
                ->withInput();
        }

    }

    //     public function destroy($id)
    // {
    //     // TH1: xóa theo khóa chính
    //     Brand::destroy($id);

    //     // TH2: Tìm rồi xóa
    //     // Brand::find($id)->delete();

    //     // TH3: xóa bằng where
    //     // Brand::where('cateid', $id)->delete();

    //     return redirect()->route('ad.brands.index');
    // }

    public function destroy($id)
    {
        Brand::findOrFail($id)->delete();

        return redirect()
            ->route('ad.brands.index')
            ->with('message', 'Đã chuyển vào thùng rác');
    }

    public function trash()
    {
        $brands = Brand::onlyTrashed()
            ->orderByDesc('deleted_at')
            ->paginate(5);
            $trashCount = Brand::onlyTrashed()->count();
        return view('admin.brands.trash', compact('brands', 'trashCount'));
    }

    public function restore($id)
    {
        Brand::onlyTrashed()
            ->where('id', $id)
            ->restore();

        return redirect()
            ->route('ad.brands.trash')
            ->with('message', 'Khôi phục thành công');
    }

    public function forceDelete($id)
    {
        $model = Brand::onlyTrashed()->findOrFail($id);

        if ($model->thumbnail && $model->thumbnail != 'default.png') {
            Storage::disk('public')->delete('brands/' . $model->thumbnail);
        }

        $model->forceDelete();

        return redirect()
            ->route('ad.brands.trash')
            ->with('message', 'Đã xóa vĩnh viễn');
    }
}

