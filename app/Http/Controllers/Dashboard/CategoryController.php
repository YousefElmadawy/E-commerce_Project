<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use COM;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $request = request();

        $categories = Category::with('parent')
        /*leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])*/
            ->withCount('products')
            ->filter($request->query())
            ->orderBy('categories.name')
            ->paginate(4);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        return view('dashboard.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());
        //merge 
        $request->merge([
            'slug' => Str::slug($request->name)
        ]);

        $data = $request->except('image');


        $data['image'] = $this->uploadImage($request); //store path in image field

        //mass assignment
        Category::create($data);
        //PGR
        return redirect()->route('categories.index')->with('sucess', 'Category Created !!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $products=$category->products()->with('store')->latest()->get();
       return view('dashboard.categories.show', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        try {
            $category = Category::findOrFail($category->id);
        } catch (Exception $e) {

            return redirect()->route('categories.index')->with('info', 'invalid value !!');
        }

        //select * from category where id != $category->id  AND parent_id isNull OR parent_id != $category->id
        $parents = Category::where('id', '<>', $category->id)
            ->where(function ($query) use ($category) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $category->id);
            })->get();


        return view('dashboard.categories.edit', compact('parents', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $category = Category::findOrFail($id);
        $old_image = $category->image;

        $data = $request->except('image');

        // if ($request->hasFile('image')) {
        //     $file = $request->file('image'); //return object form uploded file 
        //     $path = $file->store('uploads', [
        //         'disk' => 'public'
        //     ]);
        $path = $this->uploadImage($request);
        // }
        if ($path) {
            $data['image'] = $path;
        }

        $category->update($data);

        if ($old_image && $data['image']) {
            Storage::disk('public')->delete($old_image);
        }

        // $category->update([
        //     'name' => $request->name,
        //     'description' => $request->description,
        //     'image' => $request->image,
        //     'parent_id' => $request->parent_id
        // ]);

        return redirect()->route('categories.index')->with('Updated', 'Category Updated !!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        //delete data from DB  

        // Category::destroy($category->id);
        return redirect()->route('categories.index');
    }

    protected function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            return $path;
        }
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }
    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('categories.trash')->with('sucess', 'Category restored');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('categories.trash')->with('info', 'Category Deleted');
    }
}
