@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Product</h2>
        <a href="{{ route('admin.products.index') }}"
            class="border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
            Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                @foreach ($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-24 h-24 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="image" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled>Choose Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active"
                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-gray-700">Active</label>
            </div>

            {{-- Variant Section --}}
            <div x-data="productForm({{ $product->variants }})">
                <div class="flex items-center justify-between mb-3">
                    <label class="text-sm font-medium text-gray-700">Variants</label>
                    <button type="button" @click="addVariant()"
                        class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 transition text-sm">
                        + Add Variant
                    </button>
                </div>
                <template x-for="(variant, index) in variants" :key="index">
                    <div class="flex gap-3 mb-2 items-center">
                        <input type="text" :name="'variants[' + index + '][size]'" :value="variant.size"
                            placeholder="Size (S/M/L)"
                            class="border border-gray-300 rounded-lg px-3 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="number" :name="'variants[' + index + '][price]'" :value="variant.price"
                            placeholder="Price"
                            class="border border-gray-300 rounded-lg px-3 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="button" @click="removeVariant(index)"
                            class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition text-sm">
                            Remove
                        </button>
                    </div>
                </template>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Update
            </button>
        </form>
    </div>

@endsection
