<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DefaultCategory;
use Illuminate\Http\Request;

class DefaultCategoryController extends Controller
{
    public function index()
    {
        $cats = DefaultCategory::orderBy('type')->orderBy('name')->paginate(25);
        return view('admin.default_categories.index', compact('cats'));
    }

    public function create()
    {
        return view('admin.default_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:191', 'type' => 'required|in:pemasukan,pengeluaran']);
        $cat = DefaultCategory::create($request->only('name','type'));

        if (class_exists(\App\Helpers\ActivityLogger::class)) {
            \App\Helpers\ActivityLogger::log(auth()->id() ?? null, 'default_category.create', $cat, 'Admin created default category');
        }

        return redirect()->route('admin.default_categories.index')->with('success','Kategori default dibuat.');
    }

    public function edit(DefaultCategory $defaultCategory)
    {
        return view('admin.default_categories.edit', ['cat' => $defaultCategory]);
    }

    public function update(Request $request, DefaultCategory $defaultCategory)
    {
        $request->validate(['name' => 'required|string|max:191','type' => 'required|in:pemasukan,pengeluaran']);
        $defaultCategory->update($request->only('name','type'));

        if (class_exists(\App\Helpers\ActivityLogger::class)) {
            \App\Helpers\ActivityLogger::log(auth()->id() ?? null, 'default_category.update', $defaultCategory, 'Admin updated default category');
        }

        return redirect()->route('admin.default_categories.index')->with('success','Kategori default diperbarui.');
    }

    public function destroy(DefaultCategory $defaultCategory)
    {
        if (class_exists(\App\Helpers\ActivityLogger::class)) {
            \App\Helpers\ActivityLogger::log(auth()->id() ?? null, 'default_category.delete', $defaultCategory, 'Admin deleted default category');
        }

        $defaultCategory->delete();
        return back()->with('success','Kategori default dihapus.');
    }
}