<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DocumentController extends Controller
{
    public function download(Media $media)
    {
        $user = Auth::user();

        // Check if user is authorized to access this document
        if ($media->model_type === MedicalRecord::class) {
            $record = MedicalRecord::find($media->model_id);
            if ($record) {
                $isPatient = $user->isPatient() && $record->patient_id === $user->id;
                $isDoctor  = $user->isDoctor() && $record->doctor_profile_id === $user->doctorProfile?->id;
                $isAdmin   = $user->isAdmin();

                if (!$isPatient && !$isDoctor && !$isAdmin) {
                    abort(403, 'Unauthorized to view this document.');
                }
            }
        }

        return response()->file($media->getPath());
    }
}
