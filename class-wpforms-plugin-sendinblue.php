<?php
/**
 * SendinBlue plugin for WPForms
 *
 * @package    WPForms_Plugin_SendinBlue
 * @since      1.0.0
 * @copyright  Copyright (c) 2021, Georg Leber
 * @license    GPL-3.0+
 */

class WPForms_Plugin_SendinBlue {

    /**
     * Primary Class Constructor
     *
     */
    public function __construct() {

        add_filter( 'wpforms_builder_settings_sections', array( $this, 'settings_section' ), 20, 2 );
        add_filter( 'wpforms_form_settings_panel_content', array( $this, 'settings_section_content' ), 20 );
        add_action( 'wpforms_process_complete', array( $this, 'send_data_to_sendinblue' ), 10, 4 );

    }

    /**
     * Add Settings Section
     *
     */
    function settings_section( $sections, $form_data ) {
        $sections['be_sendinblue'] = __( 'SendinBlue', 'wpforms_plugin_sendinblue' );
        return $sections;
    }


    /**
     * ConvertKit Settings Content
     *
     */
    function settings_section_content( $instance ) {
        echo '<div class="wpforms-panel-content-section wpforms-panel-content-section-be_sendinblue">';
        echo '<div class="wpforms-panel-content-section-title">' . __( 'SendinBlue', 'wpforms_plugin_sendinblue' ) . '</div>';

/*
        if( empty( $instance->form_data['settings']['be_sendinblue_api'] ) ) {
            printf(
                '<p>%s <a href="http://mbsy.co/convertkit/28981746" target="_blank" rel="noopener noreferrer">%s</a></p>',
                __( 'Don\'t have an account?', 'wpforms_plugin_sendinblue' ),
                __( 'Sign up now!', 'wpforms_plugin_sendinblue' )
            );
        }
*/

        wpforms_panel_field(
            'text',
            'settings',
            'be_sendinblue_api',
            $instance->form_data,
            __( 'Sendinblue API Key', 'wpforms_plugin_sendinblue' )
        );
        wpforms_panel_field(
            'text',
            'settings',
            'be_sendinblue_redirect_url',
            $instance->form_data,
            __( 'Sendinblue Redirect URL', 'wpforms_plugin_sendinblue' )
        );
        wpforms_panel_field(
            'text',
            'settings',
            'be_sendinblue_list_id',
            $instance->form_data,
            __( 'Sendinblue List IDs', 'wpforms_plugin_sendinblue' )
        );
        wpforms_panel_field(
            'text',
            'settings',
            'be_sendinblue_template_id',
            $instance->form_data,
            __( 'Sendinblue Template ID', 'wpforms_plugin_sendinblue' )
        );
        wpforms_panel_field(
            'select',
            'settings',
            'be_sendinblue_field_name',
            $instance->form_data,
            __( 'Name ', 'wpforms_plugin_sendinblue' ),
            array(
                'field_map'   => array( 'text', 'name' ),
                'placeholder' => __( '-- Select Field --', 'wpforms_plugin_sendinblue' ),
            )
        );
        wpforms_panel_field(
            'select',
            'settings',
            'be_sendinblue_field_email',
            $instance->form_data,
            __( 'Email Address', 'wpforms_plugin_sendinblue' ),
            array(
                'field_map'   => array( 'email' ),
                'placeholder' => __( '-- Select Field --', 'wpforms_plugin_sendinblue' ),
            )
        );
        wpforms_panel_field(
            'select',
            'settings',
            'be_sendinblue_field_organisation',
            $instance->form_data,
            __( 'Organisation', 'wpforms_plugin_sendinblue' ),
            array(
                'field_map'   => array( 'text' ),
                'placeholder' => __( '-- Select Field --', 'wpforms_plugin_sendinblue' ),
            )
        );
        wpforms_panel_field(
            'select',
            'settings',
            'be_sendinblue_field_domain',
            $instance->form_data,
            __( 'Domain', 'wpforms_plugin_sendinblue' ),
            array(
                'field_map'   => array( 'text' ),
                'placeholder' => __( '-- Select Field --', 'wpforms_plugin_sendinblue' ),
            )
        );

        echo '</div>';
    }

    /**
     * Send data to SendinBlue API
     */
    function send_data_to_sendinblue( $fields, $entry, $form_data, $entry_id ) {
        // Get API Key, Redirect URL, List IDs, Template ID
        $api_key = $sib_redirect_url = $sib_list_ids = $sib_template_id = false;
        if( !empty( $form_data['settings']['be_sendinblue_api'] ) ) {
            $api_key = esc_html( $form_data['settings']['be_sendinblue_api'] );
        }
        if( !empty( $form_data['settings']['be_sendinblue_redirect_url'] ) ) {
            $sib_redirect_url = $form_data['settings']['be_sendinblue_redirect_url'];
        }
        if( !empty( $form_data['settings']['be_sendinblue_list_id'] ) ) {
            $sib_list_ids = $form_data['settings']['be_sendinblue_list_id'];
        }
        if( !empty( $form_data['settings']['be_sendinblue_template_id'] ) ) {
            $sib_template_id = intval( $form_data['settings']['be_sendinblue_template_id'] );
        }

        if( ! ( $api_key && $sib_list_ids && $sib_template_id ) ) {
            return;
        }

        // Get email and name
        $email_field_id = $form_data['settings']['be_sendinblue_field_email'];
        if( empty( $email_field_id ) || empty( $fields[$email_field_id]['value'] ) ) {
            return;
        }

        $name_field_id = $form_data['settings']['be_sendinblue_field_name'];
        if( empty( $name_field_id ) || empty( $fields[$name_field_id]['value'] ) ) {
            return;
        }

        $attributes = [
            'VORNAME' 	=> $fields[$name_field_id]['first'],
            'NACHNAME'	=> $fields[$name_field_id]['last']
        ];

        if ( !empty( $form_data['settings']['be_sendinblue_field_organisation'] )) {
            $company_field_id = $form_data['settings']['be_sendinblue_field_organisation'];
            $attributes['UNTERNEHMEN'] = $fields[$company_field_id]['value'];
        }

        if ( !empty( $form_data['settings']['be_sendinblue_field_domain'] )) {
            $domain_field_id = $form_data['settings']['be_sendinblue_field_domain'];
            $attributes['DOMAIN'] = $fields[$domain_field_id]['value'];
        }

        $data = [
            'attributes'		=> $attributes,
            'includeListIds'	=> array_map( 'intval', explode( ',', $sib_list_ids ) ),
            'email' 			=> $fields[$email_field_id]['value'],
            'redirectionUrl'	=> $sib_redirect_url,
            'templateId'		=> $sib_template_id
        ];

        // Submit to Sendinblue
        $request = wp_remote_post( 'https://api.sendinblue.com/v3/contacts/doubleOptinConfirmation', array(
            'method'  => 'POST',
            'body'    => json_encode( $data, JSON_UNESCAPED_SLASHES ),
            'headers' => [
                'Accept'		=> 'application/json',
                'Content-Type'	=> 'application/json',
                'api-key' 		=> $api_key,
            ]
        ) );

        if ( function_exists( 'wpforms_log' ) ) {
            wpforms_log(
                'SendinBlue Response',
                $request,
                [
                    'type'          => [ 'provider' ],
                    'parent'        => $entry_id,
                    'form_id'       => $form_data['id'],
                    'requestData'   => json_encode( $data, JSON_UNESCAPED_SLASHES )
                ]
            );
        }
    }

}
new WPForms_Plugin_SendinBlue;
