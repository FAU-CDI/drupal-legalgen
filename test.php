<?php

$form = \Drupal::service('wisski_impressum.generator');

// GENERATE PRIVACY STATEMENT
$title_p = 'GERMAN TITLE';
$title_p_en = 'ENGLISH TITLE';
$alias_p = 'GERMAN ALIAS';
$alias_p_en = 'ENGLISH ALIAS';


$data_p = array(
      'wisski_url'                     => 'https://projectname.wisski.data.fau.de/',
      'not_fau_de'                     => '',
      'not_fau_en'                     => '',
      'sec_off_title_de'               => '',
      'sec_off_title_en'               => '',
      'sec_off_name'                   => '',
      'sec_off_add_de'                 => '',
      'sec_off_add_en'                 => '',
      'sec_off_address'                => '',
      'sec_off_plz'                    => '',
      'sec_off_city_de'                => '',
      'sec_off_city_en'                => '',
      'sec_off_phone'                  => '',
      'sec_off_fax'                    => '',
      'sec_off_email'                  => '',
      'third_service_provider'         => '',
      'third_descr_data_coll_de'       => '',
      'third_descr_data_coll_en'       => '',
      'third_legal_basis_data_coll_de' => '',
      'third_legal_basis_data_coll_en' => '',
      'third_objection_data_coll_de'   => '',
      'third_objection_data_coll_en'   => '',
      'data_comm_title_de'             => '',
      'data_comm_title_en'             => '',
      'data_comm_address'              => '',
      'data_comm_plz'                  => '',
      'data_comm_city_de'              => '',
      'data_comm_city_en'              => '',
      'date'                           => '',
);


$form->generateDatenschutz($data_p, $title_p, $title_p_en, $alias_p, $alias_p_en);


// GENERATE ACCESSIBILITY STATEMENT
$title_a = 'GERMAN TITLE';
$title_a_en = 'ENGLISH TITLE';
$alias_a = 'GERMAN ALIAS';
$alias_a_en = 'ENGLISH ALIAS';


$data_a = array(
      'wisski_url'                     => '',
      'status'                         => '',
      'methodology_de'                 => '',
      'methodology_en'                 => '',
      'creation_date'                  => '',
      'last_revis_date'                => '',
      'report_url'                     => '',
      'issues_array_de'                => '',
      'issues_array_en'                => '',
      'statement_array_de'             => '',
      'statement_array_en'             => '',
      'alternatives_array_de'          => '',
      'alternatives_array_en'          => '',
      'contact_access_name'            => '',
      'contact_access_phone'           => '',
      'contact_access_email'           => '',
      'sup_institute_de'               => '',
      'sup_institute_en'               => '',
      'sup_url'                        => '',
      'sup_address'                    => '',
      'sup_plz'                        => '',
      'sup_city_de'                    => '',
      'sup_city_en'                    => '',
      'sup_email'                      => '',
      'overs_name_de'                  => '',
      'overs_name_en'                  => '',
      'overs_dept_de'                  => '',
      'overs_dept_en'                  => '',
      'overs_address'                  => '',
      'overs_plz'                      => '',
      'overs_city_de'                  => '',
      'overs_city_en'                  => '',
      'overs_phone'                    => '',
      'overs_email'                    => '',
      'overs_url'                      => '',
      'date'                           => '',
);


$form->generateBarrierefreiheit($data_a, $title_a, $title_a_en, $alias_a, $alias_a_en);


// GENERATE LEGAL NOTICE

$title_ln = 'GERMAN TITLE';
$title_ln_en = 'ENGLISH TITLE';
$alias_ln = 'GERMAN ALIAS';
$alias_ln_en = 'ENGLISH ALIAS';


$data_ln = array(
      'wisski_url'                     => '',
      'project_name_de'                => 'WissKI Legalgen',
      'project_name_en'                => 'WissKI Legalgen',
      'pub_institute_de'               => '',
      'pub_institute_en'               => '',
      'pub_name'                       => '',
      'pub_address'                    => '',
      'pub_plz'                        => '',
      'pub_city_de'                    => '',
      'pub_city_en'                    => '',
      'pub_email'                      => '',
      'cust_legal_form_de'             => '',
      'cust_legal_form_en'             => '',
      'contact_name'                   => '',
      'contact_phone'                  => '',
      'contact_email'                  => '',
      'sup_institute_de'               => '',
      'sup_institute_en'               => '',
      'sup_url'                        => '',
      'sup_email'                      => '',
      'sup_staff_array'                => '',
      'auth_name_de'                   => '',
      'auth_name_en'                   => '',
      'auth_address'                   => '',
      'auth_plz'                       => '',
      'auth_city_de'                   => '',
      'auth_city_en'                   => '',
      'auth_url'                       => '',
      'licence_title_de'               => '',
      'licence_title_en'               => '',
      'licence_url'                    => '',
      'use_fau_temp'                   => '',
      'no_default_txt'                 => '',
      'cust_licence_txt_de'            => '',
      'cust_licence_txt_en'            => '',
      'cust_exclusion_de'              => '',
      'cust_exclusion_en'              => '',
      'show_disclaim'                  => '',
      'cust_disclaim_de'               => '',
      'cust_disclaim_en'               => '',
      'date'                           => '',

);


$form->generateImpressum($data_ln, $title_ln, $title_ln_en, $alias_ln, $alias_ln_en);
