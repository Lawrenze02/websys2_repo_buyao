<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{

    public function create()
    {
        $photos = Photo::latest()->get();
        return view('upload', compact('photos'));
    }

    public function storeSingle(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $image = $request->file('image');
        $name = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $name);

        Photo::create(['image' => $name]);

        return back()->with('success', 'Single image uploaded successfully!');
    }

    public function storeMultiple2(Request $request)
    {
        $request->validate([
            'image.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        foreach ($request->file('images') as $image) {
            $name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $name);
            Photo::create(['image' => $name]);
        }
        return back()->with('success', 'Multiple image uploaded successfully!');
    }

    public function destroyImage(Photo $photo)
    {
        $path = public_path('images/' . $photo->image);
        if (file_exists($path)) {
            unlink($path);
        }

        $photo->delete();

        return back()->with('success', 'Image is deleted successfully!');
    }
}
