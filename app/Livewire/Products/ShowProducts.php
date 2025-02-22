<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Products;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ShowProducts extends Component
{
    public bool $myModal1 = false;

    use WithPagination;
    public function delete($id)
    {
        $product = Products::where('id', $id)->first();

        if ($product) {
            if ($product->image) {
                Storage::delete($product->image);
            }

            $product->delete();
            session()->flash('success', 'Product deleted successfully!');
        } else {
            session()->flash('error', 'Product not found!');
        }
    }

    public function render()
    {
        return view('livewire.products.show-products');
    }
}
