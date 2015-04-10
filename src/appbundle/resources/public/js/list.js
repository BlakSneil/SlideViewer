$(document).on('click', '.knp-paginator a', function(e)
{
    var url = $(this).attr('href');

    updateListAndPaginator(e, url)
});

$(document).on('click', '.knp-table th', function(e)
{
    var url = $(this).find('a').attr('href');

    updateListAndPaginator(e, url);
});

$('#search-by-name-form').submit(function(e)
{
    var url = $(this).attr('action');

    // replace current name parameter
    url = url.replace(/([?|&]name=.*)&*/, '');

    url += (url.indexOf('?') != -1 ? '&' : '?') + 'name=' + $(this).find('input[name="name"]').val();

    updateListAndPaginator(e, url)
});

function updateListAndPaginator(e, url)
{
    e.preventDefault();

    var el = $('.knp-list-content');

    el.wrap('<div style="position: relative; opacity: 0.5"></div>');
    el.parent().append('<div class="spinner-container"><i class="fa fa-refresh fa-spin"></i></div>');

    $.get(url, function(data)
    {
        el.html(data);

        el.parent().find('.spinner-container').remove();
        el.unwrap();

        window.history.pushState({}, '', 'slides' + url.substr(url.lastIndexOf('?')));
    });
}
