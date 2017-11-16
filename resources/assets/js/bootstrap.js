export function makeBloodhound({endpoint, query, parameters}) {
    let url = `${endpoint}?${query}=%QUERY%`;
    parameters.forEach(function(element) {
      url += `&${element['key']}=${element['value']}`;
    });
  
    return new Bloodhound({
      remote: {
          url: url,
          wildcard: '%QUERY%'
      },
      datumTokenizer: Bloodhound.tokenizers.whitespace(query),
      queryTokenizer: Bloodhound.tokenizers.whitespace
    });
}
  
export function makeTypeahead(engine, elment, {displayKey, name, suggestion}) {
    return $(elment).typeahead({
        hint: false,
        highlight: true,
        minLength: 1
    }, {
        source: engine.ttAdapter(),
        name: name,
        displayKey: displayKey,
        templates: {
        empty: [
            '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
        ],
        header: [
            '<div class="list-group search-results-dropdown">'
        ],
        suggestion: suggestion
        }
    });
}

export const booksConfig = {
    endpoint: '/api/books/',
    query: 'title',
    parameters: [
        {'key': 'book_list_slug', 'value': $('#search_book_list_slug').val()}
    ], 
    displayKey: 'title',
    name: 'booksList',
    suggestion: function (data) {
        return '<div data-slug="' + data.slug + '" class="list-group-item">' + data.title + ' - ' 
        + data.author_first_name + ' ' + data.author_last_name + '</a>'
    }
}
  
export const authorsConfig = {
    endpoint: '/api/authors/',
    query: 'full_name',
    parameters: [], 
    displayKey: 'full_name',
    name: 'authorsList',
    suggestion: function (data) {
        return '<div class="list-group-item">' + data.full_name + '</a>'
    }
}