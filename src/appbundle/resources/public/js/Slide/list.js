$(document).on('click', '.knp-paginator a', function(e)
{
    var url = $(this).attr('href');

    updatePagination(e, url);
});

$(document).on('click', '.knp-table th', function(e)
{
    var url = $(this).find('a').attr('href');

    updatePagination(e, url);
});

$('.bs-pagination-search').submit(function(e)
{
    var url = $(this).attr('action');

    var field = $(this).attr("data-field");
    if (typeof field == 'undefined') field = 'name';

    // replace current username parameter
    url = url.replace('/([?|&]' + field + '=.*)&*/', '');

    url += (url.indexOf('?') != -1 ? '&' : '?') + field + '=' + $(this).find('input[name="' + field + '"]').val();

    updatePagination(e, url);
});

function updatePagination(e, url)
{
    e.preventDefault();

    var el = $('.bs-pagination-element');

    el.wrap('<div style="position: relative; opacity: 0.5"></div>');
    el.parent().append('<div class="spinner-container"><i class="fa fa-refresh fa-spin"></i></div>');

    $.get(url, function(data)
    {
        el.html(data);

        el.parent().find('.spinner-container').remove();
        el.unwrap();

        window.history.pushState({}, '', 'users' + url.substr(url.lastIndexOf('?')));
    });
}
