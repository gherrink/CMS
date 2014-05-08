function cmsAjax(url)
{
	$.ajax({
		type: 'POST',
		url: url,
		success: function(data, textStatus, jqXHR){
			if('success' in data)
				window.location = data['success'];
		},
		error: function(jqXHR, textStatus, errorThrown) {
			cmsShowErrorModal('modalmsg', jqXHR, textStatus, errorThrown);
		},
			
		dataType:'json'
	});
}

function cmsSubmitForm(modelid, formid, url)
{
	var post = $('#'+formid).serialize();
	
	$.ajax({
		type: 'POST',
		url: url,
		data: post,
		success: function(data, textStatus, jqXHR){
			if('header' in data && 'body' in data && 'footer' in data)
				cmsShowModal(modelid, data['header'], data['body'], data['footer']);
			else
				window.location = data['success'];
				
		},
		error: function(jqXHR, textStatus, errorThrown) {
			cmsShowErrorModal(modelid, jqXHR, textStatus, errorThrown);
		},
			
		dataType:'json'
	});
}

function cmsUpdateModalAjax(id, url)
{
	$.ajax({
		type: 'POST',
		url: url,
		data: post,
	
		success:function(data, textStatus, jqXHR){
			if('body' in data)
				$('#'+id+' .modal-body').html(data['body']);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			cmsShowErrorModal(id, jqXHR, textStatus, errorThrown);
		},
			
		dataType:'json'
	});
}

function cmsShowModalAjax(id, url, post)
{
	var post = post || {};
	$.ajax({
		type: 'POST',
		url: url,
		data: post,
	
		success:function(data, textStatus, jqXHR){
			if('header' in data && 'body' in data && 'footer' in data)
				cmsShowModal(id, data['header'], data['body'], data['footer']);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			cmsShowErrorModal(id, jqXHR, textStatus, errorThrown);
		},
			
		dataType:'json'
	});
}

function cmsShowErrorModal(id, jqXHR, textStatus, errorThrown)
{
	cmsShowModal(id, errorThrown, jqXHR.responseText, '<button class="btn btn-default" onclick="$(\'#'+id+'\').modal(\'hide\');" type="button">OK</button>');
}

function cmsShowModal(id, header, body, footer)
{
	$('#'+id+' .modal-header').html('<h3>'+header+'</h3>');
	$('#'+id+' .modal-body').html(body);
	$('#'+id+' .modal-footer').html(footer);
	$('#'+id).modal('show');
}