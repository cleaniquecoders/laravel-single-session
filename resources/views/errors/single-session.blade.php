@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Unauthorized') }}</div>

                <div class="card-body">
                    <p>
                    	{{ __('You already logged in on other device.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
