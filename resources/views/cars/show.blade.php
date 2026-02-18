@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-3">
                <a href="{{ route('cars.index') }}" class="btn btn-sm btn-outline-secondary">
                    &larr; Back to Cars
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                @if($car->image_path)
                    <img src="{{ asset('storage/' . $car->image_path) }}" class="card-img-top" alt="{{ $car->make }} {{ $car->model }}" style="max-height: 500px; object-fit: cover; object-position: center;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 500px;">
                        <span class="text-muted">No image available</span>
                    </div>
                @endif
                <div class="card-body">
                    <h1 class="card-title mb-2">{{ $car->year }} {{ $car->make }} {{ $car->model }}</h1>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="text-muted">
                            <small>
                                Listed by <strong>{{ $car->user->name }}</strong> | 
                                {{ $car->created_at->format('F j, Y \a\t g:i a') }}
                                @if($car->created_at != $car->updated_at)
                                    <span class="ms-2">(Updated: {{ $car->updated_at->format('M d, Y') }})</span>
                                @endif
                            </small>
                        </div>
                        @can('update', $car)
                            <div>
                                <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('cars.destroy', $car) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this listing?')">Delete</button>
                                </form>
                            </div>
                        @endcan
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Price</h5>
                                    <p class="h4 text-primary mb-0">${{ number_format($car->price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Year</h5>
                                    <p class="h4 mb-0">{{ $car->year }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-text">
                        <h5>Description</h5>
                        {!! nl2br(e($car->description)) !!}
                    </div>

                    @can('update', $car)
                        <hr>
                        <div class="alert alert-info mb-0">
                            <small>You can <a href="{{ route('cars.edit', $car) }}">edit this listing</a> or <a href="{{ route('cars.index') }}">delete it</a> after the car is sold.</small>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
