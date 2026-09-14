<x-dashboard-layout>
    <x-slot name="title">All Appointments</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Appointments Management</h1>
    </x-slot>

    <!-- Filters -->
    <x-card class="mb-6">
        <form method="GET" action="{{ route('admin.appointments.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach(['pending','confirmed','completed','cancelled','no_show'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Doctor</label>
                <select name="doctor_id" class="form-select">
                    <option value="">All Doctors</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>{{ $doc->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="form-input">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-primary-sm flex-1 justify-center">Filter</button>
                @if(request()->hasAny(['status','department_id','doctor_id','date']))
                    <a href="{{ route('admin.appointments.index') }}" class="btn-outline-sm">Clear</a>
                @endif
            </div>
        </form>
    </x-card>

    <!-- Appointments Table -->
    <x-card>
        @if($appointments->isEmpty())
            <div class="text-center py-12 text-[#71717A]" style="font-family:'Geist',sans-serif;">No appointments matching query.</div>
        @else
            <div class="overflow-x-auto -mx-6">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appt)
                        <tr>
                            <td class="font-mono text-xs font-semibold">#APT-{{ str_pad($appt->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="font-medium text-gray-900">{{ $appt->patient->name }}</td>
                            <td>{{ $appt->doctor->user->name }}</td>
                            <td>{{ $appt->department->name }}</td>
                            <td>
                                {{ $appt->appointment_date->format('M j, Y') }}
                                <span class="text-xs text-[#71717A] block">{{ \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') }}</span>
                            </td>
                            <td><x-status-badge :status="$appt->status" /></td>
                            <td>
                                <form method="POST" action="{{ route('admin.appointments.update', $appt->id) }}" class="inline-flex items-center gap-1">
                                    @csrf @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs border border-[#E4E4E7] rounded px-2 py-1 bg-white font-medium cursor-pointer">
                                        @foreach(['pending','confirmed','completed','cancelled','no_show'] as $st)
                                            <option value="{{ $st }}" {{ $appt->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-[#E4E4E7]">
                {{ $appointments->withQueryString()->links() }}
            </div>
        @endif
    </x-card>
</x-dashboard-layout>
