<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filters = $this->filters($request);

        $products = $this->applyFilters(Product::where('status', 1), $filters)
            ->paginate($filters['limit'])
            ->withQueryString();

        return view('client.product.index', [
            'products' => $products,
            'title' => 'Tất cả sản phẩm',
        ] + $filters);
    }

    public function show($slug)
    {
        $product = Product::with([
            'category:cateid,catename,slug',
            'brand:id,brandname,slug',
        ])
            ->select('id', 'proname', 'price', 'sale_price', 'thumbnail', 'slug', 'description', 'cateid', 'brandid')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('client.product.show', compact('product'));
    }

    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $filters = $this->filters($request);

        $products = $this->applyFilters(
            Product::where('cateid', $category->cateid)->where('status', 1),
            $filters
        )
            ->paginate($filters['limit'])
            ->withQueryString();

        return view('client.product.index', [
            'products' => $products,
            'title' => 'Danh mục: ' . $category->catename,
        ] + $filters);
    }

    public function brand(Request $request, $slug)
    {
        $brand = Brand::where('slug', $slug)->firstOrFail();
        $filters = $this->filters($request);

        $products = $this->applyFilters(
            Product::where('brandid', $brand->id)->where('status', 1),
            $filters
        )
            ->paginate($filters['limit'])
            ->withQueryString();

        return view('client.product.index', [
            'products' => $products,
            'title' => 'Thương hiệu: ' . $brand->brandname,
        ] + $filters);
    }

    public function search(Request $request)
    {
        $filters = $this->filters($request);

        $products = $this->applyFilters(Product::where('status', 1), $filters)
            ->paginate($filters['limit'])
            ->withQueryString();

        return view('client.product.index', [
            'products' => $products,
            'title' => $filters['keyword']
                ? 'Kết quả tìm kiếm: ' . $filters['keyword']
                : 'Tìm kiếm sản phẩm',
        ] + $filters);
    }

    private function filters(Request $request): array
    {
        return [
            'keyword' => trim($request->keyword ?? ''),
            'min_price' => $request->min_price ?? '',
            'max_price' => $request->max_price ?? '',
            'sort' => $request->sort ?? '',
            'limit' => $request->limit ?? 8,
        ];
    }

    private function applyFilters($query, array $filters)
    {
        return $query
            ->when($filters['keyword'], function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->where('proname', 'like', '%' . $filters['keyword'] . '%')
                        ->orWhere('description', 'like', '%' . $filters['keyword'] . '%');
                });
            })
            ->when($filters['min_price'] !== '', function ($query) use ($filters) {
                $query->where('price', '>=', $filters['min_price']);
            })
            ->when($filters['max_price'] !== '', function ($query) use ($filters) {
                $query->where('price', '<=', $filters['max_price']);
            })
            ->when($filters['sort'] == 'name_asc', function ($query) {
                $query->orderBy('proname', 'asc');
            })
            ->when($filters['sort'] == 'name_desc', function ($query) {
                $query->orderBy('proname', 'desc');
            })
            ->when($filters['sort'] == 'price_asc', function ($query) {
                $query->orderBy('price', 'asc');
            })
            ->when($filters['sort'] == 'price_desc', function ($query) {
                $query->orderBy('price', 'desc');
            })
            ->when($filters['sort'] == '', function ($query) {
                $query->latest();
            });
    }
}
