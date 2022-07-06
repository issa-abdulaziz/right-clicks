@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center mt-5">
            <div class="col-sm-10 col-md-8 col-lg-6">
                <div class="card rounded shadow-sm">
                    <div class="card-header">{{ __('Update Profile') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user-profile-information.update') }}">
                            @method('PUT')
                            @csrf

                            @if (session('status') === 'profile-information-updated')
                                <div class="alert alert-success" role="alert">
                                    {{ __('Your profile has been updated.') }}
                                </div>
                            @endif
                            <div class="row mb-3">
                                <label for="name" class="col-12 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-12">
                                    <input id="name" type="text"
                                        class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror" name="name"
                                        value="{{ old('name') ?? auth()->user()->name }}" required autocomplete="name"
                                        autofocus>

                                    @error('name','updateProfileInformation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-12 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-12">
                                    <input id="email" type="email"
                                        class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror" name="email"
                                        value="{{ old('email') ?? auth()->user()->email }}" required autocomplete="email">

                                    @error('email', 'updateProfileInformation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center mb-0">
                                <button type="submit" class="btn btn-primary btn-block mx-3">
                                    {{ __('Update Profile') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
