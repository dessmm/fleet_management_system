@extends('app')

@section('content')
<style>
    .detail-card { transition: box-shadow .2s ease; }
    .detail-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.08); }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-red-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-3xl mx-auto">

        <div class="mb-8 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shadow-lg shadow-red-200 flex-shrink-0 text-white text-xl">🔧</div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Maintenance Record</h1>
                <p class="text-gray-500 text-sm mt-0.5">Record #{{ str_pad($maintenance_record->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <div class="detail-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100">
                <span class="text-sm font-semibold text-gray-700">Record Details</span>
            </div>
            <div class="divide-y divide-gray-50">

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Vehicle</span>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ $maintenance_record->vehicle->plate_number ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $maintenance_record->vehicle->make ?? 'N/A' }} {{ $maintenance_record->vehicle->model ?? '' }}</p>
                    </div>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Issue</span>
                    <span class="inline-flex items-center px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-semibold rounded-lg border border-amber-100">{{ $maintenance_record->issue }}</span>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Service Date</span>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ $maintenance_record->service_date->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $maintenance_record->service_date->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Technician</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $maintenance_record->technician_name }}</span>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Cost</span>
                    <span class="text-sm font-bold text-gray-900">${{ number_format($maintenance_record->cost, 2) }}</span>
                </div>

                <div class="px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500 font-medium">Date Added</span>
                    <span class="text-sm text-gray-700">{{ $maintenance_record->created_at->format('M d, Y h:i A') }}</span>
                </div>

            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('maintenance_records.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 text-sm font-semibold rounded-xl shadow-sm border border-gray-200 hover:bg-gray-50 transition-all duration-200">
                ← Back
            </a>
            <a href="{{ route('maintenance_records.edit', $maintenance_record->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 text-white text-sm font-semibold rounded-xl shadow-sm hover:bg-amber-600 transition-all duration-200">
                Edit
            </a>
            <form action="{{ route('maintenance_records.destroy', $maintenance_record->id) }}" method="POST" class="ml-auto">
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