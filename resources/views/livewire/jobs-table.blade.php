<div>
    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
        <!-- Search -->
        <div class="relative">
            <label class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Buscar</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0.5 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       style="padding-left: 2.5rem;"
                       class="block w-full py-2.5 pr-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                       placeholder="Buscar...">
            </div>
        </div>

        <!-- From Date -->
        <div>
            <label class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Desde</label>
            <input type="date" 
                   wire:model.live="fromDate"
                   class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 [color-scheme:light] dark:[color-scheme:dark]">
        </div>

        <!-- To Date -->
        <div>
            <label class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hasta</label>
            <input type="date" 
                   wire:model.live="toDate"
                   class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 [color-scheme:light] dark:[color-scheme:dark]">
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Evento / Artista</th>
                    <th scope="col" class="px-6 py-3">Lugar</th>
                    <th scope="col" class="px-6 py-3">Fecha</th>
                    <th scope="col" class="px-6 py-3">Furgoneta</th>
                    <th scope="col" class="px-6 py-3"><span class="sr-only">Acciones</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $job->event_artist }}
                    </td>
                    <td class="px-6 py-4">{{ $job->location }}</td>
                    <td class="px-6 py-4">{{ $job->date->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">{{ $job->van }}</td>
                    <td class="px-6 py-4 text-right flex justify-end items-center space-x-3">
                        <a href="{{ route('jobs.show', $job) }}" class="font-bold text-blue-600 dark:text-blue-500 hover:underline">Ver</a>
                        
                        @if($job->isEditable())
                        <a href="{{ route('jobs.edit', $job) }}" class="font-bold text-yellow-600 dark:text-yellow-500 hover:underline">Editar</a>
                        
                        <form id="delete-job-form-{{ $job->id }}" action="{{ route('jobs.destroy', $job) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button type="button" 
                                onclick="window['open_del-job-modal']('delete-job-form-{{ $job->id }}')"
                                class="font-bold text-red-600 dark:text-red-500 hover:underline cursor-pointer">
                            Eliminar
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 text-center text-gray-500 dark:text-gray-400 italic py-12">
                        No se han encontrado resultados para tu búsqueda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $jobs->links() }}
    </div>
</div>
