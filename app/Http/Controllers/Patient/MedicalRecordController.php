<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $records = $user->medicalRecords()
            ->with('doctor.user', 'prescriptions', 'media')
            ->latest('record_date')
            ->paginate(10);

        return view('patient.records.index', compact('records'));
    }

    public function show(MedicalRecord $record)
    {
        $user = Auth::user();
        if ($record->patient_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $record->load('doctor.user', 'doctor.department', 'prescriptions', 'media');
        return view('patient.records.show', compact('record'));
    }
}
