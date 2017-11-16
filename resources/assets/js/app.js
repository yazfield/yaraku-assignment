import {makeBloodhound, makeTypeahead} from './bootstrap';
import {booksConfig, authorsConfig, canSubmit} from './bootstrap';

const booksEngine = makeBloodhound(booksConfig);
const authorsEngine = makeBloodhound(authorsConfig);

// set the delete form's hidden id input
$('a.detach-book').click(function () {
  $('#confirmDelete input[name="id"]').val($(this).data('id'));
});

// disable submit and reset hidden input
$('#book_search_input').on('keyup', function () {
  $('#attach_book_submit').attr('disabled', true);
  $('#search_book_slug').val('');
});

// typeahead suggestions for books
makeTypeahead(booksEngine, "#book_search_input", booksConfig)
  .on('typeahead:selected', (e, book) => {
    // enables submit and sets slug on the hidden input
    $('#attach_book_submit').attr('disabled', false);
    $('#search_book_slug').val(book.slug);
  });

$('#author_search_input').on('keyup', function () {
  $('#attach_new_book_submit').attr('disabled', true);
  $('#search_author_id').val('');
});

// typeahead suggestions for authors
makeTypeahead(authorsEngine, "#author_search_input", authorsConfig)
  .on('typeahead:selected', (e, author) => {
    // enables submit and sets id on the hidden input
    $('#search_author_id').val(author.id);
    validateAttachNewBookForm();
  });

// shows a form for creating inexisting authors
$('#full_author_collapse').on('shown.bs.collapse', function () {
  // destroys typeahead and reset hidden input
  $('#author_search_input').typeahead('destroy');
  $('#author_search_input').hide(500).siblings('label').hide(500);
  $('#add_new_author_btn').text('Actually, that author exists');
  $('#search_author_id').val('');
}).on('hidden.bs.collapse', function () {
  $('#add_new_author_btn').text("This author doesn't exist?");
  $('#author_search_input').show(500).siblings('label').show(500);
  validateAttachNewBookForm();
  makeTypeahead(authorsEngine, "#author_search_input", authorsConfig)
  .on('typeahead:selected', (e, author) => {
    // resets typehead
    $('#search_author_id').val(author.id);
    validateAttachNewBookForm();
  });
});

$('#attach_author_last_name').on('keyup', function () {
  validateAttachNewBookForm();
  $('#search_author_id').val('');
});
$('#attach_author_first_name').on('keyup', function () {
  validateAttachNewBookForm();
  $('#search_author_id').val('');
});
$('#book_input').on('keyup', function () {
  validateAttachNewBookForm();
});

function validateAttachNewBookForm() {
  let result = $('#book_input').val() && (
    ($('#attach_author_last_name').val() && $('#attach_author_first_name').val()) 
    || $('#search_author_id').val());
  $('#attach_new_book_submit').attr('disabled', !result);
}
