<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Mary\Traits\Toast;

class EditCategories extends Component
{
    use Toast;

    public $slug;

    public $name;

    public function mount($slug)
    {
        $this->slug = $slug;

        $category = Category::where('slug', $slug)->first();

        if (! $category) {
            abort(404);
        }

        $this->name = $category->name;
    }

    public function update()
    {

        $validated = $this->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        $category = Category::where('slug', $this->slug)->firstOrFail();

        $category->update($validated);

        $this->success(
            title: 'Category successfully updated!',
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
        return view('livewire.admin.categories.edit-categories');
    }
}
