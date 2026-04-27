<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    
// {
//     $keyword = $request->keyword ?? '';
//     $limit = $request->limit ?? 5;

    //     $sort = $request->sort ?? '';
//     $min_price = $request->min_price ?? '';
//     $max_price = $request->max_price ?? '';

    //     $query = DB::table('products as p')
//         ->join('categories as c', 'p.cateid', '=', 'c.cateid')
//         ->leftJoin('brands as b', 'p.brandid', '=', 'b.id')
//         ->select(
//             'p.id',
//             'p.proname',
//             'p.price',
//             'c.catename as categoryname',
//             'b.brandname as brandname'
//         );

    //     // tìm theo tên
//     if($keyword){
//         $query->where('p.proname','like',"%$keyword%");
//     }

    //     // tìm theo khoảng giá
//     if($min_price){
//         $query->where('p.price','>=',$min_price);
//     }

    //     if($max_price){
//         $query->where('p.price','<=',$max_price);
//     }

    //     // sắp xếp
//     if($sort == 'name_asc'){
//         $query->orderBy('p.proname','asc');
//     }
//     elseif($sort == 'name_desc'){
//         $query->orderBy('p.proname','desc');
//     }
//     elseif($sort == 'price_asc'){
//         $query->orderBy('p.price','asc');
//     }
//     elseif($sort == 'price_desc'){
//         $query->orderBy('p.price','desc');
//     }

    //     $products = $query->paginate($limit)->appends($request->all());

    //     return view('admin.product.index', compact( 'products','keyword','limit','sort','min_price','max_price'));
// }

    public function index2(Request $request)
    {
        // lấy từ khóa tìm kiếm
        $keyword = $request->keyword;

        // lấy limit = số lượng bản ghi hiển thị trên một trang
        // mặc định 5 bản ghi
        $limit = $request->limit ?? 5;


        // thêm điều kiện tìm kiếm lab2
        $min_price = $request->min_price ?? '';
        $max_price = $request->max_price ?? '';
        $sort = $request->sort ?? '';


        // thực hiện truy vấn dữ liệu
        $products = Product::with(['category:cateid,catename', 'brand:id,brandname'])
            // nếu có keyword thì thêm điều kiện tìm kiếm
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('proname', 'like', '%' . $keyword . '%');
            })

            // nếu có giá nhỏ nhất
            ->when($min_price !== '', function ($query) use ($min_price) {
                $query->where('price', '>=', $min_price);
            })
            // nếu có giá lớn nhất
            ->when($max_price !== '', function ($query) use ($max_price) {
                $query->where('price', '<=', $max_price);
            })
            // sắp xếp
            ->when($sort == 'name_asc', function ($query) {
                $query->orderBy('proname', 'asc');
            })
            ->when($sort == 'name_desc', function ($query) {
                $query->orderBy('proname', 'desc');
            })
            ->when($sort == 'price_asc', function ($query) {
                $query->orderBy('price', 'asc');
            })
            ->when($sort == 'price_desc', function ($query) {
                $query->orderBy('price', 'desc');
            })


            // nếu không chọn sort thì mặc định sắp xếp theo tên
            ->orderBy('proname')
            // phân trang
            ->paginate($limit)
            // giữ tham số trên URL của request hiện tại khi chuyển trang
            ->withQueryString();
        $trashCount = Product::onlyTrashed()->count();

        // gửi dữ liệu products + keyword qua view admin.product.index2
        // gửi thêm giá trị của limit
        return view('admin.product.index2', compact('products', 'keyword', 'limit', 'min_price', 'max_price', 'sort', 'trashCount'));
    }

    public function create()
    {
        $categories = Category::select('cateid', 'catename')
            ->orderBy('catename')
            ->get();

        $brands = Brand::select('id', 'brandname')
            ->orderBy('brandname')
            ->get();

        // gửi dữ liệu categories và brands qua view
        return view('admin.product.create', compact('categories', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        try {
            // ==== Xử lý upload file thumbnail
            $filename = 'default.png';
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = uniqid() . '_' . Str::slug($request->proname) . '.' . $file->getClientOriginalExtension();
                // lưu file vào storage/app/public/products
                $file->storeAs('products', $filename, 'public');
            }

            // đưa dữ liệu xuống bảng products
            $product = Product::create([
                'proname' => $request->proname,
                'slug' => $request->slug,
                'price' => $request->price,
                'brandid' => $request->brandid ?? null,
                'cateid' => $request->cateid,
                'description' => $request->des,
                //===
                'thumbnail' => $filename,
                'status' => $request->has('status') ? 1 : 0
            ]);

            // =====================
            // Xử lý upload file liên quan
            $dataImages = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $name = $product->id . '_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $img->storeAs('products', $name, 'public');
                    // lưu vào mảng $dataImages
                    $dataImages[] = [
                        'image' => $name,
                        'product_id' => $product->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            // lưu dữ liệu xuống bảng product_images
            ProductImage::insert($dataImages);
            //==
            // điều hướng về trang index
            return redirect()->route('ad.product.index2');

        } catch (QueryException $e) {
            return back()
                ->with('message', 'Lỗi DB: thực hiện thất bại')
                ->withInput();
        }
    }

    public function edit($id)
    {
        // tìm dữ liệu theo khóa chính id
        $model = Product::find($id);

        $categories = Category::select('cateid', 'catename')
            ->orderBy('catename')
            ->get();

        $brands = Brand::select('id', 'brandname')
            ->orderBy('brandname')
            ->get();

        // gửi dữ liệu model, categories, brands qua view
        return view('admin.product.edit', compact('model', 'categories', 'brands'));
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            // TH1: tìm dữ liệu theo khóa chính
            $model = Product::find($id);
            //giữ lại ảnh cũ
            $filename = $model->thumbnail;
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                //tạo tên file tránh trùng
                //có sd tvien str tạo slug, tvien uniqid tạo id
                $filename = uniqid() . '_' . Str::slug($request->proname) . '.' . $file->extension();
                //lưu file vào storage/app/public/products
                $file->storeAs('products', $filename, 'public');
                // xóa ảnh cũ (trừ default)
                if ($model->thumbnail && $model->thumbnail != 'default.png') {
                    Storage::disk('public')->delete('products/' . $model->thumbnail);
                }
                // $file = $request->file('thumbnail');
                // $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

            }
            // TH2: tìm dữ liệu
            // $model = Product::where('cateid', $id);

            // TH1: nếu Tên input trùng với tên column trong bảng
            // $model->update($request->all());

            // TH2: nếu không trùng tên
            $model->update([
                'proname' => $request->proname,
                'slug' => $request->slug,
                'price' => $request->price,
                'cateid' => $request->cateid,
                'brandid' => $request->brandid,
                'description' => $request->des,

                'thumbnail' => $filename,
                'status' => $request->has('status') ? 1 : 0
            ]);
            // ===== XÓA ẢNH LIÊN QUAN ĐÃ CHỌN =====
            if ($request->has('delete_images')) {

                $images = ProductImage::whereIn('id', $request->delete_images)->get();

                foreach ($images as $img) {
                    if ($img->image) {
                        Storage::disk('public')->delete('products/' . $img->image);
                    }
                }

                ProductImage::whereIn('id', $request->delete_images)->delete();
            }
            if ($request->hasFile('images')) {
                $dataImages = [];
                foreach ($request->file('images') as $img) {
                    $name = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $img->storeAs('products', $name, 'public');
                    $dataImages[] = [
                        'product_id' => $id,
                        'image' => $name,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                ProductImage::insert($dataImages);
            }

            return redirect()->route('ad.product.index2');
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




    // public function destroy($id)
// {

    //     Product::destroy($id);

    //     return redirect()->route('ad.product.index2');
// }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()
            ->route('ad.product.index2')
            ->with('message', 'Đã chuyển vào thùng rác');
    }

    public function trash(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit ?? 5;
        $min_price = $request->min_price ?? '';
        $max_price = $request->max_price ?? '';
        $sort = $request->sort ?? '';

        $products = Product::onlyTrashed()
            ->with(['category:cateid,catename', 'brand:id,brandname'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('proname', 'like', '%' . $keyword . '%');
            })
            ->when($min_price !== '', function ($query) use ($min_price) {
                $query->where('price', '>=', $min_price);
            })
            ->when($max_price !== '', function ($query) use ($max_price) {
                $query->where('price', '<=', $max_price);
            })
            ->when($sort == 'name_asc', function ($query) {
                $query->orderBy('proname', 'asc');
            })
            ->when($sort == 'name_desc', function ($query) {
                $query->orderBy('proname', 'desc');
            })
            ->when($sort == 'price_asc', function ($query) {
                $query->orderBy('price', 'asc');
            })
            ->when($sort == 'price_desc', function ($query) {
                $query->orderBy('price', 'desc');
            })
            ->orderByDesc('deleted_at')
            ->paginate($limit)
            ->withQueryString();

        $trashCount = Product::onlyTrashed()->count();

        return view('admin.product.trash', compact(
            'products',
            'keyword',
            'limit',
            'min_price',
            'max_price',
            'sort',
            'trashCount'
        ));
    }

    public function restore($id)
    {
        Product::onlyTrashed()
            ->where('id', $id)
            ->restore();

        return redirect()
            ->route('ad.product.trash')
            ->with('message', 'Khôi phục thành công');
    }

    public function forceDelete($id)
    {
        $model = Product::onlyTrashed()
            ->with('images')
            ->findOrFail($id);

        if ($model->thumbnail && $model->thumbnail != 'default.png') {
            Storage::disk('public')->delete('products/' . $model->thumbnail);
        }

        foreach ($model->images as $img) {
            if ($img->image) {
                Storage::disk('public')->delete('products/' . $img->image);
            }
            $img->delete();
        }

        $model->forceDelete();

        return redirect()
            ->route('ad.product.trash')
            ->with('message', 'Đã xóa vĩnh viễn');
    }
}