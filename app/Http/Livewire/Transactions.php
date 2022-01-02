<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class Transactions extends Component
{
    public $transactions;

    public function render()
    {
        $this->transactions = Transaction::with(['user'])->get();

        return view('livewire.transactions');
    }
}
