<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- Volver -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white transition-all duration-200 mb-6 group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-semibold tracking-wide">Volver al inicio</span>
            </a>
            <a href="{{ route('jobs.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Agregar Nuevo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:jobs-table />
        </div>
    </div>
    <x-delete-confirmation 
        id="del-job-modal" 
        title="Eliminar Trabajo" 
        message="¿Estás seguro de que deseas eliminar este trabajo completo junto con todos sus gastos? Esta acción no se puede deshacer." />

</x-app-layout>
