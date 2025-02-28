<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class EditProducts extends Component
{
    use Toast, WithFileUploads;

    public $slug;

    public $name;

    public $category_id;

    public $price;

    public $stock;

    public $status;

    public $image;

    public $oldImage;

    public function mount($slug)
    {
        $this->slug = $slug;

        $product = Product::where('slug', $slug)->first();

        if (! $product) {
            abort(404);
        }

        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->status = $product->status;
        $this->oldImage = $product->image;
    }

    public function update()
    {

        if ($this->stock > 0) {
            $this->status = 'available';
        } else {
            $this->status = 'out of stock';
        }

        $validated = $this->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'status' => 'required',
            'image' => 'nullable|image',
        ]);

        $product = Product::where('slug', $this->slug)->firstOrFail();

        if ($this->image) {
            $path = $this->image->store('product_images');
            $validated['image'] = $path;

            if ($this->oldImage) {
                Storage::delete($this->oldImage);
            }
        } else {
            $validated['image'] = $this->oldImage;
        }

        $product->update($validated);

        $this->success(
            title: 'Product successfully updated!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-success',
            timeout: 3000,
            redirectTo: route('products.index')
        );
    }

    public function render()
    {
        $product = Product::where('slug', $this->slug)->first();

        return view('livewire.products.edit-products', ['product' => $product]);
    }
}
