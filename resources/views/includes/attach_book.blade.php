<div class="modal fade" id="attachBookModal" tabindex="-1" role="dialog" 
  aria-labelledby="attachBookLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ trans('book_lists.add_new') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('global.close') }}">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#existing_book"
            role="tab" aria-controls="existing_book" id="existing_book_tab"
            aria-selected="true">Existing book</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#non_existing_book"
            role="tab" aria-controls="non_existing_book" id="non_existing_book_tab"
            aria-selected="false">New book</a>
        </li>
      </ul>
      <div class="tab-content pt-3">
        <div class="tab-pane fade show active" id="existing_book" role="tabpanel" 
          aria-labelledby="existing_book_tab">
          <div class="modal-body">
            <form id="attach_book_form" class="typeahead" role="search" method="POST"
              action="{{ route('attach_book', ['slug' => $bookList->slug]) }}">
              <input type="hidden" name="book_list_slug" id="search_book_list_slug" 
                value="{{ $bookList->slug}}">
              <input type="hidden" name="book_slug" id="search_book_slug">
              <div class="form-group required">
                <label class="block control-label" for="book_search_input">{{ trans('book_lists.book_title') }}:</label>
                <input id="book_search_input" type="search" name="title" class="form-control search-input" 
                  placeholder="{{ trans('global.search') }}" autocomplete="off" maxLength="50">
              </div>
              {{ csrf_field() }}
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              {{ trans('global.close') }}
            </button>
            <button type="submit" disabled id="attach_book_submit" class="btn btn-primary"
              form="attach_book_form">
              {{ trans('global.add_new') }}
            </button>
          </div>
        </div>
        <div class="tab-pane fade" id="non_existing_book" role="tabpanel"
          aria-labelledby="non_existing_book_tab">
          <div class="modal-body">
            <form id="attach_new_book_form" method="POST" 
              action="{{ route('attach_nonexisting_book', ['slug' => $bookList->slug]) }}">
              {{ csrf_field() }}
              <input type="hidden" name="book_list_slug" value="{{ $bookList->slug}}">
              <input type="hidden" name="author_id" id="search_author_id">
              <div class="form-group required">
                <label class="control-label" for="book_input">{{ trans('book_lists.book_title') }}:</label>
                <input id="book_input" type="text" name="title" class="form-control" 
                   maxLength="50">
              </div>
              <div class="form-group required">
                <label class="block control-label" for="autor_search_input">{{ trans('book_lists.author') }}:</label>
                <input id="author_search_input" type="search" name="author" class="form-control search-input" 
                  placeholder="{{ trans('global.search') }}" autocomplete="off" maxLength="100">
                <div class="collapse multi-collapse" id="full_author_collapse">
                  <div class="form-group required">
                    <label class="block control-label" for="attach_author_last_name">{{ trans('global.last_name') }}:</label>
                    <input id="attach_author_last_name" type="text" name="last_name" 
                      class="form-control search-input" maxLength="50">
                  </div>
                  <div class="form-group required">
                    <label class="block control-label" for="attach_author_first_name">{{ trans('global.first_name') }}:</label>
                    <input id="attach_author_first_name" type="text" name="first_name" 
                      class="form-control search-input" maxLength="50">
                  </div>
                </div>
                
                <a id="add_new_author_btn" data-toggle="collapse" href="#full_author_collapse" 
                  aria-expanded="false" aria-controls="full_author_collapse">This author doesn't exist?</a>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              {{ trans('global.close') }}
            </button>
            <button type="submit" disabled id="attach_new_book_submit" class="btn btn-primary"
              form="attach_new_book_form">
              {{ trans('global.add_new') }}
            </button>
          </div>
        </div>
      
      </div>
    </div>
  </div>
</div>