<?php

namespace App\Http\Controllers;
use App\Models\Schedule;
use App\Models\ScheduleExclusion;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    // app/Http/Controllers/ScheduleController.php


    public function edit()
    {   
        $schedule = Schedule::findOrFail(1);
        return view('dashboard.schedule.index', compact('schedule'));
    }

public function update(Request $request, $id)
{
    $request->validate([
        'starts_at' => 'nullable|date',
        'ends_at' => 'nullable|date|after_or_equal:starts_at',
        // Add validation rules for other fields
    ]);

    $schedule = Schedule::findOrFail($id);
    $schedule->update($request->all());
    $schedule = Schedule::findOrFail(1);
    return view('dashboard.schedule.index', compact('schedule'));

}
public function create()
    {
        // Optional: Fetch employees if you want to display them in a dropdown
        // $employees = \App\Models\Employee::all();
        // return view('employee_times.create', compact('employees'));

        return view('employee_times.create');
    }

    public function store(Request $request)
    {

    $validatedData = $request->validate([

        'starts_at' => 'required|date',
        'ends_at' => 'required|date|after_or_equal:starts_at',
    ]);


    $validatedData['employee_id'] = 1;

        // Create the record
        ScheduleExclusion::create($validatedData);

        $schedules = ScheduleExclusion::where('employee_id', 1)
        ->orderBy('starts_at', 'asc')
        ->paginate(5);
            

    return view('dashboard.vacation.index', compact('schedules'));
    }

    public function vacation()
    {   
        $schedules = ScheduleExclusion::where('employee_id', 1)
            ->orderBy('starts_at', 'asc')
            ->paginate(5);
                

        return view('dashboard.vacation.index', compact('schedules'));
    }
    public function destroy($id)
    {
        // Find the schedule by ID
        $schedule = ScheduleExclusion::findOrFail($id);

        

        // Delete the schedule
        $schedule->delete();

        $schedules = ScheduleExclusion::where('employee_id', 1)
            ->orderBy('starts_at', 'asc')
            ->paginate(5);
                

        return view('dashboard.vacation.index', compact('schedules'));
    }
}
