<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
      {{ __('Master Data') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
        <div class="p-6 lg:p-8">
          <div class="mb-5 grid grid-cols-1 gap-4 lg:grid-cols-2">
            @livewire('division-component')
            @livewire('job-title-component')
            @livewire('education-component')
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
