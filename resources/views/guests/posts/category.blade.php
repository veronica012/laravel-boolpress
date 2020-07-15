@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1>Category posts: {{ $category->name }}</h1>
            <ul>
                @foreach ($posts as $post)
                <li>
                    <a href="{{ route('posts.show', ['slug' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
