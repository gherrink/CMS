Aloha.ready(function() {
	Aloha.require( ['aloha', 'aloha/jquery'], function( Aloha, jQuery) {
		// save all changes after leaving an editable
		Aloha.bind('aloha-editable-deactivated', function(){
			alohaSave();
		});
	});
});