<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit ?? 5;

        $posts = Post::with('user:id,fullname,username')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->orderBy('title')
            ->paginate($limit)
            ->withQueryString();

        return view('admin.posts.index', compact('posts', 'keyword', 'limit'));
    }

    public function create()
    {
        $users = User::select('id', 'fullname', 'username')
            ->orderBy('fullname')
            ->get();

        return view('admin.posts.create', compact('users'));
    }

    public function store(PostRequest $request)
    {
        try {
            $filename = 'default.png';

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = uniqid() . '_' . Str::slug($request->title) . '.' . $file->extension();
                $file->storeAs('posts', $filename, 'public');
            }

            Post::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'userid' => $request->userid,
                'image' => $filename,
                'content' => $request->input('content'),
                'status' => $request->status,
            ]);

            return redirect()
                ->route('ad.posts.index')
                ->with('message', 'Thêm bài viết thành công');
        } catch (QueryException $e) {
            return back()
                ->with('message', 'Lỗi DB: thực hiện thất bại')
                ->withInput();
        }
    }

    public function edit($id)
    {
        $model = Post::findOrFail($id);

        $users = User::select('id', 'fullname', 'username')
            ->orderBy('fullname')
            ->get();

        return view('admin.posts.edit', compact('model', 'users'));
    }

    public function update(PostRequest $request, $id)
    {
        try {
            $model = Post::findOrFail($id);
            $filename = $model->image ?: 'default.png';

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = uniqid() . '_' . Str::slug($request->title) . '.' . $file->extension();
                $file->storeAs('posts', $filename, 'public');

                if ($model->image && $model->image != 'default.png') {
                    Storage::disk('public')->delete('posts/' . $model->image);
                }
            }

            $model->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'userid' => $request->userid,
                'image' => $filename,
                'content' => $request->input('content'),
                'status' => $request->status,
            ]);

            return redirect()
                ->route('ad.posts.index')
                ->with('message', 'Cập nhật bài viết thành công');
        } catch (QueryException $e) {
            return back()
                ->with('message', 'Lỗi DB: thực hiện thất bại')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $model = Post::findOrFail($id);

        if ($model->image && $model->image != 'default.png') {
            Storage::disk('public')->delete('posts/' . $model->image);
        }

        $model->delete();

        return redirect()
            ->route('ad.posts.index')
            ->with('message', 'Xóa bài viết thành công');
    }
}
