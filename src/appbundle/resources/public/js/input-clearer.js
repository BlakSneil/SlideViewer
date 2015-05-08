$(document).ready(function()
{
    if (!$(".input-clearer").prev().val()) $(".input-clearer").hide();
});

$(".has-input-clearer").keyup(function ()
{
    var t = $(this);
    t.next('span').toggle(Boolean(t.val()));
});

$(".input-clearer").click(function ()
{
    $(this).prev().val('').focus();
    $(this).hide();
});