@extends('layouts.app')
@section('main-heading')
<h2 class="mb-4">{{ trans('global.book_lists_header') }}</h2>
@endsection
@section('content')
<div class="row">
  @foreach($bookLists as $bookList)
  <div class="col-4 mb-3">
    <div class="card card__book-list">
      <a href="{{ route('book_list', ['slug' => $bookList->slug]) }}" class="card-wrapper"
        title="{{ $bookList->name }}">
        <div class="card-body">
          <h4 class="card-title text-center mb-0">
            {{ $bookList->name }}
          </h4>
        </div>
      </a>
    </div>
  </div>
  @endforeach
  <div class="col-4 mb-3">
    <div class="card card__book-list">
      <a class="card-wrapper" title="{{ trans('global.add_new') }}"
        data-toggle="modal" href="#addBookList">
        <div class="card-body">
          <h4 class="card-title text-center mb-0">
            <p></p>
            <span class="oi oi-plus"></span>
          </h4>
        </div>
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col offset-4">
    {{ $bookLists->links('pagination::bootstrap-4') }}
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addBookList" tabindex="-1" role="dialog" 
  aria-labelledby="addBookListLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBookList">{{ trans('book_lists.add_new') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('global.close') }}">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="add_book_list_form" method="post" action="{{ route('add_book_list') }}">
          <div class="form-group required">
            <label class="control-label" for="book_list_name">{{ trans('book_lists.name') }}</label>
            <input type="text" class="form-control" id="book_list_name" name="name"
              required minlength="1" maxlength="50" aria-describedby="book_list_name_help" 
              placeholder="{{ trans('book_lists.name_placeholder') }}" >
          </div>
          {{ csrf_field() }}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          {{ trans('global.close') }}
        </button>
        <button type="submit" class="btn btn-primary" form="add_book_list_form">
          {{ trans('global.add_new') }}
        </button>
      </div>
    </div>
  </div>
</div>
@endsection
