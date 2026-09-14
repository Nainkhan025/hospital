<x-mail::message>
# Appointment Cancellation Notice

Dear {{ $appointment->patient->name }},

Your appointment **#APT-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}** scheduled for {{ $appointment->appointment_date->format('F j, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }} with {{ $appointment->doctor->user->name }} has been cancelled.

If you did not request this cancellation or would like to reschedule, please visit our booking page or contact our reception desk.

<x-mail::button :url="route('patient.appointments.create')">
Book New Appointment
</x-mail::button>

Regards,  
MedCare Hospital Team
</x-mail::message>
