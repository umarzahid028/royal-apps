@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form action="{{route('store.book')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Author</label>
                                <select class="form-control" name="author">
                                    @foreach ($authors as $author)
                                    <option value="{{$author->id}}">{{$author->first_name ." ". $author->last_name}} ({{$author->id}})</option>
                                    @endforeach  
                                  </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Title</label>
                                <input type="text" class="form-control" placeholder="title" name="title">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Release Date</label>
                                <input type="date" class="form-control" name="release_date">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
