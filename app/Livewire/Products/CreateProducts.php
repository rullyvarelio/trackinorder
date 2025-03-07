<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class CreateProducts extends Component
{
    use Toast, WithFileUploads;

    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $category_id;

    #[Validate('required')]
    public $slug;

    #[Validate('required|numeric')]
    public $price;

    #[Validate('required|numeric')]
    public $stock;

    #[Validate('required')]
    public $status;

    #[Validate('image|file|nullable')]
    public $image;

    public function mount()
    {
        $this->stock = 0;
        $this->status = 'out of stock';
    }

    public function save()
    {

        if ($this->name) {
            $this->slug = SlugService::createSlug(Product::class, 'slug', $this->name);
        }

        $validated = $this->validate();

        if ($this->image) {
            $validated['image'] = $this->image->store('product_images');
        }

        Product::create($validated);

        $this->success(
            title: 'Product successfully created!',
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
        return view('livewire.products.create-products');
    }
}
