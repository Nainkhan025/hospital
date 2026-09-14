<x-mail::message>
# Appointment Confirmation

Dear {{ $appointment->patient->name }},

Your appointment request at MedCare Hospital has been received.

**Appointment Reference:** #APT-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}  
**Department:** {{ $appointment->department->name }}  
**Consultant:** {{ $appointment->doctor->user->name }}  
**Date:** {{ $appointment->appointment_date->format('l, F j, Y') }}  
**Time:** {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}  
**Consultation Fee:** ${{ number_format($appointment->consultation_fee, 2) }}  

<x-mail::button :url="route('patient.appointments.index')">
View My Appointments
</x-mail::button>

Thank you for choosing MedCare Hospital.

Regards,  
MedCare Hospital Team
</x-mail::message>
