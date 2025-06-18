<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate; 
use App\Http\Controllers\Shopping;

class ShoppingList extends Component
{
    public $itemsList = [];
    public $itemsComplete = [];
    public $itemsCount;
    public $itemsListCount;
    public $itemsCompleteCount;

    #[Validate('required', message: 'This field is required')] 
    public $name = '';

    #[Validate('required', message: 'This field is required')]
    #[Validate('numeric', message: 'Must be a valid number')]
    public $price = '';

    public $budget = 20.00;
    public $total;
    public $difference;
    public $differenceOver;

    public $order = 1;

    public function mount() {
        $this->data();
    }

    public function data() {
        $shopping = new Shopping;
        $this->itemsList = $shopping->listItems();
        $this->itemsComplete = $shopping->listComplete();
        $this->itemsCount = $shopping->count();
        $this->itemsListCount = $shopping->countItems();
        $this->itemsCompleteCount = $shopping->countComplete();

        $this->total = $shopping->total();
        $this->difference = $shopping->difference($this->budget);

        if($this->difference < 0) {
            $this->differenceOver = abs($this->difference);
            $this->differenceOver = number_format($this->differenceOver, 2);
        }

        $this->setOrder();
    }

    public function setOrder() {
        $i = 0;
        foreach ($this->itemsList as $item) { $i++;
            if($i == $this->itemsListCount) $this->order = ($item->order + 1);
        }
    }

    public function add() {

        $this->validate(); 

        Shopping::add($this->order, $this->name, $this->price);
        $this->data();

        $this->name = '';
        $this->price = '';
    }

    public function complete($id) {
        Shopping::complete($id);
        $this->data();
    }

    public function delete($id) {
        Shopping::delete($id);
        $this->data();
    }

    public function render()
    {
        return view('livewire.shopping-list');
    }
}
