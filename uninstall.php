<?php

if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();

delete_option('linkedin_sc_date_format');
delete_option('linkedin_sc_api_key');
delete_option('linkedin_sc_secret_key');
