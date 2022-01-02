<div class="py-4">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg py-4 px-4">
            <div class="flex mb-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <button wire:click="showModal()" class="py-1 px-4 text-sm rounded text-green-500 font-semibold border border-green-500 hover:text-white font-bold hover:bg-green-500 hover:border-transparent focus:outline-none">Add</button></a>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <input wire:model="search" type="text" class="shaddow appearance-none border rounded w-full py-2 px-3 text-blue-500 " aria-hidden="true" placeholder="Search">
                </div>
            </div>
                            @if($isOpen)
                                @include('livewire.createproduct')
                            @endif
                            @if(session()->has('info'))
                                <div class="bg-green-500 border-2 border-green-600 rounded-b mb-2 py-3">
                                    <div>
                                        <h1 class="text-white font-bold ml-4">{{session('info')}}</h1>
                                    </div>
                                </div>
                            @endif
                            @if(session()->has('delete'))
                                <div class="bg-red-500 border-2 border-red-600 rounded-b mb-2 py-3">
                                    <div>
                                        <h1 class="text-white font-bold ml-4">{{session('delete')}}</h1>
                                    </div>
                                </div>
                            @endif
            <table class="table-fixed w-full text-center">
                <thead class="bg-gradient-to-r from-green-400 to-blue-500">
                    <tr>
                        <th class="px-4 py-2 text-white">No</th>
                        <th class="px-4 py-2 text-white" width="10%">Image</th>
                        <th class="px-4 py-2 text-white">Nama</th>
                        <th class="px-4 py-2 text-white">Kategori</th>
                        <th class="px-4 py-2 text-white">Qty</th>
                        <th class="px-4 py-2 text-white">Harga</th>
                        <th class="px-4 py-2 text-white">Action </th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php $id=1;?>
                    @foreach ($products as $index=>$product )
                    <tr>
                        <td>{{$id}}</td>
                        <td><img src="{{ asset('storage/images/'. $product->image)}}" alt="product image" class="img-fluid"></td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->type}}</td>
                        <td>{{$product->qty}}</td>
                        <td>Rp {{number_format($product['price'],2,',','.') }}</td>
                        <td>
                            <x-jet-secondary-button wire:click="edit({{$product->id}})" wire:loading.attr="disabled">
                                Edit
                            </x-jet-secondary-button>
                            <x-jet-danger-button wire:click="confirmProductDeletion({{$product->id}})" wire:loading.attr="disabled">
                                Delete
                            </x-jet-danger-button>
                        </td>
                    </tr>
                    <?php $id++; ?>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 ">
                {{$products->links()}}
            </div>
            <x-jet-dialog-modal wire:model="confirmingProductDeletion">
                <x-slot name="title">
                    {{ __('Delete Product') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you want to delete your Product?') }}
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$set('confirmingProductDeletion', false)" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>

                    <x-jet-danger-button class="ml-2" wire:click="delete({{$confirmingProductDeletion}} )" wire:loading.attr="disabled">
                        {{ __('Delete Product') }}
                    </x-jet-danger-button>
                </x-slot>
            </x-jet-dialog-modal>
        </div>

        <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
            <div class="text-center text-sm text-gray-500 sm:text-left">
                <div class="flex items-center">
                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="-mt-px w-5 h-5 text-gray-400">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>

                    <a href="https://laravel.bigcartel.com" class="ml-1 underline">
                        Shop
                    </a>

                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="ml-4 -mt-px w-5 h-5 text-gray-400">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>

                    <a href="https://github.com/sponsors/taylorotwell" class="ml-1 underline">
                        Sponsor
                    </a>
                </div>
            </div>

            <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>
    </div>
</div>
