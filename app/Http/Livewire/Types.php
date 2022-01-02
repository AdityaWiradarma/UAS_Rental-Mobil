<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Type;
use Livewire\WithPagination;

class types extends Component
{
    use WithPagination;

    //public $types;
    public $search;
    public $isOpen = 0;
    public $typeId, $type, $kualitas;
    public $confirmingTypeDeletion = false;
    public function render()
    {
        $searchParams = '%'.$this->search.'%';
        //$this->types = type::all();
        return view('livewire.types',[
            'types' => Type::where('type','like', $searchParams)->latest()
                            ->orWhere('kualitas', 'like', $searchParams)->latest()->paginate(5)
        ]);
    }

    public function showModal(){
        $this->isOpen = true;
    }

    public function hideModal(){
        $this->isOpen = false;
    }

    public function store(){
        $this->validate(
                [
                    'type' => 'required',
                    'kualitas' => 'required',
                ]
            );

            Type::updateOrCreate(['id' => $this->typeId], [
                'type' => $this->type,
                'kualitas' => $this->kualitas,
            ]);

            $this->hideModal();

            session()->flash('types', $this->typeId ? 'type Update Successfully' : 'type Created Successfully');

            $this->typeId = '';
            $this->type = '';
            $this->kualitas = '';
    }

    public function edit($id){
        $type = Type::findOrFail($id);
        $this->typeId = $id;
        $this->type = $type->type;
        $this->kualitas = $type->kualitas;


        $this->showModal();
    }

    public function delete($id){
        Type::find($id)->delete();
        $this-> confirmingTypeDeletion = false;
        session()->flash('delete','type Deleted Successfully');
    }

    public function confirmTypeDeletion($id){
        $this-> confirmingTypeDeletion = $id;
    }

}
