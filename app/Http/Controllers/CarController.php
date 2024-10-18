<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return Inertia::render('Cars/Index', [
            'cars' => $cars
        ]);
    }

    public function create()
    {
        return Inertia::render('Cars/Create', [
            'carsStoreRoute' => route('cars.store'),
            'carsIndexRoute' => route('cars.index'),
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Received request data:', $request->all());

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            ]);

            $car = Car::create($validated);
            return redirect()->route('cars.index')->with('success', '차량이 성공적으로 등록되었습니다.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => '차량 등록 중 오류가 발생했습니다: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Car $car)
    {
        return Inertia::render('Cars/Show', [
            'car' => $car->only(['id', 'name', 'model', 'year', 'is_reserved', 'reserved_by'])
        ]);
    }

    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
        ]);

        $car->update($request->all());
        return redirect()->route('cars.index')->with('message', 'Car updated successfully');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return response()->json(['message' => '차량이 삭제었습니다.']);
    }

    public function createReservation($id)
    {
        $car = Car::findOrFail($id);
        return Inertia::render('Reservations/Create', [
            'car' => $car
        ]);
    }

}
