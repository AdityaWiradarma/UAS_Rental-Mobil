<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Mobil;
use App\Models\Type;
use Livewire\WithPagination;

class Mobils extends Component
{
    use WithPagination;
    public $search;
    //public $mobils;
    public $mobilId,$mobil, $type, $harga;
    public $isOpen = 0;
    public function render()
    {
        $types = Type::all();
        $this->mobils = Mobil::with('type');
        $searchParams = '%'.$this->search.'%';
        //$this->mobils = Mobil::all();
        return view('livewire.mobils',[
            'mobils' => Mobil::where('mobil','like', $searchParams)->latest()
                      ->orWhere('type', 'like', $searchParams)->latest()->paginate(5)
        ], compact('types'));
    }

    public function showModal(){
        $this->isOpen = true;
    }

    public function hideModal(){
        $this->isOpen = false;
    }

    public function store(){


        $types = Type::all();

        $this->validate(
                [
                    'mobil' => 'required',
                    'type' => 'required',
                    'harga' => 'required',
                ]
            );

            Mobil::updateOrCreate(['id' => $this->mobilId], [
                'mobil' => $this->mobil,
                'type' => $this->type,
                'harga' => $this->harga,
            ]);

            $this->hideModal();

            session()->flash('info', $this->mobilId ? 'Mobil Update Successfully' : 'Post Created Successfully');

            $this->mobilId = '';
            $this->mobil = '';
            $this->type = '';
            $this->harga = '';
    }

    public function edit($id){
        $mobils = Mobil::findOrFail($id);
        $this->mobilId = $id;
        $this->mobil = $mobil->mobil;
        $this->type = $mobil->type;
        $this->harga = $mobil->harga;

        $this->showModal();
    }

    public function delete($id){
        Mobil::find($id)->delete();
        session()->flash('delete','Mobil Deleted Successfully');
    }


}
