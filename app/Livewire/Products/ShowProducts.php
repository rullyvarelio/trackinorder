<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ShowProducts extends Component
{
    use Toast, WithPagination;

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
            title: 'Produc successfully deleted!',
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
        $products = Product::search($this->searchProducts)
            ->paginate(10);

        return view('livewire.products.show-products', [
            'products' => $products,
        ]);
    }
}
