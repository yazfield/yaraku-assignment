<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" 
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ trans('global.confirm_delete_title') }}</h5>
        <button type="button" class="close" data-dismiss="modal" 
          aria-label="{{ trans('global.close') }}">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="confirm_delete_form" method="POST" 
          action="{{ $action }}">
          <input name="_method" type="hidden" value="DELETE">
          <p>{{ trans('global.confirm_delete_text', 
            ['item' => 'this book from your list']) }}</p>
          {{ csrf_field() }}
          <input type="hidden" name="id" value="">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          {{ trans('global.close') }}
        </button>
        <button type="submit" class="btn btn-danger" form="confirm_delete_form">
          {{ trans('global.delete') }}
        </button>
      </div>
    </div>
  </div>
</div>