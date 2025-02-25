<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProducts extends Component
{
    use WithPagination;

    public bool $myModal1 = false;

    public function delete($slug)
    {
        $product = Product::where('slug', $slug)->first();

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
        $products = Product::with('category')->paginate(10);

        return view('livewire.products.show-products', [
            'products' => $products,
        ]);
    }
}
