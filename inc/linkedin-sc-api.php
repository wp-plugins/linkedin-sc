<?php

/*
 * Copyright 2010 Guillaume Viguier-Just (email: guillaume@viguierjust.com)
 * 
 * This program is free software: you can redistribute it and/or modify 
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

define('LINKEDIN_SC_ACCESS_TOKEN_URL', 'https://api.linkedin.com/uas/oauth/accessToken');

function linkedin_sc_api_get_config() {
  $api_config = array();
  $api_config['consumer_key'] = get_option('linkedin_sc_api_key');
  $api_config['consumer_secret'] = get_option('linkedin_sc_secret_key');
  $user_id = linkedin_sc_get_post_author();
  $api_config['oauth_token'] = get_user_meta($user_id, 'linkedin_sc_oauth_token', TRUE);
  $api_config['oauth_token_secret'] = get_user_meta($user_id, 'linkedin_sc_oauth_token_secret', TRUE);
  return $api_config;
}

function linkedin_sc_api_save_tokens($access) {
  global $current_user;
  $user_id = $current_user->ID;
  update_user_meta($user_id, 'linkedin_sc_oauth_token', $access['oauth_token']);
  update_user_meta($user_id, 'linkedin_sc_oauth_token_secret', $access['oauth_token_secret']);
}

function linkedin_sc_api_authorized() {
  $oauth_config = linkedin_sc_api_get_config();
  return $oauth_config['oauth_token'] != NULL;
}

function linkedin_sc_get_post_author() {
  global $post;
  global $current_user;
  
  if ($post) {
    return $post->post_author;
  }
  else {
    return $current_user->ID;
  }
}

function linkedin_sc_api_validate_signature($credentials) {
  global $linkedin_sc_secret_key;
  $consumer_secret = $linkedin_sc_secret_key;
  
  // validate signature
  if ($credentials->signature_version == 1) {
      if ($credentials->signature_order && is_array($credentials->signature_order)) {
          $base_string = '';
          // build base string from values ordered by signature_order
          foreach ($credentials->signature_order as $key) {
              if (isset($credentials->$key)) {
                  $base_string .= $credentials->$key;
              } else {
                  //print "missing signature parameter: $key";
                  return FALSE;
              }
          }
          // hex encode an HMAC-SHA1 string
          $signature =  base64_encode(hash_hmac('sha1', $base_string, $consumer_secret, true));
          // check if our signature matches the cookie's
          if ($signature == $credentials->signature) {
              return TRUE;
          } else {
              return FALSE;   
          }
      } else {
          //print "signature order missing";
          return FALSE;
      }
  } else {
      //print "unknown cookie version";
      return FALSE;
  }
}

function linkedin_sc_api_exchange_token($access_token) {
  global $linkedin_sc_api_key;
  global $linkedin_sc_secret_key;
  // configuration settings
  $consumer_key = $linkedin_sc_api_key;
  $consumer_secret = $linkedin_sc_secret_key;
  $access_token_url = LINKEDIN_SC_ACCESS_TOKEN_URL;
  
  if (extension_loaded('oauth')) {
    // Use PECL OAuth
    // init the client
    $oauth = new OAuth($consumer_key, $consumer_secret);

    // swap 2.0 token for 1.0a token and secret
    $oauth->fetch($access_token_url, array('xoauth_oauth2_access_token' => $access_token), OAUTH_HTTP_METHOD_POST);
    
    // parse the query string received in the response
    parse_str($oauth->getLastResponse(), $response);

    return $response;
  }
  else {
    // Try to use standalone OAuth library
    file_put_contents('/tmp/linkedin', 'test1');
    require_once(dirname(__FILE__).'/../lib/linkedin_profile/oauth/OAuth.php');
    $consumer = new OAuthConsumer($linkedin_sc_api_key, $linkedin_sc_secret_key, NULL);
    $acc_req = OAuthRequest::from_consumer_and_token($consumer, NULL, "POST", $access_token_url, array('xoauth_oauth2_access_token' => $access_token));
    $acc_req->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, $access_token);
    
    $context = stream_context_create(array(
      'http' => array(
        'method' => 'POST', 
        'content' => $acc_req->to_postdata()
      )
    ));
    $response_string = file_get_contents($access_token_url, false, $context);
    
    parse_str($response_string, $response);
    
    return $response;
  }
}
