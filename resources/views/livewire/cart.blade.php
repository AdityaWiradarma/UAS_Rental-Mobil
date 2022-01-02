<div class="row py-8">
    <div class="col-md-8">

            <div class="card">
                <div class="blur">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6"><h2 class="font-weight-bold text-dark-500">Product List</h2></div>
                        <div class="col-md-6"><input wire:model="search" type="text" class="form-control" placeholder="Search Product..." ></div>
                    </div>
                    <div class="row">
                        @forelse ($products as $product )
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="{{ asset('storage/images/'. $product->image)}}" alt="product" style="object-fit: contain; width:100%; height:125px">
                                        <button wire:click="addItem({{$product->id}})" class="btn btn-danger btn-sm" style="position:absolute;top:0; right:0" ><i class="fas fa-cart-plus"></i></button>
                                    </div>
                                    <div class="card-footer text-center">
                                        <h6>{{$product->name}}</h6>
                                        <h6>Rp {{number_format($product['price'],2,',','.') }}</h6>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-sm-12 pt-40 pb-48">
                                <h1 class="text-center font-weight-bold text-secondary">No Products Found</h1>
                            </div>

                        @endforelse
                    </div>
                    <div style="display:flex; justify-content:center">
                        {{$products->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center font-weight-bold">Keranjang</h2>
                <div class="card-body">
                    @if(session()->has('error'))
                            <p class="text-danger font-weight-bold">
                                {{session('error')}}
                            </p>
                    @endif
                    <table class="table table-sm table-bordered table-hovered">
                        <thead class="bg-white text-center">
                            <tr >
                                <th class="font-weight-bold">Name</th>
                                <th class="font-weight-bold">Qty</th>
                                <th class="font-weight-bold">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($carts as $index=>$cart)
                                <tr>
                                    </td>
                                    <td>{{$cart['name']}}</td>
                                    <td style="text-align: center">
                                        <button class="btn btn-primary btn-sm" style="padding: 3px 5px"  wire:click="decreaseItem('{{$cart['rowId']}}')"><i class="fas fa-minus"></i></button>
                                            {{$cart['qty']}}
                                        <button class="btn btn-info btn-sm" style="padding: 3px 5px" wire:click="increaseItem('{{$cart['rowId']}}')"><i class="fas fa-plus" ></i></button>
                                        <button class="btn btn-danger btn-sm" style="padding: 3px 5px" wire:click="removeItem('{{$cart['rowId']}}')"><i class="fas fa-trash" ></i></button>
                                    </td>
                                    <td>Rp {{number_format($cart['price'],2,',','.') }}</td>
                                </tr>
                            @empty
                                <td colspan="4"><h6 class="text-center">Keranjang Kosong</h6></td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if (session()->has('error'))
            <div class="bg-gradient-to-r from-red-700 to-orange-700 border-l-4 border-black-500 text-white-700 p-1 mb-3 mt-3" role="alert">
                <h5 class="text-white font-semibold">{{ session('error') }}</h5>
            </div>
            @endif

            @if ($isOpen)
                @include('livewire.detailpesanan')
            @endif

            <div class="card">
                <div class="card-body mb-2">
                    <h4 class="font-weight-bold text-center pb-4">Cart Summary</h4>
                    <h5 class="font-weight-bold">Sub Total : Rp {{number_format($summary['sub_total'],2,',','.') }}</h5>
                    <!--<h5 class="font-weight-bold">Pajak : Rp {{number_format($summary['pajak'],2,',','.') }}</h5>-->
                    <h5 class="font-weight-bold">Total : Rp {{number_format($summary['total'],2,',','.') }}</h5>
                    <!-- <div class="form-group mt-4">
                        <input type="number" wire:model="payment" class="form-control" id="payment" placeholder="Input Payment">
                        <input type="hidden" id="total" value="{{$summary['total']}}">
                    </div>

                        <div>
                            <label>Payment</label>
                            <h1 id="paymentText" wire:ignore>Rp. 0</h1>
                        </div>
                        <div>
                            <label>Kembalian</label>
                            <h1 id="kembalianText" wire:ignore>Rp. 0</h1>
                        </div>-->

                        <div class="mt-3">
                            <button wire:click="showModal()" class="btn btn-success btn-block">
                            Pesan<i class="ml-2 fas fa-shopping-cart"></i>
                        </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script-custom')
<script> //javascript native
    payment.oninput = () => {
        const paymentAmount = document.getElementById("payment").value
        const totalAmount = document.getElementById("total").value

        const kembalian = paymentAmount - totalAmount

        document.getElementById("kembalianText").innerHTML = `Rp ${rupiah(kembalian)},00`
        document.getElementById("paymentText").innerHTML = `Rp ${rupiah(paymentAmount)},00`

        const saveButton = document.getElementById("saveButton")

        if(kembalian < 0){
            saveButton.disabled = true
        }else{
            saveButton.disabled = false
        }
        //console.log({paymentAmount,totalAmount,kembalian});
    }

    const rupiah = (angka) => {
        const numberString = angka.toString()
        const split = numberString.split(',')
        const sisa = split[0].length % 3
        let rupiah = split[0].substr(0, sisa)
        const ribuan = split[0].substr(sisa).match(/\d{1,3}/gi)

        if(ribuan){
            const separator = sisa ? '.' : ''
            rupiah += separator + ribuan.join('.')
        }

        return split[1] != undefined ? rupiah + ',' + split[1] : rupiah
    }
</script>

@endpush
