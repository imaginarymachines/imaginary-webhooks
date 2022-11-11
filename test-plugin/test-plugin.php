<?php
/**
 * Plugin Name: Imaginary Machines Test Endpoints
 */
add_action( 'rest_api_init', function () {
    register_rest_route( 'plugin', '/test', [
        'methods' => 'POST',
        'callback' => function($request){
            update_option( 'imwtest', $request->get_param('test') );
            return rest_ensure_response(
                get_option('imwtest', [])
            );
        },
        'args' => [
            'test' => [
                'required' => true,
                'type' => 'object',
            ],
        ],
        ]
    );

    register_rest_route( 'plugin', '/test', [
        'methods' => 'GET',
        'callback' => function(){
          return rest_ensure_response(
              get_option('imwtest', [])
           );
        },
      ]
    );
  } );
