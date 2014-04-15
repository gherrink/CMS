function submitForm(modelid, formid, url)
{
	var post = $('#'+formid).serialize();
	
	$.ajax({
		type: 'POST',
		url: url,
		data: post,
		success:function(data, textStatus, jqXHR){
			if('header' in data && 'body' in data && 'footer' in data)
				showModal(modelid, data['header'], data['body'], data['footer']);
			else
				window.location = data['success'];
				
		},
		error: function(jqXHR, textStatus, errorThrown) {
			showErrorModal(modelid, jqXHR, textStatus, errorThrown);
		},
			
		dataType:'json'
	});
}

function showModalAjax(id, url)
{
	$.ajax({
		type: 'POST',
		url: url,
	
		success:function(data, textStatus, jqXHR){
			if('header' in data && 'body' in data && 'footer' in data)
				showModal(id, data['header'], data['body'], data['footer']);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			showErrorModal(id, jqXHR, textStatus, errorThrown);
		},
			
		dataType:'json'
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