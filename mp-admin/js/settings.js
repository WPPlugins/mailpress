// settings

var mp_settings = {
	
	init : function() {
		jQuery('#settings-tabs').tabs({
			active : MP_AdminPage_var.the_tab,

			create : function( event, ui){
				jQuery("[href='#tab-panel-" + MP_AdminPage_var.the_tab_name + "']").click();
			},


			activate : function( event, ui){
				jQuery("[href='#tab-panel-" + ui.newPanel.attr('data-tab') + "']").click();
			}
		});

		//general

		// test
		jQuery('#theme').change( function() {
			var a = jQuery(this); 
			jQuery('.template').hide(); 
			jQuery( '#' + a.val()).show();
		 });

		// subscriptions
		jQuery('.newsletter').change(function(){ 
			if (!this.checked) jQuery('#default_'+this.id).removeAttr('checked'); 
			jQuery('#span_default_'+this.id).toggle(); 
		});
		jQuery('.subscription_mngt').change( function() {
			var a = jQuery(this); 
			switch (a.val())
			{
				case 'ajax' :
					jQuery('.mngt_id').hide();
				break;
				default :
					jQuery('.toggle').hide();
					jQuery('.' + a.val()).show();
					jQuery('.mngt_id').show();
				break;
			}
		}); 
	}
}
jQuery(document).ready(function(){ mp_settings.init(); });