<x-dashboard-layout>
    <x-slot name="title">Generate Invoice</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Generate Patient Invoice</h1>
        <a href="{{ route('reception.invoices.index') }}" class="btn-outline-sm">Back</a>
    </x-slot>

    <div class="max-w-3xl">
        <x-card>
            <form method="POST" action="{{ route('reception.invoices.store') }}" class="space-y-6" x-data="{ items: [{desc:'Consultation Fee', price: {{ $appointment->consultation_fee ?? 150.00 }}, qty: 1}] }">
                @csrf
                @if($appointment)
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                    <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                    <div class="p-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-900">
                        Invoice for Appointment #APT-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }} — Patient: <strong>{{ $appointment->patient->name }}</strong>
                    </div>
                @else
                    <div>
                        <label class="form-label">Select Patient</label>
                        <select name="patient_id" class="form-select" required>
                            <option value="">Choose patient...</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->email }})</option>
                            @endforeach
                        </select>
                        @error('patient_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                @endif

                <div>
                    <label class="form-label">Payment Due Date</label>
                    <input type="date" name="due_date" value="{{ old('due_date', today()->addDays(7)->format('Y-m-d')) }}" class="form-input" required>
                    @error('due_date') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <!-- Line Items Repeater -->
                <div class="pt-4 border-t border-[#E4E4E7]">
                    <div class="flex items-center justify-between mb-3">
                        <label class="form-label mb-0">Invoice Items</label>
                        <button type="button" @click="items.push({desc:'', price:0, qty:1})" class="btn-outline-sm py-1 text-xs">+ Add Line Item</button>
                    </div>

                    <template x-for="(item, index) in items" :key="index">
                        <div class="grid grid-cols-12 gap-2 mb-3 p-3 border border-[#E4E4E7] rounded-lg bg-[#FAFAFA]">
                            <div class="col-span-6">
                                <input type="text" :name="`items[${index}][desc]`" x-model="item.desc" class="form-input text-xs" placeholder="Item description (e.g. Lab Test)" required>
                            </div>
                            <div class="col-span-3">
                                <input type="number" step="0.01" :name="`items[${index}][price]`" x-model="item.price" class="form-input text-xs" placeholder="Price ($)" required>
                            </div>
                            <div class="col-span-2">
                                <input type="number" :name="`items[${index}][qty]`" x-model="item.qty" class="form-input text-xs" min="1" placeholder="Qty" required>
                            </div>
                            <div class="col-span-1 flex items-center justify-center">
                                <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" class="text-red-500 hover:text-red-700 text-xs font-bold">&times;</button>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="pt-4 border-t border-[#E4E4E7] flex justify-end gap-2">
                    <a href="{{ route('reception.invoices.index') }}" class="btn-outline-sm">Cancel</a>
                    <button type="submit" class="btn-primary">Generate Invoice</button>
                </div>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>
