<?php

$form = \Drupal::service('legalgen.generator');


// GENERATE LEGAL NOTICE

$title_ln_de = 'GERMAN TITLE';
$title_ln_en = 'ENGLISH TITLE';
$alias_ln_de = 'GERMAN ALIAS';
$alias_ln_en = 'ENGLISH ALIAS';
$page_name_ln = 'legal_notice';
$lang_ln_de = 'de';
$lang_ln_en = 'en';


$data_ln_en = array(
      'wisski_url'                     => 'a',
      'project_name'                   => 'b',
      'pub_institute'                  => 'c',
      'pub_name'                       => 'd',
      'pub_address'                    => 'e',
      'pub_plz'                        => 'f',
      'pub_city'                       => 'g',
      'pub_email'                      => 'h',
      'cust_legal_form'                => 'i',
      'contact_name'                   => 'j',
      'contact_phone'                  => 'k',
      'contact_email'                  => 'l',
      'sup_institute'                  => 'm',
      'sup_url'                        => 'n',
      'sup_email'                      => 'o',
      'sup_staff'                      => 'p; pp; ppp',
      'sup_staff_array'                => array('1' => 'p',
                                                '2' => 'pp',
                                                '3' => 'ppp'),
      'auth_name'                      => 'q',
      'auth_address'                   => 'r',
      'auth_plz'                       => 's',
      'auth_city'                      => 't',
      'auth_url'                       => 'u',
      'id_vat'                         => 'vat',
      'id_tax'                         => 'tax',
      'id_duns'                        => 'duns',
      'id_eori'                        => 'eori',
      'licence_title_meta'             => 'vm',
      'licence_url_meta'               => 'wm',
      'licence_title_imgs'             => 'vi',
      'licence_url_imgs'               => 'wi',
      'use_fau_temp'                   => 'x',
      'cust_licence_txt'               => 'y',
      'no_default_txt'                 => FALSE,
      'cust_exclusion'                 => 'z',
      'hide_disclaim'                  => 'FALSE',
      'cust_disclaim'                  => 'aa',
      'date'                           => '2000.06.20',
      'overwrite_consent'     	   => TRUE,
);

$data_ln_de = array(
      'wisski_url'                     => 'a',
      'project_name'                   => 'b',
      'pub_institute'                  => 'c',
      'pub_name'                       => 'd',
      'pub_address'                    => 'e',
      'pub_plz'                        => 'f',
      'pub_city'                       => 'g',
      'pub_email'                      => 'h',
      'cust_legal_form'                => 'i',
      'contact_name'                   => 'j',
      'contact_phone'                  => 'k',
      'contact_email'                  => 'l',
      'sup_institute'                  => 'm',
      'sup_url'                        => 'n',
      'sup_email'                      => 'o',
      'sup_staff'                      => 'p; pp; ppp',
      'sup_staff_array'                => array('1' => 'p',
                                                '2' => 'pp',
                                                '3' => 'ppp'),
      'auth_name'                      => 'q',
      'auth_address'                   => 'r',
      'auth_plz'                       => 's',
      'auth_city'                      => 't',
      'auth_url'                       => 'u',
      'id_vat'                         => 'vat',
      'id_tax'                         => 'tax',
      'id_duns'                        => 'duns',
      'id_eori'                        => 'eori',
      'licence_title_meta'             => 'vm',
      'licence_url_meta'               => 'wm',
      'licence_title_imgs'             => 'vi',
      'licence_url_imgs'               => 'wi',
      'use_fau_temp'                   => 'x',
      'cust_licence_txt'               => 'y',
      'no_default_txt'                 => FALSE,
      'cust_exclusion'                 => 'z',
      'hide_disclaim'                  => 'FALSE',
      'cust_disclaim'                  => 'aa',
      'date'                           => '2000.06.20',
      'overwrite_consent'     	   => TRUE,

);

$state_keys_lang_ln = array('title'                 => '',
                            'alias'                 => '',
                            'project_name'          => '',
                            'pub_institute'         => '',
                            'pub_name'              => '',
                            'pub_city'              => '',
                            'cust_legal_form'       => '',
                            'contact_name'          => '',
                            'sup_institute'         => '',
                            'sup_staff_array'       => '',
                            'auth_name'             => '',
                            'auth_city'             => '',
                            'licence_title'         => '',
                            'use_fau_temp'          => '',
                            'cust_licence_txt'      => '',
                            'no_default_txt'        => '',
                            'cust_exclusion'        => '',
                            'cust_disclaim'         => '',
                            'overwrite_consent'     => '',
                           );

$state_keys_intl_ln = array('wisski_url'            => '',
                            'pub_address'           => '',
                            'pub_plz'               => '',
                            'pub_email'             => '',
                            'contact_phone'         => '',
                            'contact_email'         => '',
                            'sup_url'               => '',
                            'sup_email'             => '',
                            'licence_url'           => '',
                            'auth_address'          => '',
                            'auth_plz'              => '',
                            'auth_url'              => '',
                            'hide_disclaim'         => '',
                            'date'                  => '',
                           );


$form->generatePage($data_ln_de, $title_ln_de, $alias_ln_de, $lang_ln_de, $page_name_ln, $state_keys_lang_ln, $state_keys_intl_ln);
$form->generatePage($data_ln_en, $title_ln_en, $alias_ln_en, $lang_ln_en, $page_name_ln, $state_keys_lang_ln, $state_keys_intl_ln);


// GENERATE ACCESSIBILITY STATEMENT
$title_a_de = 'GERMAN TITLE';
$title_a_en = 'ENGLISH TITLE';
$alias_a_de = 'GERMAN ALIAS';
$alias_a_en = 'ENGLISH ALIAS';
$page_name_a = 'accessibility';
$lang_a_de = 'de';
$lang_a_en = 'en';


$data_a_en = array(
      'wisski_url'                  => 'a',
      'status'                      => 'b',
      'methodology'                 => 'c',
      'creation_date'               => 'd',
      'last_revis_date'             => 'e',
      'report_url'                  => 'f',
      'issues_array'                => array('1' => 'g',
                                                '2' => 'gg',
                                                '3' => 'ggg'),
      'statement_array'             => array('1' => 'h',
                                                '2' => 'hh',
                                                '3' => 'hhh'),
      'alternatives_array'          => array('1' => 'i',
                                                '2' => 'ii',
                                                '3' => 'iii'),
      'contact_access_name'         => 'j',
      'contact_access_phone'        => 'k',
      'contact_access_email'        => 'l',
      'sup_institute'               => 'm',
      'sup_url'                     => 'n',
      'sup_address'                 => 'o',
      'sup_plz'                     => 'p',
      'sup_city'                    => 'q',
      'sup_email'                   => 'r',
      'overs_name'                  => 's',
      'overs_dept'                  => 't',
      'overs_address'               => 'u',
      'overs_plz'                   => 'v',
      'overs_city'                  => 'w',
      'overs_phone'                 => 'x',
      'overs_email'                 => 'y',
      'overs_url'                   => 'z',
      'date'                        => '2023.01.29',
      'overwrite_consent'           => TRUE,
);

$data_a_de = array(
      'wisski_url'                  => 'a',
      'status'                      => 'b',
      'methodology'                 => 'c',
      'creation_date'               => 'd',
      'last_revis_date'             => 'e',
      'report_url'                  => 'f',
      'issues_array'                => array('1' => 'g',
                                                '2' => 'gg',
                                                '3' => 'ggg'),
      'statement_array'             => array('1' => 'h',
                                                '2' => 'hh',
                                                '3' => 'hhh'),
      'alternatives_array'          => array('1' => 'i',
                                                '2' => 'ii',
                                                '3' => 'iii'),
      'contact_access_name'         => 'j',
      'contact_access_phone'        => 'k',
      'contact_access_email'        => 'l',
      'sup_institute'               => 'm',
      'sup_url'                     => 'n',
      'sup_address'                 => 'o',
      'sup_plz'                     => 'p',
      'sup_city'                    => 'q',
      'sup_email'                   => 'r',
      'overs_name'                  => 's',
      'overs_dept'                  => 't',
      'overs_address'               => 'u',
      'overs_plz'                   => 'v',
      'overs_city'                  => 'w',
      'overs_phone'                 => 'x',
      'overs_email'                 => 'y',
      'overs_url'                   => 'z',
      'date'                        => '2023.01.29',
      'overwrite_consent'           => TRUE,
);

$state_keys_lang_a = array('title'                 => '',
                           'alias'                 => '',
                           'status'                => '',
                           'methodology'           => '',
                           'issues_array'          => '',
                           'statement_array'       => '',
                           'alternatives_array'    => '',
                           'contact_access_name'   => '',
                           'sup_institute'         => '',
                           'sup_city'              => '',
                           'overs_name'            => '',
                           'overs_dept'            => '',
                           'overs_city'            => '',
                           'overwrite_consent'     => '',
);

$state_keys_intl_a = array('wisski_url'            => '',
                           'creation_date'         => '',
                           'last_revis_date'       => '',
                           'report_url'            => '',
                           'contact_access_phone'  => '',
                           'contact_access_email'  => '',
                           'sup_url'               => '',
                           'sup_address'           => '',
                           'sup_plz'               => '',
                           'sup_email'             => '',
                           'overs_address'         => '',
                           'overs_plz'             => '',
                           'overs_phone'           => '',
                           'overs_email'           => '',
                           'overs_url'             => '',
                           'date'                  => '',
);

$form->generatePage($data_a_de, $title_a_de, $alias_a_de, $lang_a_de, $page_name_a, $state_keys_lang_a, $state_keys_intl_a);
$form->generatePage($data_a_en, $title_a_en, $alias_a_en, $lang_a_en, $page_name_a, $state_keys_lang_a, $state_keys_intl_a);


// GENERATE PRIVACY STATEMENT
$title_p_de = 'GERMAN TITLE';
$title_p_en = 'ENGLISH TITLE';
$alias_p_de = 'GERMAN ALIAS';
$alias_p_en = 'ENGLISH ALIAS';
$page_name_p = 'privacy';
$lang_p_de = 'de';
$lang_p_en = 'en';

$data_p_en = array(
      'not_fau'                        => 'a',
      'legal_notice_url'               => 'b',
      'sec_off_title'                  => 'c',
      'sec_off_name'                   => 'd',
      'sec_off_add'                    => 'e',
      'sec_off_address'                => 'f',
      'sec_off_plz'                    => 'g',
      'sec_off_city'                   => 'h',
      'sec_off_phone'                  => 'i',
      'sec_off_fax'                    => 'j',
      'sec_off_email'                  => 'k',
      'third_service_provider'         => 'l',
      'third_descr_data_coll'          => 'm',
      'third_legal_basis_data_coll'    => 'n',
      'third_objection_data_coll'      => 'o',
      'data_comm_title'                => 'p',
      'data_comm_address'              => 'q',
      'data_comm_plz'                  => 'r',
      'data_comm_city'                 => 's',
      'date'                           => '2023.09.08',
      'overwrite_consent'              => TRUE,
);

$data_p_de = array(
      'not_fau'                        => 'a',
      'legal_notice_url'               => 'b',
      'sec_off_title'                  => 'c',
      'sec_off_name'                   => 'd',
      'sec_off_add'                    => 'e',
      'sec_off_address'                => 'f',
      'sec_off_plz'                    => 'g',
      'sec_off_city'                   => 'h',
      'sec_off_phone'                  => 'i',
      'sec_off_fax'                    => 'j',
      'sec_off_email'                  => 'k',
      'third_service_provider'         => 'l',
      'third_descr_data_coll'          => 'm',
      'third_legal_basis_data_coll'    => 'n',
      'third_objection_data_coll'      => 'o',
      'data_comm_title'                => 'p',
      'data_comm_address'              => 'q',
      'data_comm_plz'                  => 'r',
      'data_comm_city'                 => 's',
      'date'                           => '2023.09.08',
      'overwrite_consent'              => TRUE,
);

$state_keys_lang_p = array('title'                          => '',
                           'alias'                          => '',
                           'not_fau'                        => '',
                           'sec_off_title'                  => '',
                           'sec_off_name'                   => '',
                           'sec_off_add'                    => '',
                           'sec_off_city'                   => '',
                           'third_service_provider'         => '',
                           'third_descr_data_coll'          => '',
                           'third_legal_basis_data_coll'    => '',
                           'third_objection_data_coll'      => '',
                           'data_comm_title'                => '',
                           'data_comm_city'                 => '',
                           'overwrite_consent'              => '',
);

$state_keys_intl_p = array('sec_off_address'                => '',
                           'sec_off_plz'                    => '',
                           'sec_off_phone'                  => '',
                           'sec_off_fax'                    => '',
                           'sec_off_email'                  => '',
                           'data_comm_address'              => '',
                           'data_comm_plz'                  => '',
                           'date'                           => '',
);


$form->generatePage($data_p_de, $title_p_de, $alias_p_de, $lang_p_de, $page_name_p, $state_keys_lang_p, $state_keys_intl_p);
$form->generatePage($data_p_en, $title_p_en, $alias_p_en, $lang_p_en, $page_name_p, $state_keys_lang_p, $state_keys_intl_p);
