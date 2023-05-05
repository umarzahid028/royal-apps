@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Name: {{Auth::user()->name}}</li>
                        <li class="list-group-item">Email: {{Auth::user()->email}} </li>
                        <li class="list-group-item">Gender: {{Auth::user()->gender}}</li>
                        <li class="list-group-item">Expires At:{{Auth::user()->expires_at}}</li>
                        <li class="list-group-item">Active: {{Auth::user()->active}}</li>
                      </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
