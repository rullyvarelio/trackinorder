<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowProducts extends Component
{
    use Toast;

    public $searchProducts = '';

    public function delete($id)
    {
        $product = Product::find($id);

        $product->delete();

        if ($product->image) {
            Storage::delete($product->image);

            return;
        }

        $this->success(
            title: 'Product successfully deleted!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-success',
            timeout: 3000,
            redirectTo: null
        );
    }

    public function render()
    {

        return view('livewire.products.show-products', [
            'products' => Product::with('category')->paginate(10),
        ]);
    }
}
