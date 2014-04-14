function showModalAjax(id, url)
{
	$.ajax({
		type: 'POST',
		url: url,
	
		success:function(data, textStatus, jqXHR){
			data = JSON.parse(data);
			if('header' in data && 'body' in data && 'footer' in data)
				showModal(id, data['header'], data['body'], data['footer']);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			showErrorModal(id, jqXHR, textStatus, errorThrown);
		},
			
		dataType:'html'
	});
}

function showErrorModal(id, jqXHR, textStatus, errorThrown)
{
	showModal(id, errorThrown, jqXHR.responseText, '<button class="btn btn-default" data-dismiss="'+id+'" type="button">OKs</button>');
}

function showModal(id, header, body, footer)
{
	$('#'+id+' .modal-header').html('<h3>'+header+'</h3>');
	$('#'+id+' .modal-body').html(body);
	$('#'+id+' .modal-footer').html(footer);
	$('#'+id).modal('show');
}