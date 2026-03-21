@extends('app')

@section('content')
<style>
    .maintenance-row { transition: background-color .15s ease, transform .15s ease; }
    .maintenance-row:hover { background-color: #fff4f4 !important; transform: translateX(2px); }
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.14); }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-red-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shadow-lg shadow-red-200 flex-shrink-0 text-white text-xl">🔧</div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Maintenance Records</h1>
                <p class="text-gray-500 text-sm mt-0.5">Track repairs, service schedules, and maintenance costs</p>
            </div>
        </div>
        <a href="{{ route('maintenance_records.create') }}" class="action-btn inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-red-200 hover:shadow-lg hover:shadow-red-300 hover:-translate-y-0.5 self-start sm:self-auto">
            Add Record
        </a>
    </div>

    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
            <span class="text-sm font-semibold text-gray-700">Service History</span>
            <span class="ml-1 px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-700 rounded-full">{{ count($maintenance_records) }}</span>
        </div>
        @if(count($maintenance_records) > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Record</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Vehicle</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Issue</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Service Date</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Technician</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cost</th>
                            <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($maintenance_records as $record)
                            <tr class="maintenance-row">
                                <td class="px-6 py-4"><span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-lg">#{{ str_pad($record->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-gray-900">{{ $record->vehicle->plate_number ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $record->vehicle->make ?? 'N/A' }} {{ $record->vehicle->model ?? '' }}</p>
                                </td>
                                <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-semibold rounded-lg border border-amber-100">{{ $record->issue }}</span></td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $record->service_date->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $record->service_date->diffForHumans() }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $record->technician_name }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">${{ number_format($record->cost, 2) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('maintenance_records.show', $record->id) }}" class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </svg>
    View
</a>
                                        <a href="{{ route('maintenance_records.edit', $record->id) }}" class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg">Edit</a>
                                        <form action="{{ route('maintenance_records.destroy', $record->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this record?')" class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mb-5 text-3xl">🔧</div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No maintenance records found</h3>
                <p class="text-gray-400 text-sm mb-6 max-w-xs">Start tracking maintenance activity by adding your first record.</p>
                <a href="{{ route('maintenance_records.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">Add First Record</a>
            </div>
        @endif
    </div>
</div>
@endsection