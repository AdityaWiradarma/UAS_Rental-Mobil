<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product as ProductModel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use Livewire\WithPagination;

class Product extends Component
{
    public $search;
    use WithPagination;
    use WithFileUploads;
    public $isOpen = 0;
    public $image,$name,$type,$price,$productId,$qty;
    public $confirmingProductDeletion = false;

    public function render()
    {
        $types = Type::all();
        $this->products = ProductModel::with('type');
        $searchParams = '%'.$this->search.'%';
        $products = ProductModel::orderBy('created_at','DESC')->get();
        return view('livewire.product',[
            'products' => $products,
            'products' => ProductModel::where('name','like', $searchParams)->latest()
                                        ->orWhere('type', 'like', $searchParams)->latest()->paginate(5)
        ], compact('types'));
    }

    public function previewImage(){
        $this->validate([
            'image' => 'image|max:2048'
        ]);
    }

    public function showModal(){
        $this->isOpen = true;
    }

    public function hideModal(){
        $this->isOpen = false;
    }

    public function store(){


        $products = ProductModel::all();

        $this->validate(
                [
                    'image' => 'image|max:2048|required',
                    'name' => 'required',
                    'type' => 'required',
                    'qty' => 'required',
                    'price' => 'required',
                ]
            );

            $imageName = md5($this->image.microtime().'.'.$this->image->extension());

            Storage::putFileAs(
                'public/images',
                $this->image,
                $imageName
            );

            ProductModel::updateOrCreate(['id' => $this->productId], [
                'image' => $imageName,
                'name' => $this->name,
                'type' => $this->type,
                'qty' => $this->qty,
                'price' => $this->price,
            ]);

            $this->hideModal();

            session()->flash('info', $this->productId ? 'Product Update Successfully' : 'Product Created Successfully');

            $this->productId = '';
            $this->image = '';
            $this->name = '';
            $this->type = '';
            $this->qty = '';
            $this->price = '';
    }

    public function edit($id){
        $product = ProductModel::findOrFail($id);
        $this->productId = $id;
        $imageName = $product->image;
        $this->name = $product->name;
        $this->type = $product->type;
        $this->qty = $product->qty;
        $this->price = $product->price;

        $this->showModal();
    }

    public function delete($id){
        ProductModel::find($id)->delete();
        $this-> confirmingProductDeletion = false;
        session()->flash('delete','Mobil Deleted Successfully');
    }

    public function confirmProductDeletion($id){
        //ProductModel::find($id)->delete();
        $this-> confirmingProductDeletion = $id;
    }


}
