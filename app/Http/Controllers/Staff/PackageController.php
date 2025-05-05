<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageImage;
use App\Models\Type;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    public function index()
    {
        $package = Package::with('packageImages')->orderBy('created_at', 'desc')->get();
        $type = Type::orderBy('created_at', 'desc')->get();
        $car = Car::orderBy('created_at', 'desc')->get();

        return view('staff.package.data-package', compact('package', 'type', 'car'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'descriptions' => 'nullable|string',
            // 'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        return DB::transaction(function () use ($request) {
            $package = Package::create([
                'name' => $request->name,
                'descriptions' => $request->descriptions,
                'price' => $request->price,
                'status' => $request->status,
                'type_id' => $request->type,
                'car_id' => $request->car,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = time() . rand(1, 100) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('img/package'), $filename);

                    PackageImage::create([
                        'package_id' => $package->id,
                        'image' => $filename,
                    ]);

                    Log::info("Image uploaded: $filename for package ID: $package->id");
                }
            }

            return response()->json([
                'package' => $package->load('packageImages'),
            ]);
        });
    }

    public function show($id)
    {
        $package = Package::with('packageImages')->findOrFail($id);
        return response()->json($package);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        return DB::transaction(function () use ($request, $id) {
            // Ambil package berdasarkan ID
            $package = Package::findOrFail($id);

            // Update data package tanpa mengubah gambar
            $package->update([
                'name' => $request->name,
                'descriptions' => $request->descriptions,
                'price' => $request->price,
                'status' => $request->status,
                'type_id' => $request->type,
                'car_id' => $request->car,
            ]);

            // Jika ada gambar baru yang diunggah
            if ($request->hasFile('images')) {
                foreach ($package->packageImages as $packageImage) {
                    $imagePath = public_path('img/package/' . $packageImage->image);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                    $packageImage->delete();
                }

                foreach ($request->file('images') as $image) {
                    $filename = time() . rand(1, 100) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('img/package'), $filename);

                    PackageImage::create([
                        'package_id' => $package->id,
                        'image' => $filename,
                    ]);

                    Log::info("Image updated: $filename for package ID: $package->id");
                }
            }

            return response()->json([
                'package' => $package->load('packageImages'),
            ]);
        });
    }

    public function deleteImage($id)
    {
        $image = PackageImage::find($id);
        
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Image not found']);
        }

        // Hapus file gambar dari folder storage
        $imagePath = public_path('img/package/' . $image->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Hapus data gambar dari database
        $image->delete();

        return response()->json(['success' => true]);
    }

    // public function updateStatusPackage($id)
    // {
    //     $package = Package::findOrFail($id);
    //     $package->update([
    //         'status' => 'Available'
    //     ]);
    //     return response()->json($package);
    // }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $package = Package::findOrFail($id);

            foreach ($package->packageImages as $packageImage) {
                $imagePath = public_path('img/package/' . $packageImage->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $packageImage->delete();
            }

            $package->delete();

            return response()->json(['success' => 'Car deleted successfully']);
        });
    }
}
