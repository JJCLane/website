$(document).ready(function()
{
	$('pre code, code').each(function(i, block) {
	    hljs.highlightBlock(block);
	});
	$('div.docs-toc').on('click', function()
	{
		$(this).next('ul').toggle();
	});
});