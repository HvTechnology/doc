<?php

namespace App\Http\Controllers;

use App\Bookings\Date;
use App\Bookings\ServiceSlotAvailability;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Patient;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __invoke(Employee $employee, Service $service)
    {
        abort_unless($employee->services->contains($service), 404);

        $availability = (new ServiceSlotAvailability(collect([$employee]), $service))
            ->forPeriod(
                now()->startOfDay(),
                now()->addMonth()->endOfDay(),
            );

        $availableDates = $availability
            ->hasSlots()
            ->mapWithKeys(fn (Date $date) => [$date->date->toDateString() => $date->slots->count()])
            ->toArray();

        return view('bookings.checkout', [
            'employee' => $employee,
            'service' => $service,
            'firstAvailableDate' => $availability->firstAvailableDate()->date->toDateString(),
            'availableDates' => $availableDates,
        ]);
    }
    public function newapp($id)
    {
        $patient = Patient::findOrFail($id);

        // Set employee_id and service_id to 1
        $employee = Employee::findOrFail(1);
        $service = Service::findOrFail(1);

        // Ensure the employee offers the service
        abort_unless($employee->services->contains($service), 404);

        // Fetch availability data
        $availability = (new ServiceSlotAvailability(collect([$employee]), $service))
            ->forPeriod(
                now()->startOfDay(),
                now()->addMonth()->endOfDay(),
            );

        $availableDates = $availability
            ->hasSlots()
            ->mapWithKeys(function (Date $date) {
                return [$date->date->toDateString() => $date->slots->count()];
            })
            ->toArray();

        // Return the 'dashboard.newapp' view with all required data
        return view('bookings.newapp', [
            'employee' => $employee,
            'service' => $service,
            'patient' => $patient,
            'firstAvailableDate' => optional($availability->firstAvailableDate())->date->toDateString(),
            'availableDates' => $availableDates,
        ]);
    }
}
