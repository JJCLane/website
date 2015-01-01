$(document).ready(function()
{

	$('div.docs-toc').on('click', function()
	{
		$(this).next('ul').toggle();
	});
});