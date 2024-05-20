@extends('backend.layout.root', ['title' => 'Add Category']);
@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create Category</h2>

    <form action="{{ route('category.update', ['category' => $category]) }}" method="POST" >
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Name:</label>
            <input type="text" id="name" name="name" value="{{$category->name ?? ''}}" placeholder="Name" class="form-control">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Parent Category:</label>
            <select name="category_id" id="" class="form-control">
                <option value="">Parent Category</option>
                @foreach($categories as $cat)
                    @if($cat->id != $category->id)
                        <option value="{{$cat->id}}" {{$cat->id == $category->parent?->id ? 'selected' : ''}}>{{$cat->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Email:</label>
            <textarea name="description" id="category_description_editor" cols="30" rows="10" class="form-control">
                {{$category->description}}
            </textarea>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <script>
        CKEDITOR.replace('category_description_editor');
    </script>
@endsection
