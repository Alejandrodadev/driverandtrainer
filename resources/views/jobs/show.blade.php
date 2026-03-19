<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Volver -->
            <a href="{{ route('jobs.index') }}" class="flex items-center gap-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white transition-all duration-200 mb-6 group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-semibold tracking-wide">Volver al listado</span>
            </a>

            <!-- Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Header with Edit Button -->
                <div class="flex flex-row justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Detalles del Trabajo</h2>
                    <div class="flex gap-6">
                        @if($job->isEditable())
                            <form id="delete-job-form-{{ $job->id }}" action="{{ route('jobs.destroy', $job) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" 
                                    onclick="window['open_del-job-modal']('delete-job-form-{{ $job->id }}')"
                                    style="background-color: #dc2626 !important; color: #ffffff !important;"
                                    class="hover:bg-red-500 focus:ring-4 focus:ring-red-300 font-bold rounded-lg text-sm px-4 py-2 focus:outline-none transition-all duration-200 shadow-lg shadow-red-900/20">
                                Eliminar
                            </button>
                            <a href="{{ route('jobs.edit', $job) }}" class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">
                                Editar
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-900" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200 dark:border-red-900" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Job Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Evento / Artista</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $job->event_artist }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Lugar</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $job->location }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Fecha</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $job->date->format('d/m/Y') }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Furgoneta</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $job->van }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Horario</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($job->entry_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($job->exit_time)->format('H:i') }}
                        </p>
                    </div>
                </div>

                <hr class="h-px my-12 bg-gray-200 border-0 dark:bg-gray-700">

                <!-- Expenses Section -->
                <div class="mt-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Gastos Adjuntos</h3>

                    @php
                        $groupedExpenses = $job->expenses->groupBy('type');
                        $categories = [
                            'fuel'     => ['label' => 'Gasoil',    'icon' => 'M3 10h2l1 2h13l1-4H6L5 4H3m0 6a1 1 0 100 2 1 1 0 000-2zm15 0a1 1 0 100 2 1 1 0 000-2z'],
                            'food'     => ['label' => 'Comida',    'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 5h12m-10 0a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z'],
                            'promoter' => ['label' => 'Promotora', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                        ];
                    @endphp

                    @if($job->expenses->isEmpty())
                        <div class="p-8 text-center rounded-2xl dark:bg-gray-700/30 text-gray-500 dark:text-gray-400 border-2 border-dashed border-gray-200 dark:border-gray-600">
                            No se han registrado gastos para este trabajo.
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($categories as $key => $cat)
                                @if($groupedExpenses->has($key))
                                    @php $expenses = $groupedExpenses->get($key); @endphp

                                    <div x-data="{ open: false }"
                                         class="rounded-2xl border border-gray-200 dark:border-gray-600/60 bg-white dark:bg-gray-800 shadow-md dark:shadow-black/30 overflow-hidden">

                                        {{-- Header --}}
                                        <button
                                            @click="open = !open"
                                            type="button"
                                            class="w-full flex items-center justify-between px-5 py-4 text-left
                                                   transition-colors duration-150
                                                   hover:bg-gray-100 dark:hover:bg-gray-700">

                                            {{-- Izquierda: icono + label + badge --}}
                                            <div class="flex items-center gap-3">

                                                {{-- Icono --}}
                                                <div class="w-9 h-9 flex items-center justify-center rounded-xl shrink-0
                                                            bg-blue-50 dark:bg-blue-900/30
                                                            text-blue-500 dark:text-blue-400">
                                                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cat['icon'] }}"/>
                                                    </svg>
                                                </div>

                                                {{-- Label --}}
                                                <span class="font-semibold text-gray-800 dark:text-gray-100 text-sm tracking-wide">
                                                    {{ $cat['label'] }}
                                                </span>

                                                {{-- Badge contador --}}
                                                <span class="ml-3 inline-flex items-center justify-center w-6 h-6 shrink-0 text-xs font-bold rounded-full dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 ring-1 ring-blue-200 dark:ring-blue-700/50">
                                                    {{ $expenses->count() }}
                                                </span>
                                            </div>

                                            {{-- Chevron --}}
                                            <svg class="w-4 h-4 shrink-0 text-gray-400 dark:text-gray-500 transition-transform duration-300"
                                                 :class="{ 'rotate-180': open }"
                                                 fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>

                                        {{-- Body --}}
                                        <div
                                            x-show="open"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 -translate-y-2"
                                            class="border-t border-gray-100 dark:border-gray-700">

                                            <div class="p-4 space-y-2 bg-gray-50/50 dark:bg-gray-900/40">
                                                @foreach($expenses as $expense)
                                                    <div class="flex items-center justify-between px-4 py-3 bg-white dark:bg-gray-700/40 rounded-xl
                                                                border border-gray-200 dark:border-gray-700/60
                                                                shadow-sm hover:shadow-md
                                                                transition-shadow duration-150">
                                                        
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-8 h-8 flex items-center justify-center rounded-lg shrink-0
                                                                        bg-blue-50 dark:bg-gray-700
                                                                        text-blue-500 dark:text-gray-500">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                                </svg>
                                                            </div>
                                                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                                {{ $cat['label'] }} #{{ $loop->iteration }}
                                                            </span>
                                                        </div>

                                                        <div class="flex items-center gap-1">
                                                            {{-- Ver --}}
                                                            <a href="{{ Storage::url($expense->file_path) }}" 
                                                               target="_blank"
                                                               class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                                               title="Ver archivo">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                            </a>

                                                            {{-- Eliminar --}}
                                                            @if($job->isEditable())
                                                                <form id="del-{{ $expense->id }}" action="{{ route('expenses.destroy', $expense) }}" method="POST" class="hidden">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                                <button type="button"
                                                                        onclick="window['open_del-dialog']('del-{{ $expense->id }}')" 
                                                                        class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors cursor-pointer"
                                                                        title="Eliminar">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Footer Navigation -->
                <div class="mt-10 flex justify-end">
                    <a href="{{ route('jobs.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white flex items-center gap-2 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </div>
    <x-delete-confirmation 
        id="del-dialog" 
        title="Eliminar archivo" 
        message="¿Estás seguro de que deseas eliminar este gasto? Esta acción no se puede deshacer." />

    <x-delete-confirmation 
        id="del-job-modal" 
        title="Eliminar Trabajo" 
        message="¿Estás seguro de que deseas eliminar este trabajo completo junto con todos sus gastos? Esta acción no se puede deshacer." />

</x-app-layout>