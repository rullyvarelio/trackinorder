<?php

namespace App\Livewire;

use App\Livewire\Forms\ProductsForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Products extends Component
{

    public function render()
    {
        return view('livewire.products.index')->title('Products');
    }
    public function create()
    {
        return view('livewire.products.create');
    }
}
