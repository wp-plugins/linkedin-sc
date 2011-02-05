// Once we have an authorization, fetch the user's profile via API
function onLinkedInAuth() {
  // Post Oauth token to the server
  // @todo Token should be posted securely !!!!
  // Determining oauth token
  // See http://developer.linkedin.com/thread/2366
  var oauth_token = '';
  if (IN.ENV.auth.oauth_token) {
    oauth_token = IN.ENV.auth.oauth_token;
  }
  else {
    oauth_token = IN.ENV.auth.access_token;
  }
  var data = {
    action: 'linkedin_sc_api_oauth',
    oauth_token: oauth_token
  }
  jQuery.post(ajaxurl, data);
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
