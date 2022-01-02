<!-- This example requires Tailwind CSS v2.0+ -->
<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen  text-center sm:block sm:p-0">
      <!--
        Background overlay, show/hide based on modal state.
        Entering: "ease-out duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100"
          To: "opacity-0"
      -->
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <!--
        Modal panel, show/hide based on modal state.
        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
      <div class="inline-block align-top bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-top sm:max-w-lg sm:w-full">
            <div class="mt-2 text-center">
              <h3 id="modal-title" class="font-bold mb-3">
                Detail Order
              </h3>
              <div class="mt-2 text-left ml-4">
                    <table class="">
                        <thead>
                            <th class="w-32">Nama Produk</th>
                            <th class="w-20">Jumlah</th>
                            <th>Harga</th>
                        </thead>
                        @forelse ($carts as $cart)
                            <tbody>
                                <tr>
                                    <td>Mobil {{ $cart['name'] }}</td>
                                    <td>{{ $cart['qty'] }}</td>
                                    <td>Rp. {{ number_format($cart['price'],2,',','.') }}</td>
                                </tr>
                            </tbody>
                            @empty
                                <h6 class="text-center">Nothing to order!</h6>
                        @endforelse
                    </table>
              </div>
            </div>
            <p class="font-bold ml-4 mb-0 mt-2">Total : Rp. {{ number_format($summary['total'],2,',','.') }}</p>
            <p class="font-bold ml-4">Nama Pemesan : {{{ Auth::user()->name}}}</p>
        <div class="p-3">
            <div class="row">
                <div class="col-6">
                    <form wire:submit.prevent="handleSubmit">
                        <div class="mt-4 mb-2">
                            <button wire:click = "hideModal()" type="button" class="btn btn-danger btn-block">
                                Batal<i class="ml-2 fas fa-times"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-6">
                    <form wire:submit.prevent="handleSubmit">
                        <div class="mt-4 mb-2">
                            <button wire:ignore type="submit" id="saveButton" class="btn btn-success btn-block">
                                Konfirmasi<i class="ml-2 fas fa-check"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
