<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

use App\Models\Appointment;
class PatientController extends Controller
{
    public function checkCodiceFiscale(Request $request)
    {
        // Validate the input
        $request->validate([
            'codice_fiscale' => 'required|string|size:16', // Ensure it's exactly 16 characters
        ]);

        // Check if the Codice Fiscale exists in the database
        $patient = Patient::where('Codice_Fiscale', $request->input('codice_fiscale'))->first();

        if (!$patient) {
            // Return an error response if Codice Fiscale is not found
            return response()->json(['error' => 'Codice Fiscale not found'], 404);
        }

        // Return success response if Codice Fiscale is found
        return response()->json(['message' => 'Codice Fiscale found'], 200);
    }

    public function pazienti()
    {
        
        $patients = Patient::paginate(10);
        
        return view('dashboard.pazienti', compact('patients'));
        
    }


    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'Codice_Fiscale' => 'required|string|size:16|unique:patients,Codice_Fiscale',
        'email' => 'required|email|max:255',
    ]);

    Patient::create($validatedData);

    // Set flash success message
    return redirect()->back()->with('success', 'Paziente aggiunto con successo.');
}
// Fetch the patient's current data
public function show($id)
{
    $patient = Patient::findOrFail($id);
    return response()->json($patient);
}

// Update the patient's data
public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'Codice_Fiscale' => 'required|string|size:16|unique:patients,Codice_Fiscale,'.$id,
        'email' => 'required|email|max:255',
    ]);

    $patient = Patient::findOrFail($id);
    $patient->update($validatedData);

    return response()->json($patient);
}
public function newapp($id)
{
    $patient = Patient::findOrFail($id);


        return view('dashboard.newapp', compact('patient'));
}

public function search(Request $request)
{
    $search = $request->input('search');

    // Search patients by name, Codice Fiscale, email, or phone
    $patients = Patient::query()
        ->when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('Codice_Fiscale', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%")
                         ->orWhere('phone', 'LIKE', "%{$search}%");
        })
        ->paginate(10);

        return view('dashboard.pazienti', compact('patients'));
}

public function view($id)
{
    // Retrieve the patient by ID
    $patient = Patient::findOrFail($id);

    // Retrieve all appointments associated with the patient's Codice Fiscale
    $appointments = Appointment::where('codice_fiscale', $patient->Codice_Fiscale)->get();

    // Return the view with the patient's data and appointment history
    return view('dashboard.paziente', compact('patient', 'appointments'));
}

}
