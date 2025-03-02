<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowCategories extends Component
{
    use Toast;

    public $searchCategories = '';

    public function delete($id)
    {
        $category = Category::find($id);

        $category->delete();

        $this->success(
            title: 'Category successfully deleted!',
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
        return view('livewire.admin.categories.show-categories', [
            'categories' => Category::with('products')
                ->search($this->searchCategories)
                ->paginate(5),
        ]);
    }
}
