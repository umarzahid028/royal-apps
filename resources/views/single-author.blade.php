@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> <a  class="text-decoration-none" href="{{route('api.authors')}}">{{ __('Authors') }}</a> / {{ __('Books') }}
                    @if (count($books_data) == 0 )
                    <a href="{{route('api.delete.author', $author_id)}}" style="float: right;" class="btn btn-danger">Delete Author</a>
                    @endif                    
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Release Date</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        @if (count($books_data) > 0 )
                        <tbody>
                            @foreach ($books_data AS $book)
                                <tr>
                                    <td>{{$book->id}}</td>
                                    <td>{{$book->title}}</td>
                                    <td>{{Carbon\Carbon::parse($book->release_date)->format('d/m/Y')}}</td>
                                    <td>
                                        <a href="{{route('api.book.delete', $book->id)}}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @else
                            <tr>
                                <p>Data found</p>
                            </tr>
                        @endif
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
