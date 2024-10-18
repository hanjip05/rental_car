<?php
namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Car;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function checkAvailability(Request $request)
    {
        $validatedData = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $conflict = Reservation::where('car_id', $validatedData['car_id'])
            ->where(function ($query) use ($validatedData) {
                $query->where('start_date', '<=', $validatedData['end_date'])
                      ->where('end_date', '>=', $validatedData['start_date']);
            })->exists();

        return response()->json(['available' => !$conflict]);
    }

    public function create(Car $car)
    {
        return Inertia::render('Reservations/Create', [
            'car' => $car
        ]);
    }

    public function store(Request $request, $carId)
    {
        $car = Car::find($carId);

        if (!$car) {
            return redirect()->back()->withErrors(['error' => '차량을 찾을 수 없습니다.']);
        }

        $car->is_reserved = true;
        $car->reserved_by = auth()->id;
        $car->save();

        return redirect()->route('cars.show', $car->id);
    }

    public function getReservedDates(Car $car)
    {
        $reservations = Reservation::where('car_id', $car->id)
            ->where('end_date', '>=', now()) // 오늘 이후의 약만 가져옴
            ->get(['start_date', 'end_date'])
            ->toArray();

        return response()->json($reservations);
    }

    public function reserve(Request $request, $carId)
    {
        $car = Car::findOrFail($carId);

        // 예약 중복 확인
        $existingReservation = Reservation::where('car_id', $carId)
            ->where('start_date', '<=', $request->end_date)
            ->where('end_date', '>=', $request->start_date)
            ->first();

        if ($existingReservation) {
            return response()->json(['success' => false]);
        }

        // 예약 생성
        Reservation::create([
            'car_id' => $carId,
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json(['success' => true]);
    }

    public function checkStatus($carId)
    {
        $isReserved = Reservation::where('car_id', $carId)->exists();
        return response()->json(['is_reserved' => $isReserved]);
    }

    public function cancel($carId)
    {
        $car = Car::find($carId);

        if (!$car) {
            return redirect()->back()->withErrors(['error' => '차량을 찾을 수 없습니다.']);
        }

        $car->is_reserved = false;
        $car->save();

        return redirect()->route('cars.show', $car->id)->with('success', '예약이 취소되었습니다.');
    }

    // 예약 목록 페이지
    public function index()
    {
        // 예약 목록을 가져오는 로직
        // 예: $reservations = Reservation::all();

        return Inertia::render('Reservations/Index', [
            // 'reservations' => $reservations,
        ]);
    }
}
