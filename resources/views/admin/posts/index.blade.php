@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mt-3 mb-3">Post list</h1>
                    <a class="btn btn-primary"
                    href="{{ route('admin.posts.create') }}">
                        New post
                    </a>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Category</th>
                            <th>Tags</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->slug }}</td>
                                <td>
                                    {{ $post->category->name ?? '-' }}
                                    {{-- @if( $post->category)
                                        {{ $post->category->name }}
                                    @else
                                        -
                                    @endif --}}
                                </td>
                                <td>
                                    @forelse ($post->tags as $tag)
                                        {{ $tag->name }} {{$loop->last ? '' : ', '}}
                                    @empty
                                        -
                                    @endforelse
                                </td>
                                <td>
                                    <a class="btn btn-small btn-info"
                                    href="{{ route('admin.posts.show', ['post' => $post->id]) }}">
                                        Detail
                                    </a>
                                    <a class="btn btn-small btn-warning" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">
                                        Change
                                    </a>
                                    <form class="d-inline" action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-small btn-danger" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    There are no posts
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
