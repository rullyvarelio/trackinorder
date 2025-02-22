<?php

namespace App\Livewire\Products;

use Mary\Traits\Toast;
use Livewire\Component;
use App\Models\Products;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

class EditProducts extends Component
{
    use WithFileUploads, Toast;

    public $slug;
    public $name, $category_id, $price, $stock;
    public bool $status;
    public $image, $oldImage;

    public function mount($slug)
    {
        $this->slug = $slug;

        $product = Products::where('slug', $slug)->first();

        if (!$product) {
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
        $validated = $this->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'status' => 'required',
            'image' => 'nullable|image', // Image validation
        ]);

        $product = Products::where('slug', $this->slug)->firstOrFail();

        if ($this->stock > 0) {
            $this->status = true;
        } else {
            $this->status = false;
        }

        if ($this->image) {
            $path = $this->image->store('product_images'); // Save to storage/app/public/products
            $validated['image'] = $path;

            // Delete old image (if exists)
            if ($this->oldImage) {
                Storage::delete($this->oldImage);
            }
        } else {
            $validated['image'] = $this->oldImage; // Keep old image if new one not uploaded
        }


        $product->update($validated);


        $this->toast(
            type: 'success',
            title: 'Product successfully updated!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-info',
            timeout: 3000,
            redirectTo: route('products.index')
        );
    }


    public function render()
    {
        $product = Products::where('slug', $this->slug)->first();
        return view('livewire.products.edit-products', ['product' => $product]);
    }
}
