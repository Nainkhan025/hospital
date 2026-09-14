<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctorProfile;
        $records = $doctor->medicalRecords()
            ->with('patient', 'prescriptions')
            ->latest('record_date')
            ->paginate(15);

        return view('doctor.records.index', compact('records'));
    }

    public function create(Request $request)
    {
        $doctor = Auth::user()->doctorProfile;
        $patients = User::role('patient')->select('id', 'name', 'email', 'phone')->orderBy('name')->get();
        $appointment = null;

        if ($request->appointment_id && $doctor) {
            $appointment = Appointment::where('id', $request->appointment_id)
                ->where('doctor_profile_id', $doctor->id)
                ->first();
        }

        return view('doctor.records.create', compact('patients', 'appointment'));
    }

    public function store(Request $request)
    {
        $doctor = Auth::user()->doctorProfile;
        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $request->validate([
            'patient_id'        => 'required|exists:users,id',
            'appointment_id'    => 'nullable|exists:appointments,id',
            'diagnosis'         => 'required|string',
            'treatment_plan'    => 'nullable|string',
            'notes'             => 'nullable|string',
            'record_date'       => 'required|date|before_or_equal:today',
            'document'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // max 10MB
            'medications'       => 'nullable|array',
            'medications.*.name'     => 'required_with:medications|string',
            'medications.*.dosage'   => 'required_with:medications|string',
            'medications.*.frequency'=> 'required_with:medications|string',
            'medications.*.duration' => 'required_with:medications|string',
        ]);

        // Verify appointment ownership if appointment_id provided
        $appointment = null;
        if ($request->filled('appointment_id')) {
            $appointment = Appointment::where('id', $request->appointment_id)
                ->where('doctor_profile_id', $doctor->id)
                ->first();

            if (!$appointment) {
                return back()->withInput()->withErrors(['appointment_id' => 'The selected appointment is invalid or does not belong to you.']);
            }
        }

        DB::transaction(function () use ($request, $doctor, $appointment) {
            $record = MedicalRecord::create([
                'patient_id'        => $request->patient_id,
                'doctor_profile_id' => $doctor->id,
                'appointment_id'    => $appointment?->id,
                'diagnosis'         => $request->diagnosis,
                'treatment_plan'    => $request->treatment_plan,
                'notes'             => $request->notes,
                'record_date'       => $request->record_date,
            ]);

            // Save prescriptions if provided
            if ($request->filled('medications')) {
                foreach ($request->medications as $med) {
                    if (!empty($med['name'])) {
                        $record->prescriptions()->create([
                            'medication_name' => $med['name'],
                            'dosage'          => $med['dosage'],
                            'frequency'       => $med['frequency'],
                            'duration'        => $med['duration'],
                            'instructions'    => $med['instructions'] ?? null,
                        ]);
                    }
                }
            }

            // Secure document upload
            if ($request->hasFile('document')) {
                $record->addMediaFromRequest('document')
                    ->toMediaCollection('medical_documents');
            }

            // Mark appointment completed if linked
            if ($appointment) {
                $appointment->update(['status' => 'completed']);
            }
        });

        return redirect()->route('doctor.records.index')->with('success', 'Medical record & prescriptions created successfully.');
    }

    public function show(MedicalRecord $record)
    {
        $doctor = Auth::user()->doctorProfile;
        if ($record->doctor_profile_id !== $doctor->id) {
            abort(403);
        }

        $record->load('patient', 'prescriptions', 'media');
        return view('doctor.records.show', compact('record'));
    }
}
