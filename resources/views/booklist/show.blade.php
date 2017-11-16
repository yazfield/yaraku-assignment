@extends('layouts.app')

@section('main-heading')
<h2 class="mb-4">{{ $bookList->name }} </h2>
@endsection
@section('content')
  <div>
  <form class="form-inline mb-4 float-left" method="GET">
    <label class="sr-only" for="search_title">{{ trans("book_lists.title") }}</label>
    <input name="title" type="text" class="form-control mb-2 mr-sm-2 mb-sm-0 form-control-sm" 
      id="search_title" placeholder="{{ trans("book_lists.title") }}" 
      value="{{ request("title") }}" maxLength="50">

    <label class="sr-only" for="search_full_name">{{ trans("book_lists.full_name") }}</label>
    <input name="full_name" type="text" class="form-control mb-2 mr-sm-2 mb-sm-0 form-control-sm" 
      id="search_full_name" placeholder="{{ trans("book_lists.full_name") }}"
      value="{{ request("full_name") }}" maxLength="50">

    <button type="submit" class="btn btn-sm btn-primary">{{ trans("global.search") }}</button>
  </form>
  <a class="btn btn-sm btn-success float-right" 
    data-toggle="modal" href="#attachBookModal">
    {{ trans("book_lists.add_book") }}
  </a>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">{!! generate_th_link('title') !!}</a>
        </th>
        <th scope="col">{!! generate_th_link('full_name') !!}</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $paginatedBooks as $book)
      <tr>
        <td>{{ $book->title }}</td>
        <td>{{ $book->author->full_name }}</td>
        <td>
          <a class="btn btn-sm btn-danger detach-book" 
            data-toggle="modal" href="#confirmDelete"
            data-id="{{ $book->slug }}">
            <span class="oi oi-trash"></span>
          </a>
        </td>
      </tr>
      @endforeach
      @if(!$paginatedBooks->count())
      <tr>
        <td colspan="3" class="text-center"> {{ trans('book_lists.no_results') }}</td>
      </tr>
      @endif
    </tbody>
  </table>
  <div class="row">
    <div class="col offset-4">
      {{ $paginatedBooks->links('pagination::bootstrap-4') }}
    </div>
  </div>

@include('includes.attach_book', ['bookList' => $bookList])

@include('includes.confirm_delete', 
  ['action' => route('detach_book', ['slug' => $bookList->slug])])
@endsection
