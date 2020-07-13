@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <h1 class="mt-3 mb-3">New post</h1>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.posts.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="titolo">Title</label>
                        <input type="text" name="title" class="form-control" id="titolo" placeholder="Give your post a title.." value="{{ old('title') }}">
                    </div>
                    <div class="form-group">
                        <label for="testo">Article</label>
                        <textarea type="text" name="content" class="form-control" id="testo" placeholder="Write something...">{{ old('content') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
