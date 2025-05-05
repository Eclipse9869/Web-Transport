<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with('carImages')->orderBy('created_at', 'desc')->get();
        return view('staff.car.data-car', compact('cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'descriptions' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        return DB::transaction(function () use ($request) {
            $car = Car::create([
                'name' => $request->name,
                'descriptions' => $request->descriptions,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = time() . rand(1, 100) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('img/car'), $filename);

                    CarImage::create([
                        'car_id' => $car->id,
                        'image' => $filename,
                    ]);

                    Log::info("Image uploaded: $filename for car ID: $car->id");
                }
            }

            return response()->json([
                'car' => $car->load('carImages'),
            ]);
        });
    }

    public function show($id)
    {
        $car = Car::with('carImages')->findOrFail($id);
        return response()->json($car);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'descriptions' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        return DB::transaction(function () use ($request, $id) {
            $car = Car::findOrFail($id);
            $car->update([
                'name' => $request->name,
                'descriptions' => $request->descriptions,
            ]);

            // Hapus gambar lama jika ada gambar baru
            if ($request->hasFile('images')) {
                foreach ($car->carImages as $carImage) {
                    $imagePath = public_path('img/car/' . $carImage->image);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                    $carImage->delete();
                }
                foreach ($request->file('images') as $image) {
                    $filename = time() . rand(1, 100) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('img/car'), $filename);
                    CarImage::create([
                        'car_id' => $car->id,
                        'image' => $filename,
                    ]);
                    Log::info("Image updated: $filename for car ID: $car->id");
                }
            }
            return response()->json([
                'car' => $car->load('carImages'),
            ]);
        });
    }

    public function deleteImage($id)
    {
        $image = CarImage::find($id);
        
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Image not found']);
        }

        // Hapus file gambar dari folder storage
        $imagePath = public_path('img/car/' . $image->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Hapus data gambar dari database
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $car = Car::findOrFail($id);

            foreach ($car->carImages as $carImage) {
                $imagePath = public_path('img/car/' . $carImage->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $carImage->delete();
            }

            $car->delete();

            return response()->json(['success' => 'Car deleted successfully']);
        });
    }
}