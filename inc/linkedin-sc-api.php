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
 

function linkedin_sc_api_get_config() {
  $api_config = array();
  $api_config['appKey'] = get_option('linkedin_sc_api_key');
  $api_config['appSecret'] = get_option('linkedin_sc_secret_key');
  return $api_config;
}

function linkedin_sc_api_get_tokens() {
  global $current_user;
  
  $access = array();
  $access['oauth_token'] = get_user_meta($current_user->ID, 'linkedin_sc_oauth_token', TRUE);
  $access['oauth_token_secret'] = get_user_meta($current_user->ID, 'linkedin_sc_oauth_token_secret', TRUE);
  $access['oauth_expires_in'] = get_user_meta($current_user->ID, 'linkedin_sc_oauth_expires_in', TRUE);
  $access['oauth_authorization_expires_in'] = get_user_meta($current_user->ID, 'linkedin_sc_oauth_authorization_expires_in', TRUE);
  
  return $access;
}

function linkedin_sc_api_save_tokens($access) {
  global $current_user;
  
  $user_id = $current_user->ID;
  update_user_meta($user_id, 'linkedin_sc_oauth_token', $access['oauth_token']);
  update_user_meta($user_id, 'linkedin_sc_oauth_token_secret', $access['oauth_token_secret']);
  update_user_meta($user_id, 'linkedin_sc_oauth_expires_in', $access['oauth_expires_in']);
  update_user_meta($user_id, 'linkedin_sc_oauth_authorization_expires_in', $access['oauth_authorization_expires_in']);
}

function linkedin_sc_api_authorized() {
  global $current_user;
  $authorized = get_user_meta($current_user->ID, 'linkedin_sc_api_authorized', TRUE);
  return $authorized == 1;
}

