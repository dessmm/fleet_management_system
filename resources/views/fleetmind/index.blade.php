@extends('app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-5xl mx-auto">

        <div class="flex items-start justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-700 flex items-center justify-center shadow-lg shadow-indigo-200 flex-shrink-0 text-white text-xl">
                    🤖
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">FleetMind Assistant</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Ask questions about vehicles, drivers, fuel, maintenance, and trips</p>
                </div>
            </div>
            <form action="{{ route('fleetmind.index') }}" method="GET">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50">
                    Refresh
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2 space-y-4">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                        <p class="text-sm font-semibold text-gray-700">Conversation</p>
                        <p class="text-xs text-gray-400">{{ count($history ?? []) }} message(s)</p>
                    </div>

                    <div class="p-6 space-y-4">
                        @if(empty($history))
                            <div class="text-center py-10">
                                <div class="w-16 h-16 bg-indigo-50 rounded-2xl mx-auto flex items-center justify-center text-3xl mb-4">🤖</div>
                                <p class="text-gray-700 font-semibold">Ask FleetMind a question</p>
                                <p class="text-gray-400 text-sm mt-1">FleetMind answers using your system records — no guessing.</p>
                            </div>
                        @else
                            @foreach($history as $item)
                                <div class="space-y-2">
                                    <div class="flex justify-end">
                                        <div class="max-w-[85%] bg-indigo-600 text-white rounded-2xl px-4 py-3 shadow-sm">
                                            <p class="text-sm font-semibold">You</p>
                                            <p class="text-sm mt-1 whitespace-pre-wrap">{{ $item['question'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-start">
                                        <div class="max-w-[85%] bg-white border border-gray-200 rounded-2xl px-4 py-3 shadow-sm">
                                            <p class="text-sm font-semibold text-gray-900">FleetMind</p>
                                            <p class="text-sm text-gray-700 mt-1 whitespace-pre-wrap">{{ $item['answer'] }}</p>
                                            <p class="text-xs text-gray-400 mt-2">{{ $item['at'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        <form action="{{ route('fleetmind.ask') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                            @csrf
                            <input type="text" name="question" required
                                   placeholder="e.g. Which drivers have expired licenses?"
                                   class="flex-1 px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-semibold shadow-md shadow-indigo-200 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                                Ask
                            </button>
                        </form>
                        <p class="text-xs text-gray-400 mt-2">Tip: You can ask about “last month”, “this month”, or provide a date range like 2026-03-01 to 2026-03-31.</p>
                    </div>
                </div>

            </div>

            <div class="space-y-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Example questions</p>
                    <div class="space-y-2">
                        @foreach([
                            'Which drivers have expired licenses?',
                            'Which licenses are expiring soon?',
                            'How much did we spend on fuel last month?',
                            'Show overdue maintenance',
                            'Give me a fleet summary',
                            'Trip summary'
                        ] as $ex)
                            <form action="{{ route('fleetmind.ask') }}" method="POST">
                                @csrf
                                <input type="hidden" name="question" value="{{ $ex }}">
                                <button type="submit" class="w-full text-left px-4 py-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-200 text-sm text-gray-700 transition-colors">
                                    {{ $ex }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">What FleetMind can do</p>
                    <ul class="text-xs text-gray-500 space-y-2">
                        <li>- Summarize vehicles and drivers by status</li>
                        <li>- Flag expired/expiring licenses</li>
                        <li>- Summarize recent maintenance and potential overdue items</li>
                        <li>- Estimate fuel spend for common date ranges</li>
                        <li>- Summarize recent trips</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

