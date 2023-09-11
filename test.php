<?php

$form = \Drupal::service('wisski_impressum.generator');


// GENERATE LEGAL NOTICE

$title_ln = 'GERMAN TITLE';
$title_ln_en = 'ENGLISH TITLE';
$alias_ln = 'GERMAN ALIAS';
$alias_ln_en = 'ENGLISH ALIAS';


$data_ln = array(
      'wisski_url'                     => 'a',
      'project_name_de'                => 'b',
      'project_name_en'                => 'b',
      'pub_institute_de'               => 'c',
      'pub_institute_en'               => 'c',
      'pub_name'                       => 'd',
      'pub_address'                    => 'e',
      'pub_plz'                        => 'f',
      'pub_city_de'                    => 'g',
      'pub_city_en'                    => 'g',
      'pub_email'                      => 'h',
      'cust_legal_form_de'             => 'i',
      'cust_legal_form_en'             => 'i',
      'contact_name'                   => 'j',
      'contact_phone'                  => 'k',
      'contact_email'                  => 'l',
      'sup_institute_de'               => 'm',
      'sup_institute_en'               => 'm',
      'sup_url'                        => 'n',
      'sup_email'                      => 'o',
      'sup_staff_array'                => array('1' => 'p',
                                                '2' => 'pp',
                                                '3' => 'ppp'),
      'auth_name_de'                   => 'q',
      'auth_name_en'                   => 'q',
      'auth_address'                   => 'r',
      'auth_plz'                       => 's',
      'auth_city_de'                   => 't',
      'auth_city_en'                   => 't',
      'auth_url'                       => 'u',
      'licence_title_de'               => 'v',
      'licence_title_en'               => 'v',
      'licence_url'                    => 'w',
      'use_fau_temp'                   => 'x',
      'no_default_txt'                 => FALSE,
      'cust_licence_txt_de'            => 'y',
      'cust_licence_txt_en'            => 'y',
      'cust_exclusion_de'              => 'z',
      'cust_exclusion_en'              => 'z',
      'show_disclaim'                  => 'FALSE',
      'cust_disclaim_de'               => 'aa',
      'cust_disclaim_en'               => 'aa',
      'date'                           => '2000.06.20',

);


$form->generateImpressum($data_ln, $title_ln, $title_ln_en, $alias_ln, $alias_ln_en);


// GENERATE ACCESSIBILITY STATEMENT
$title_a = 'GERMAN TITLE';
$title_a_en = 'ENGLISH TITLE';
$alias_a = 'GERMAN ALIAS';
$alias_a_en = 'ENGLISH ALIAS';


$data_a = array(
      'wisski_url'                     => 'a',
      'status'                         => 'b',
      'methodology_de'                 => 'c',
      'methodology_en'                 => 'c',
      'creation_date'                  => 'd',
      'last_revis_date'                => 'e',
      'report_url'                     => 'f',
      'issues_array_de'                => array('1' => 'g',
                                                '2' => 'gg',
                                                '3' => 'ggg'),
      'issues_array_en'                => array('1' => 'g',
                                                '2' => 'gg',
                                                '3' => 'ggg'),
      'statement_array_de'             => array('1' => 'h',
                                                '2' => 'hh',
                                                '3' => 'hhh'),
      'statement_array_en'             => array('1' => 'h',
                                                '2' => 'hh',
                                                '3' => 'hhh'),
      'alternatives_array_de'          => array('1' => 'i',
                                                '2' => 'ii',
                                                '3' => 'iii'),
      'alternatives_array_en'          => array('1' => 'i',
                                                '2' => 'ii',
                                                '3' => 'iii'),
      'contact_access_name'            => 'j',
      'contact_access_phone'           => 'k',
      'contact_access_email'           => 'l',
      'sup_institute_de'               => 'm',
      'sup_institute_en'               => 'm',
      'sup_url'                        => 'n',
      'sup_address'                    => 'o',
      'sup_plz'                        => 'p',
      'sup_city_de'                    => 'q',
      'sup_city_en'                    => 'q',
      'sup_email'                      => 'r',
      'overs_name_de'                  => 's',
      'overs_name_en'                  => 's',
      'overs_dept_de'                  => 't',
      'overs_dept_en'                  => 't',
      'overs_address'                  => 'u',
      'overs_plz'                      => 'v',
      'overs_city_de'                  => 'w',
      'overs_city_en'                  => 'w',
      'overs_phone'                    => 'x',
      'overs_email'                    => 'y',
      'overs_url'                      => 'z',
      'date'                           => '2023.01.29',
);


$form->generateBarrierefreiheit($data_a, $title_a, $title_a_en, $alias_a, $alias_a_en);


// GENERATE PRIVACY STATEMENT
$title_p = 'GERMAN TITLE';
$title_p_en = 'ENGLISH TITLE';
$alias_p = 'GERMAN ALIAS';
$alias_p_en = 'ENGLISH ALIAS';


$data_p = array(
      'wisski_url'                     => 'https://projectname.wisski.data.fau.de/',
      'not_fau_de'                     => 'a',
      'not_fau_en'                     => 'b',
      'legal_notice_url_de'            => 'a',
      'legal_notice_url_en'            => 'a',
      'sec_off_title_de'               => 'c',
      'sec_off_title_en'               => 'd',
      'sec_off_name'                   => 'e',
      'sec_off_add_de'                 => 'f',
      'sec_off_add_en'                 => 'g',
      'sec_off_address'                => 'h',
      'sec_off_plz'                    => 'i',
      'sec_off_city_de'                => 'j',
      'sec_off_city_en'                => 'k',
      'sec_off_phone'                  => 'l',
      'sec_off_fax'                    => 'm',
      'sec_off_email'                  => 'n',
      'third_service_provider'         => 'o',
      'third_descr_data_coll_de'       => 'p',
      'third_descr_data_coll_en'       => 'q',
      'third_legal_basis_data_coll_de' => 'r',
      'third_legal_basis_data_coll_en' => 's',
      'third_objection_data_coll_de'   => 't',
      'third_objection_data_coll_en'   => 'u',
      'data_comm_title_de'             => 'v',
      'data_comm_title_en'             => 'w',
      'data_comm_address'              => 'x',
      'data_comm_plz'                  => 'y',
      'data_comm_city_de'              => 'z',
      'data_comm_city_en'              => '1',
      'date'                           => '2023.09.08',
);


$form->generateDatenschutz($data_p, $title_p, $title_p_en, $alias_p, $alias_p_en);