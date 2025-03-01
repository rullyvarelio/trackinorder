<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateCategories extends Component
{
    use Toast;

    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $slug;

    public function save()
    {

        if ($this->name) {
            $this->slug = SlugService::createSlug(Category::class, 'slug', $this->name);
        }

        $validated = $this->validate();

        Category::create($validated);

        $this->success(
            title: 'Category successfully created!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-success',
            timeout: 3000,
            redirectTo: route('categories.index')
        );
    }

    public function render()
    {
        return view('livewire.admin.categories.create-categories');
    }
}
