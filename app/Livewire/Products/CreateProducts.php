<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Products;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Mary\Traits\Toast;

class CreateProducts extends Component
{
    use WithFileUploads, Toast;

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
    public bool $status;

    #[Validate('image|file|nullable')]
    public $image;

    public function save()
    {
        if ($this->stock > 0) {
            $this->status = true;
        } else {
            $this->status = false;
        }

        if ($this->name) {
            $this->slug = SlugService::createSlug(Products::class, 'slug', $this->name);
        }


        $validated = $this->validate();

        if ($this->image) {
            $validated['image'] = $this->image->store('product_images');
        }

        Products::create($validated);

        $this->toast(
            type: 'success',
            title: 'Product successfully created!',
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
        return view('livewire.products.create-products');
    }
}
