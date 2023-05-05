@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Authors') }}
                    <a href="{{route('add.book')}}" style="float: right;" class="btn btn-success"> add a new Book</a>

                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Birthday</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Place Of Birth</th>
                            <th scope="col">Active</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($data AS  $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->first_name}}</td>
                                    <td>{{$item->last_name}}</td>
                                    <td>{{$item->birthday}}</td>
                                    <td>{{$item->gender}}</td>
                                    <td>{{$item->place_of_birth}}</td>
                                    <td>
                                        <a href="{{route('api.single.author', $item->id)}}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
