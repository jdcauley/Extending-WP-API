<?php
  
  /*
	Plugin Name: Extending Rest
	Description: Oversimplified Class for making custom Rest Endpoints and extending returned data
	Version: 0.1
	Author: Jordan Cauley
	License: GPL2
	*/
  
  class Extending_Rest {
    
    public function __construct(){
      
      add_action('init', array($this, 'er_add_origin_header'));
      
      add_action( 'rest_api_init', array($this, 'er_routes'));
			add_action( 'rest_api_init', array($this, 'er_add_custom_fields') );
      
    }
    
    function er_add_origin_header(){
      
      header("Access-Control-Allow-Origin: *");
      
    }
    
    function er_sample_response( WP_REST_Request $request ){
      
      return $_GET;
      
    }
    
    function er_routes(){
      
      register_rest_route( 'er/v1', '/sample/', array(
				'methods' => 'GET',
				'callback' => array( $this, 'er_sample_response'),
			) );
      
    }
    
    function er_add_custom_fields(){
      
      register_rest_field( array('post'),
				'meta',
				array(
					'get_callback' => function($post){
  					
  					$fields = get_post_meta($post['id']);
  					
  					return $fields;
  					
					}
				)
			);
      
    }
    
    
  }
  
  new Extending_Rest();