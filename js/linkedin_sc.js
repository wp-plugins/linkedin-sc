// Once we have an authorization, fetch the user's profile via API
function onLinkedInAuth() {
  // Ask server to read OAuth token
  // See http://developer.linkedin.com/docs/DOC-1252
  var data = {
    action: 'linkedin_sc_api_oauth',
  }
  // Using this until the race condition is solved
  window.setTimeout(function() {
                        jQuery.post(ajaxurl, data);
                    }, 1000);
  IN.API.Profile("me")
    .result( function(r) {setProfile(r);} )
    .error( function(e) {alert("something broke " + e);} );
}

// Display basic profile information inside the page
function setProfile(result) {
  var user = result.values[0];
  var msg = "<p>You are connected as: " + user.firstName + " " + user.lastName + "</p>";
  var profileDiv = document.getElementById("linkedin_sc_profile");
  profileDiv.innerHTML = msg;
}
