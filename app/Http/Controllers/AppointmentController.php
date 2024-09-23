<?php

namespace App\Http\Controllers;

use App\Bookings\ServiceSlotAvailability;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __invoke(AppointmentRequest $request)
    {
        $employee = Employee::find($request->employee_id);
        $service = Service::find($request->service_id);

        $availability = (new ServiceSlotAvailability(collect([$employee]), $service))
            ->forPeriod(
                Carbon::parse($request->date)->startOfDay(),
                Carbon::parse($request->date)->endOfDay(),
            );

        if (!$availability->first()->containsSlot($request->time)) {
            return response()->json([
                'error' => 'That slot was taken while you were making your booking. Please try again.'
            ], 409);
        }

        $appointment = Appointment::create(
            $request->only('employee_id', 'service_id', 'codice_fiscale', 'name', 'email') + [
                'starts_at' => $date = Carbon::parse($request->date)->setTimeFromTimeString($request->time),
                'ends_at' => $date->copy()->addMinutes($service->duration),
            ]
        );

        return response()->json([
            'redirect' => route('confirmation', $appointment)
        ]);
    }

    public function calendar()
        {
            return view('dashboard.index');
        }
        public function getEvents()
        {
            $appointments = Appointment::all();
        
            $events = [];
        
            foreach ($appointments as $appointment) {
                // Skip cancelled appointments
                if ($appointment->cancelled_at) {
                    continue;
                }
        
                $events[] = [
                    'id'    => $appointment->id,
                    'title' => $appointment->name,
                    'start' => $appointment->starts_at->toIso8601String(),
                    'end'   => $appointment->ends_at->toIso8601String(),
                    'extendedProps' => [
                        'codice_fiscale' => $appointment->codice_fiscale,
                        'email'          => $appointment->email,
                    ],
                ];
            }
        
            return response()->json($events);
        }
        

}
