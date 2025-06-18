<?php

namespace App\Livewire;

use Livewire\Component;
use App\Http\Controllers\Shopping;

class ShoppingSummary extends Component
{
    public $budget = 20;
    public $total;
    public $difference;
    public $differenceOver;

    public function mount() {
        $shopping = new Shopping;
        $this->total = $shopping->total();
        $this->difference = $shopping->difference($this->budget);

        if($this->difference < 0) {
            $this->differenceOver = abs($this->difference);
            $this->differenceOver = number_format($this->differenceOver, 2);
        }
    }

    public function render()
    {
        return view('livewire.shopping-summary');
    }
}
