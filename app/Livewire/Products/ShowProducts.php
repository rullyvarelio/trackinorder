<?php

namespace App\Livewire\Products;

use App\Models\Products;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

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
        $products = Products::with('category')->paginate(5);

        $headers = [
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'category.name', 'label' => 'Category'],
            ['key' => 'price', 'label' => 'Price', 'format' => ['currency', '2,.', '$ ']],
            ['key' => 'stock', 'label' => 'Stock'],
            ['key' => 'status', 'label' => 'Status'],
            ['key' => 'action', 'label' => 'Action'],
        ];

        return view('livewire.products.show-products', [
            'products' => $products,
            'headers' => $headers,
        ]);
    }
}
