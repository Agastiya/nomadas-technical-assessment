@extends(backpack_view('blank'))

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="min-h-screen bg-slate-100 py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-between print:hidden">
                <a href="{{ backpack_url('loan-request') }}"
                    class="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                    <i class="la la-arrow-left text-base"></i>
                    <span>Back to list</span>
                </a>
            </div>

            <div class="bg-white shadow-xl rounded-2xl border border-slate-200 overflow-hidden">
                <div class="bg-indigo-600 text-white text-center py-6 px-4 print:hidden">
                    <h3 class="text-xl sm:text-2xl font-semibold tracking-wide">
                        ASSET HANDOVER TICKET #{{ $entry->id }}
                    </h3>
                </div>

                <div class="p-6 sm:p-8">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="md:w-2/3 space-y-6">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-xs font-semibold tracking-[0.2em] text-slate-500 uppercase">Asset</p>
                                    <h4 class="mt-1 text-2xl font-semibold text-slate-900">
                                        {{ $entry->item_name}}
                                    </h4>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold tracking-[0.2em] text-slate-500 uppercase">User</p>
                                    <p class="mt-1 text-lg font-medium text-slate-900">
                                        {{ $entry->user->name }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-xs font-semibold tracking-[0.2em] text-slate-500 uppercase">Loan Date</p>
                                    <p class="mt-1 text-lg font-medium text-slate-900">
                                        {{ \Carbon\Carbon::parse($entry->loan_date)->format('d M Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold tracking-[0.2em] text-slate-500 uppercase">Return Date</p>
                                    <p class="mt-1 text-lg font-medium text-slate-900">
                                        {{ $entry->return_date != null ? \Carbon\Carbon::parse($entry->return_date)->format('d M Y') : ' - ' }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-semibold tracking-[0.2em] text-slate-500 uppercase">Status</p>
                                <div class="mt-2">
                                    @php
                                        $isApproved = $entry->status === 'approved';
                                    @endphp
                                    <span
                                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold tracking-wide {{ $isApproved ? 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200' : 'bg-amber-100 text-amber-700 ring-1 ring-amber-200' }}">
                                        <span
                                            class="inline-block w-2 h-2 mr-2 rounded-full {{ $isApproved ? 'bg-emerald-500' : 'bg-red-400' }}"></span>
                                        {{ strtoupper($entry->status) }}
                                        @if($entry->status == 'rejected')
                                            <span class="ml-2 text-xs italic text-red-500">
                                                ({{ $entry->reason ?? " - " }})
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="md:w-1/3 flex flex-col items-center md:border-l md:border-slate-200 md:pl-8">
                            <div class="mb-4 text-center">
                                <p class="text-xs font-semibold tracking-[0.2em] text-slate-500 uppercase">Scan to
                                    Verify</p>
                                <div
                                    class="mt-3 w-40 h-40 flex items-center justify-center bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl">
                                    <i class="la la-qrcode text-6xl text-slate-500"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500">
                                Verification ID: {{ md5($entry->id) }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($entry->status == "approved" || $entry->status == "returned")
                    <div class="my-10 border-t-2 border-dashed border-slate-200"></div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-10 text-center">
                        <div>
                            <p class="mb-10 text-sm text-slate-600">Authorized By</p>
                            <div class="mx-auto w-4/5 border-b border-slate-700"></div>
                            <p class="mt-3 text-xs uppercase tracking-[0.2em] text-slate-500">Administrator</p>
                        </div>
                        <div>
                            <p class="mb-10 text-sm text-slate-600">Recipient Signature</p>
                            <div class="mx-auto w-4/5 border-b border-slate-700">
                                <span class="block -mt-5 text-[11px] text-slate-400 italic bg-white px-2">
                                    Digital Signature Area
                                </span>
                            </div>
                            <p class="mt-3 text-xs uppercase tracking-[0.2em] text-slate-500">
                                {{ $entry->user->name ?? 'Assignee' }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 flex items-center justify-end gap-3 print:hidden">
                        <button type="button" onclick="window.print()"
                            class="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                            <i class="la la-print text-base"></i>
                            <span>Print Pass</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @media print {
            .print\:hidden {
                display: none !important;
            }

            .main-footer {
                display: none !important;
            }

            body {
                background: white !important;
            }
        }
    </style>
@endsection