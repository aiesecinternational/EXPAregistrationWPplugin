var mapping;

function mapLC(uni) {
	return mapping[uni];
}

function getLeads(path_leads_json) {
   // jQuery.parseJSON(jqXHR.responseText);
    var jqxhr = jQuery.getJSON( path_leads_json, function() {
        //console.log( "getLeads success" );
        mapping = jQuery.parseJSON(jqxhr.responseText);
        })
            .done(function() {
            //console.log( "getLeads second success" );
            })
            .fail(function() {
            //console.log( "getLeads error" );
            })
            .always(function() {
            //console.log( "getLeads complete" );
            });  
    
}