<div>
    <form>
        @csrf
        <input type="text" name="name" id="name" wire:model="name">
        <select name="category_id" id="category_id" wire:model="category_id">
            @foreach ($categories as $category)
            @if (old('category_id') == $category->id)
            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
            @endif
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <input type="number" wire:model="price">
        <input type="number" wire:model="stock">
        <input type="file" wire:model="image" accept="image/*">
        @if ($updateData == false)
        <input type="submit" value="Save" wire:click="store">
        @else
        <input type="submit" value="Save" wire:click="update">
        @endif
    </form>

    <table>
        <tr>
            <th>id</th>
            <th>image</th>
            <th>name</th>
            <th>category</th>
            <th>price</th>
            <th>stock</th>
            <th>status</th>
            <th>action</th>
        </tr>
        @foreach($products as $product)
        <tr>
            <th>{{ $loop->iteration }}</th>
            <th>
                @if ($product->image)
                <img src="{{ asset('private'.$product->image) }}" alt="{{ $product->name }}'s Image" class="w-5 h-5">
                @else
                <img src="{{ asset('No_Image_Available.jpg') }}" alt="No image" class="w-5 h-5">
                @endif
            </th>
            <th>{{ $product->name }}</th>
            <th>{{ $product->category->name }}</th>
            <th>{{ $product->price }}</th>
            <th>{{ $product->stock }}</th>
            <th>{{ $product->status }}</th>
            <th>
                <button wire:click="edit({{ $product->id }})">edit</button>
                <button wire:click="delete({{ $product->id }})">delete</button>
            </th>
        </tr>
        @endforeach
    </table>
</div>