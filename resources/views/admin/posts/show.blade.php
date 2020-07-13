@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <h1 class="mt-3 mb-3">Posts details</h1>
                </div>
                <p>
                    <strong>Title:</strong>
                    {{ $post->title }}
                </p>
                <p>
                    <strong>Content:</strong>
                    {{ $post->content }}
                </p>
                <p>
                    <strong>Slug: </strong>
                    {{ $post->slug }}
                </p>
                <p>
                    <strong>Created at: </strong>
                    {{ $post->created_at }}
                </p>
                <p>
                    <strong>Updated il: </strong>
                    {{ $post->updated_at }}
                </p>
            </div>
        </div>
    </div>
@endsection
