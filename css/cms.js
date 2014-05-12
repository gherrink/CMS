function cmsAjax(url)
{
	$.ajax({
		type: 'POST',
		url: url,
		success: function(data, textStatus, jqXHR){
			cmsActions(data);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			cmsShowErrorModal('modalmsg', jqXHR, textStatus, errorThrown);
		},
			
		dataType:'json'
	});
}

function cmsActions(data)
{
	if('success' in data)
		window.location = data['success'];
	
	cmsActionExecute(data);
	
	if('eval' in data)
		for (index = 0; index < data['eval'].length; ++index)
			eval(data['eval'][index]);
	
	if('aloha' in data)
		Aloha.jQuery('.edit').aloha();
}

function cmsActionExecute(data)
{
	if('remove' in data)
	{
		$(data['remove']).remove();
	}
	
	if('html' in data)
	{
		if('replace' in data)
			$(data['replace']).replaceWith(data['html']);
		if('before' in data)
			$(data['before']).before(data['html']);
		if('after' in data)
			$(data['after']).after(data['html']);
	}
	else if('after' in data)
	{
		var selectors = data['after'].split('***');
		$(selectors[0]).after($(selectors[1]));
	}
	else if('before' in data)
	{
		var selectors = data['before'].split('***');
		$(selectors[0]).before($(selectors[1]));
	}
	
	if('disable' in data)
	{
		$(data['disable']).attr('disabled', 'disabled');
		$(data['disable']).addClass('disabled');
	}
	
	if('enable' in data)
	{
		$(data['enable']).removeAttr('disabled');
		$(data['enable']).removeClass('disabled');
	}
	
	if('modalhide' in data)
		$('#'+data['modalhide']).modal('hide');
}


function cmsSubmitForm(modelid, formid, url)
{
	var form = $('#'+formid);
	form.find(':disabled').each(function() {
        $(this).removeAttr('disabled');
    });
	
	var post = form.serialize();
	
	$.ajax({
		type: 'POST',
		url: url,
		data: post,
		success: function(data, textStatus, jqXHR){
			if('header' in data && 'body' in data && 'footer' in data)
				cmsShowModal(modelid, data['header'], data['body'], data['footer']);
			else
				cmsActions(data);
				
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

function cmsGetSelectedRow(view, attrid)
{
	var view = view || 'view-table';
	var attrid = attrid || 'id';
	return $('#'+view+' .selected').attr(attrid);
}