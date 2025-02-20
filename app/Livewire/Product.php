<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Products;
use App\Models\Categories;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Cviebrock\EloquentSluggable\Services\SlugService;

class Product extends Component

{
    use WithFileUploads;

    public $updateData = false;
    public $product_id;

    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $category_id;

    #[Validate('required')]
    public $slug;

    #[Validate('required')]
    public $price;

    #[Validate('required')]
    public $stock;

    #[Validate('required')]
    public bool $status;

    #[Validate('nullable|image')]
    public $image;

    public function store()
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
        redirect()->back()->with('success', 'Success!');
    }

    public function edit($id)
    {
        $data = Products::find($id);

        $this->name = $data->name;
        $this->category_id = $data->category_id;
        $this->price = $data->price;
        $this->stock = $data->stock;

        $this->updateData = true;
        $this->product_id = $id;
    }

    public function update()
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

        $data = Products::find($this->product_id);

        $data->update($validated);

        redirect('dashboard/products')->with('success', 'Success!');
    }

    public function delete($id)
    {
        Products::find($id)->delete();
        redirect('dashboard/products')->with('success', 'Success!');
    }

    public function render()
    {
        $products = Products::all();
        $categories = Categories::all();

        return view('livewire.product', ['products' => $products, 'categories' => $categories]);
    }
}
