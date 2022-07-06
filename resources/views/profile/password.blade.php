@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center mt-5">
            <div class="col-sm-10 col-md-8 col-lg-6">
                <div class="card rounded shadow-sm">
                    <div class="card-header">{{ __('Change Password') }}</div>

                    <div class="card-body">
                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success" role="alert">
                                {{ __('Your password has been updated.') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('user-password.update') }}">
                            @method('put')
                            @csrf

                            <div class="row mb-3">
                                <label for="current_password"
                                    class="col-12 col-form-label text-md-end">{{ __('Old Password') }}</label>

                                <div class="col-12">
                                    <input id="current_password" type="password"
                                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                        name="current_password" required>

                                    @error('current_password', 'updatePassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-12 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-12">
                                    <input id="password" type="password"
                                        class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                        name="password" required autocomplete="new-password">

                                    @error('password', 'updatePassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-12 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-12">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row justify-content-center mb-0">
                                <button type="submit" class="btn btn-primary btn-block mx-3 mt-3">
                                    {{ __('Change Password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
