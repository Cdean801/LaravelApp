@extends('layouts.app', ['page' => __('Category Managment'), 'pageSlug' => 'categories'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Categories') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">{{ __('Add Category') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Active') }}</th>
                                <th scope="col">{{ __('Parent Id') }}</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @foreach ($categorys as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <a href="#">{{ $category->slug }}</a>
                                        </td>
                                        <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-right">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        @if (auth()->user()->hasRole('admin') )
                                                            <form action="{{ route('categories.delete', $category) }}" method="post">
                                                                @csrf
                                                                @method('delete')

                                                                <a class="dropdown-item" href="{{ route('categories.edit', $category) }}">{{ __('Edit') }}</a>
                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                                            {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a class="dropdown-item" href="{{ route('categories.edit', $category) }}">{{ __('Edit') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $categorys->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection