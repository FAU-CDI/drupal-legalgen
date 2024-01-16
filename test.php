<?php

$form = \Drupal::service('wisski_impressum.generator');


// GENERATE LEGAL NOTICE

$title_ln = 'GERMAN TITLE';
$title_ln = 'ENGLISH TITLE';
$alias_ln = 'GERMAN ALIAS';
$alias_ln = 'ENGLISH ALIAS';


$data_ln = array(
      'wisski_url'                     => 'a',
      'project_name'                => 'b',
      'pub_institute'               => 'c',
      'pub_name'                       => 'd',
      'pub_address'                    => 'e',
      'pub_plz'                        => 'f',
      'pub_city'                    => 'g',
      'pub_email'                      => 'h',
      'cust_legal_form'             => 'i',
      'contact_name'                   => 'j',
      'contact_phone'                  => 'k',
      'contact_email'                  => 'l',
      'sup_institute'               => 'm',
      'sup_url'                        => 'n',
      'sup_email'                      => 'o',
      'sup_staff_array'                => array('1' => 'p',
                                                '2' => 'pp',
                                                '3' => 'ppp'),
      'auth_name'                   => 'q',
      'auth_address'                   => 'r',
      'auth_plz'                       => 's',
      'auth_city'                   => 't',
      'auth_url'                       => 'u',
      'licence_title'               => 'v',
      'licence_url'                    => 'w',
      'use_fau_temp'                   => 'x',
      'nofault_txt'                 => FALSE,
      'cust_licence_txt'            => 'y',
      'cust_exclusion'              => 'z',
      'show_disclaim'                  => 'FALSE',
      'cust_disclaim'               => 'aa',
      'date'                           => '2000.06.20',

);


$form->generateImpressum($data_ln, $title_ln, $title_ln, $alias_ln, $alias_ln);


// GENERATE ACCESSIBILITY STATEMENT
$title_a = 'GERMAN TITLE';
$title_a = 'ENGLISH TITLE';
$alias_a = 'GERMAN ALIAS';
$alias_a = 'ENGLISH ALIAS';


$data_a = array(
      'wisski_url'                     => 'a',
      'status'                         => 'b',
      'methodology'                 => 'c',
      'methodology'                 => 'c',
      'creation_date'                  => 'd',
      'last_revis_date'                => 'e',
      'report_url'                     => 'f',
      'issues_array'                => array('1' => 'g',
                                                '2' => 'gg',
                                                '3' => 'ggg'),
      'issues_array'                => array('1' => 'g',
                                                '2' => 'gg',
                                                '3' => 'ggg'),
      'statement_array'             => array('1' => 'h',
                                                '2' => 'hh',
                                                '3' => 'hhh'),
      'statement_array'             => array('1' => 'h',
                                                '2' => 'hh',
                                                '3' => 'hhh'),
      'alternatives_array'          => array('1' => 'i',
                                                '2' => 'ii',
                                                '3' => 'iii'),
      'alternatives_array'          => array('1' => 'i',
                                                '2' => 'ii',
                                                '3' => 'iii'),
      'contact_access_name'            => 'j',
      'contact_access_phone'           => 'k',
      'contact_access_email'           => 'l',
      'sup_institute'               => 'm',
      'sup_url'                        => 'n',
      'sup_address'                    => 'o',
      'sup_plz'                        => 'p',
      'sup_city'                    => 'q',
      'sup_email'                      => 'r',
      'overs_name'                  => 's',
      'overspt'                  => 't',
      'overs_address'                  => 'u',
      'overs_plz'                      => 'v',
      'overs_city'                  => 'w',
      'overs_phone'                    => 'x',
      'overs_email'                    => 'y',
      'overs_url'                      => 'z',
      'date'                           => '2023.01.29',
);


$form->generateBarrierefreiheit($data_a, $title_a, $title_a, $alias_a, $alias_a);


// GENERATE PRIVACY STATEMENT
$title_p = 'GERMAN TITLE';
$title_p = 'ENGLISH TITLE';
$alias_p = 'GERMAN ALIAS';
$alias_p = 'ENGLISH ALIAS';


$data_p = array(
      'wisski_url'                     => 'https://projectname.wisski.data.fau.de/',
      'not_fau'                     => 'a',
      'legal_notice_url'            => 'b',
      'sec_off_title'               => 'c',
      'sec_off_name'                   => 'd',
      'sec_off_add'                 => 'e',
      'sec_off_address'                => 'f',
      'sec_off_plz'                    => 'g',
      'sec_off_city'                => 'h',
      'sec_off_phone'                  => 'i',
      'sec_off_fax'                    => 'j',
      'sec_off_email'                  => 'k',
      'third_service_provider'         => 'l',
      'thirdscr_data_coll'       => 'm',
      'third_legal_basis_data_coll' => 'n',
      'third_objection_data_coll'   => 'o',
      'data_comm_title'             => 'p',
      'data_comm_address'              => 'q',
      'data_comm_plz'                  => 'r',
      'data_comm_city'              => 's',
      'date'                           => '2023.09.08',
);


$form->generateDatenschutz($data_p, $title_p, $title_p, $alias_p, $alias_p);