@extends('layouts.app', ['page' => __('User Management'), 'pageSlug' => 'roles'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Role Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('roles.update', $role) }}" autocomplete="off">
                            @csrf
                            @method('put')
                            <h6 class="heading-small text-muted mb-4">{{ __('Role information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', $role->name) }}" required autofocus>
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                                <div class="form-group{{ $errors->has('slug') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="slug">{{ __('Slug') }}</label>
                                    <input type="text" name="slug" id="slug" class="form-control form-control-alternative{{ $errors->has('slug') ? ' is-invalid' : '' }}" placeholder="{{ __('slug') }}" value="{{ old('slug', $role->slug) }}" required>
                                    @include('alerts.feedback', ['field' => 'slug'])
                                </div>
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="description">{{ __('Description') }}</label>
                                    <input type="text" name="description" id="description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('description') }}" value="{{ old('description', $role->description) }}" required>
                                    @include('alerts.feedback', ['field' => 'description'])
                                </div>
                                <div class = "col-2" style="padding-left:0px;">
                                <div class="form-group{{ $errors->has('level') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Level') }}</label>
                                    <select id="level" name='level' class="form-control" >
                                        <option @if($role->level == 1) selected @endif>1</option>
                                        <option @if($role->level == 2) selected @endif>2</option>
                                        <option @if($role->level == 3) selected @endif>3</option>
                                        <option @if($role->level == 4) selected @endif>4</option>
                                        <option @if($role->level == 5) selected @endif>5</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'level'])
                                </div>
                            </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
