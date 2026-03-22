@extends('app')

@section('content')
<style>
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.14); }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-orange-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-3xl mx-auto">

        <div class="mb-8 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center shadow-lg shadow-orange-200 flex-shrink-0 text-white text-xl">⛽</div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Fuel Record</h1>
                <p class="text-gray-500 text-sm mt-0.5">Record #{{ str_pad($fuel_record->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100">
                <span class="text-sm font-semibold text-gray-700">Record Details</span>
            </div>
            <div class="divide-y divide-gray-50">

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Vehicle</span>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ $fuel_record->vehicle->plate_number ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $fuel_record->vehicle->make ?? 'N/A' }} {{ $fuel_record->vehicle->model ?? '' }}</p>
                    </div>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Fuel Type</span>
                    <span class="inline-flex items-center px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-semibold rounded-lg border border-amber-100">{{ $fuel_record->fuel_type }}</span>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Quantity</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format($fuel_record->quantity, 2) }} L</span>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Price per Liter</span>
                    <span class="text-sm font-semibold text-gray-900">₱{{ number_format($fuel_record->price_per_liter, 2) }}</span>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Total Cost</span>
                    <span class="text-sm font-bold text-gray-900">₱{{ number_format($fuel_record->cost, 2) }}</span>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Date</span>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($fuel_record->date)->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($fuel_record->date)->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Odometer</span>
                    <span class="text-sm text-gray-900">{{ $fuel_record->odometer ? number_format($fuel_record->odometer) . ' km' : '—' }}</span>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Gas Station</span>
                    <span class="text-sm text-gray-900">{{ $fuel_record->gas_station ?? '—' }}</span>
                </div>

                @if($fuel_record->notes)
                <div class="px-6 py-4 flex items-start justify-between gap-4">
                    <span class="text-sm text-gray-500 font-medium">Notes</span>
                    <span class="text-sm text-gray-900 text-right">{{ $fuel_record->notes }}</span>
                </div>
                @endif

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Date Added</span>
                    <span class="text-sm text-gray-700">{{ $fuel_record->created_at->format('M d, Y h:i A') }}</span>
                </div>

            </div>
        </div>

        <div class="flex items-center gap-3">
    <a href="{{ route('fuel_records.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 text-sm font-semibold rounded-xl shadow-sm border border-gray-200 hover:bg-gray-50 transition-all duration-200">
        ← Back
    </a>
    <a href="{{ route('fuel_records.pdf', $fuel_record->id) }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-50 text-orange-700 text-sm font-semibold rounded-xl shadow-sm border border-orange-200 hover:bg-orange-100 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Export PDF
    </a>
    <a href="{{ route('fuel_records.edit', $fuel_record->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 text-white text-sm font-semibold rounded-xl shadow-sm hover:bg-amber-600 transition-all duration-200">
        Edit
    </a>
    <form action="{{ route('fuel_records.destroy', $fuel_record->id) }}" method="POST" class="ml-auto">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Delete this record?')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-50 text-red-600 text-sm font-semibold rounded-xl border border-red-200 hover:bg-red-100 transition-all duration-200">
            Delete
        </button>
    </form>
</div>

    </div>
</div>
@endsection