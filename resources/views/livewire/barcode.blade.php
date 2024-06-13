 <div class="p-6 lg:p-8">
   <x-button class="mb-4 mr-2" href="{{ route('admin.barcodes.create') }}">
     Buat Barcode Baru
   </x-button>
   <x-secondary-button class="mb-4">
     <a href="{{ route('admin.barcodes.downloadall') }}">Download Semua</a>
   </x-secondary-button>
   <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
     @foreach ($barcodes as $barcode)
       <div
         class="pointer-events-none flex flex-col rounded-lg bg-white p-4 shadow hover:bg-gray-100 dark:bg-gray-800 dark:shadow-gray-600 hover:dark:bg-gray-700">

         <div class="pointer-events-auto mt-4 flex items-center justify-center gap-2">
           <x-secondary-button href="{{ route('admin.barcodes.download', $barcode->id) }}">
             Download
           </x-secondary-button>
           <x-button href="{{ route('admin.barcodes.edit', $barcode->id) }}">
             Edit
           </x-button>
           <x-danger-button wire:click="confirmDeletion({{ $barcode->id }}, '{{ $barcode->name }}')">
             Delete
           </x-danger-button>
         </div>
         <a href="{{ route('admin.barcodes.show', $barcode->id) }}" class="pointer-events-auto">
           <div class="container flex items-center justify-center p-4">
             <div class="children:dark:text-gray-100 text-center dark:bg-gray-300">
               {!! $barcode->barcode !!}
             </div>
           </div>
         </a>
         <a href="{{ route('admin.barcodes.show', $barcode->id) }}" class="pointer-events-auto">
           <h3 class="mb-3 text-center text-lg font-semibold leading-tight text-gray-800 dark:text-white">
             {{ $barcode->name }}
           </h3>
         </a>
         <ul class="list-disc pl-4 dark:text-gray-400">
           <li> {{ __('Time In Valid From') }}: {{ $barcode->time_in_valid_from }}</li>
           <li> {{ __('Time In Valid Until') }}: {{ $barcode->time_in_valid_until }}</li>
           <li> {{ __('Time Out Valid From') }}: {{ $barcode->time_out_valid_from }}</li>
           <li> {{ __('Time Out Valid Until') }}: {{ $barcode->time_out_valid_until }}</li>
           <li> {{ __('Coords') . ': ' . $barcode->lat_lng['lat'] . ', ' . $barcode->latLng['lng'] }}</li>
           <li> {{ __('Radius (meter)') }}: {{ $barcode->radius }}</li>
         </ul>
       </div>
     @endforeach
   </div>

   <x-confirmation-modal wire:model="confirmingDeletion">
     <x-slot name="title">
       Hapus Barcode
     </x-slot>

     <x-slot name="content">
       Apakah Anda yakin ingin menghapus <b>{{ $deleteName }}</b>?
     </x-slot>

     <x-slot name="footer">
       <x-secondary-button wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
         {{ __('Cancel') }}
       </x-secondary-button>

       <x-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
         {{ __('Confirm') }}
       </x-danger-button>
     </x-slot>
   </x-confirmation-modal>

   <x-dialog-modal wire:model="editing">
     <x-slot name="title">
       Edit Barcode
     </x-slot>

     <form wire:submit.prevent="update">
       <x-slot name="content">
         <div>
           <x-label for="name">Nama Barcode</x-label>
           <x-input id="name" class="mt-1 block w-full" type="text" wire:model="name"
             placeholder="Barcode Baru" />
           @error('name')
             <x-input-error for="name" class="mt-2" message="{{ $message }}" />
           @enderror
         </div>
         <div class="mt-4">
           <x-label for="value">Value Barcode</x-label>
           <div class="flex gap-3">
             <div class="w-full">
               <x-input id="value" class="mt-1 block w-full" type="text" wire:model="value"
                 placeholder="Kode Barcode" />
               @error('value')
                 <x-input-error for="value" class="mt-2" message="{{ $message }}" />
               @enderror
             </div>
             <x-button wire:click="generate">{{ __('Generate') }}</x-button>
           </div>
         </div>
         <div class="mt-4 flex gap-3">
           <div class="w-full">
             <x-label for="time_in_valid_from">{{ __('Time In Valid From') }}</x-label>
             <x-input id="time_in_valid_from" class="mt-1 block w-full" type="time" wire:model="time_in_valid_from"
               placeholder="Kode Barcode" />
             @error('time_in_valid_from')
               <x-input-error for="time_in_valid_from" class="mt-2" message="{{ $message }}" />
             @enderror
           </div>
           <div class="w-full">
             <x-label for="time_in_valid_until">{{ __('Time In Valid Until') }}</x-label>
             <x-input id="time_in_valid_until" class="mt-1 block w-full" type="time" wire:model="time_in_valid_until"
               placeholder="Kode Barcode" />
             @error('time_in_valid_until')
               <x-input-error for="time_in_valid_until" class="mt-2" message="{{ $message }}" />
             @enderror
           </div>
         </div>
         <div class="mt-4 flex gap-3">
           <div class="w-full">
             <x-label for="time_out_valid_from">{{ __('Time Out Valid From') }}</x-label>
             <x-input id="time_out_valid_from" class="mt-1 block w-full" type="time" wire:model="time_out_valid_from"
               placeholder="Kode Barcode" />
             @error('time_out_valid_from')
               <x-input-error for="time_out_valid_from" class="mt-2" message="{{ $message }}" />
             @enderror
           </div>
           <div class="w-full">
             <x-label for="time_out_valid_until">{{ __('Time Out Valid Until') }}</x-label>
             <x-input id="time_out_valid_until" class="mt-1 block w-full" type="time"
               wire:model="time_out_valid_until" placeholder="Kode Barcode" />
             @error('time_out_valid_until')
               <x-input-error for="time_out_valid_until" class="mt-2" message="{{ $message }}" />
             @enderror
           </div>
         </div>
         <div class="mt-5">
           <div class="flex items-center gap-3">
             <h3 class="text-lg font-semibold">{{ __('Coordinate') }}</h3>
             <x-button wire:click="$toggle('showMap')"
               onclick="window.setMapLocation({ location: [Number({{ $lat }}), Number({{ $lng }})]}); showMap()">
               <x-heroicon-s-map-pin class="mr-2 h-5 w-5" /> {{ __('Choose from map') }}
             </x-button>
           </div>
           <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
             <div class="w-full">
               <x-label for="lat">Latitude</x-label>
               <x-input id="lat" class="mt-1 block w-full" type="text" wire:model="lat"
                 placeholder="cth: -6.12345" />
               @error('lat')
                 <x-input-error for="lat" class="mt-2" message="{{ $message }}" />
               @enderror
             </div>
             <div class="w-full">
               <x-label for="lng">Longitude</x-label>
               <x-input id="lng" class="mt-1 block w-full" type="text" wire:model="lng"
                 placeholder="cth: 6.12345" />
               @error('lng')
                 <x-input-error for="lng" class="mt-2" message="{{ $message }}" />
               @enderror
             </div>
           </div>

           <div id="map" class="h-96 w-full"></div>

           <div class="mt-3">
             <x-label for="radius">Radius Valid Absen</x-label>
             <x-input id="radius" class="mt-1 block w-full" type="number" wire:model="radius"
               placeholder="50 (meter)" />
             @error('radius')
               <x-input-error for="radius" class="mt-2" message="{{ $message }}" />
             @enderror
           </div>
         </div>
       </x-slot>

       <x-slot name="footer">
         <x-secondary-button wire:click="$toggle('editing')" wire:loading.attr="disabled">
           {{ __('Cancel') }}
         </x-secondary-button>

         <x-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
           {{ __('Confirm') }}
         </x-button>
       </x-slot>
     </form>
   </x-dialog-modal>
 </div>
