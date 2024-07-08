<?php

$form = \Drupal::service('legalgen.generator');


// GENERATE LEGAL NOTICE

$title_ln_de = 'Ger Title LN';
$title_ln_en = 'ENG Title LN';
$alias_ln_de = 'GERMANALIASLEGALNOTICE';
$alias_ln_en = 'ENGLISHALIASLEGALNOTICE';
$page_name_ln = 'legal_notice';
$lang_ln_de = 'de';
$lang_ln_en = 'en';


$data_ln_en = array(
      'wisski_url'                     => 'wisski/url',
      'project_name'                   => 'Project Name',
      'pub_institute'                  => 'Insitute Publisher',
      'pub_name'                       => 'Name Publisher',
      'pub_address'                    => 'Address Publisher',
      'pub_plz'                        => 'Postal Code Publisher',
      'pub_city'                       => 'City Publisher',
      'pub_email'                      => 'Email@Publisher.de',
      'cust_legal_form'                => 'Legal Form',
      'contact_name'                   => 'Contact Name',
      'contact_phone'                  => 'Contact Phone',
      'contact_email'                  => 'Contact E-mail',
      'sup_institute'                  => 'Support Institute',
      'sup_url'                        => 'Support URL',
      'sup_email'                      => 'Support E-mail',
      'sup_staff'                      => 'Staff1; Staff2; Staff3',
      'sup_staff_array'                => array('1' => 'Staff1',
                                                '2' => 'Staff2',
                                                '3' => 'Staff3'),
      'auth_name'                      => 'Authority Name',
      'auth_address'                   => 'Authority Address',
      'auth_plz'                       => 'Authority Postal Code',
      'auth_city'                      => 'Authority City',
      'auth_url'                       => 'Authority URL',
      'id_vat'                         => 'vat id',
      'id_tax'                         => 'tax id',
      'id_duns'                        => 'duns id',
      'id_eori'                        => 'eori id',
      'licence_title_meta'             => 'Licence Title Meta',
      'licence_url_meta'               => 'licence/url/meta',
      'licence_title_imgs'             => 'Licence Title Images',
      'licence_url_imgs'               => 'licence/url/imgs',
      'use_fau_temp'                   => FALSE,
      'cust_licence_txt'               => 'Some custom licence text will be displayed here.',
      'no_default_txt'                 => FALSE,
      'cust_exclusion'                 => 'Some custom information on liability exclusion will be displayed here.',
      'hide_disclaim'                  => FALSE,
      'cust_disclaim'                  => 'Custom disclaimer regarding external links',
      'date'                           => '20.06.2000',
      'overwrite_consent'     	   => TRUE,
);

$data_ln_de = array(
      'wisski_url'                     => 'wissiki/url',
      'project_name'                   => 'Name des Projekts',
      'pub_institute'                  => 'Institut Herausgeber',
      'pub_name'                       => 'Name Herausgeber',
      'pub_address'                    => 'Adresse Herausgeber',
      'pub_plz'                        => 'PLZ Herausgeber',
      'pub_city'                       => 'Stadt Herausgeber',
      'pub_email'                      => 'E-Mail Herausgeber',
      'cust_legal_form'                => 'Rechtsform',
      'contact_name'                   => 'Name Kontaktperson',
      'contact_phone'                  => 'Telefonnummer Kontaktperson',
      'contact_email'                  => 'E-Mail Kontaktperson',
      'sup_institute'                  => 'Support Institut',
      'sup_url'                        => 'Support URL',
      'sup_email'                      => 'Support E-Mail',
      'sup_staff'                      => 'Staff1; Staff2; Staff3',
      'sup_staff_array'                => array('1' => 'Staff1',
                                                '2' => 'Staff2',
                                                '3' => 'Staff3'),
      'auth_name'                      => 'Aufsichtsbehörde Name',
      'auth_address'                   => 'Aufsichtsbehörde Adresse',
      'auth_plz'                       => 'Aufsichtsbehörde PLZ',
      'auth_city'                      => 'Aufsichtsbehörde Stadt',
      'auth_url'                       => 'Aufsichtsbehörde URL',
      'id_vat'                         => 'vat',
      'id_tax'                         => 'tax',
      'id_duns'                        => 'duns',
      'id_eori'                        => 'eori',
      'licence_title_meta'             => 'Lizenz Metadaten Titel',
      'licence_url_meta'               => 'Lizenz Metadaten URL',
      'licence_title_imgs'             => 'vi',
      'licence_url_imgs'               => 'wi',
      'use_fau_temp'                   => FALSE,
      'cust_licence_txt'               => 'y',
      'no_default_txt'                 => FALSE,
      'cust_exclusion'                 => 'z',
      'hide_disclaim'                  => FALSE,
      'cust_disclaim'                  => 'aa',
      'date'                           => '20.06.2000',
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
                            'licence_title_meta'    => '',
                            'licence_title_imgs'    => '',
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
                            'licence_url_meta'      => '',
                            'licence_url_imgs'      => '',
                            'auth_address'          => '',
                            'auth_plz'              => '',
                            'auth_url'              => '',
                            'id_vat'                => '',
                            'id_tax'                => '',
                            'id_duns'               => '',
                            'id_eori'               => '',
                            'hide_disclaim'         => '',
                            'date'                  => '',
                           );


//$form->generatePage($data_ln_de, $title_ln_de, $alias_ln_de, $page_name_ln, $lang_ln_de, $state_keys_lang_ln, $state_keys_intl_ln);
$form->generatePage($data_ln_en, $title_ln_en, $alias_ln_en, $page_name_ln, $lang_ln_en, $state_keys_lang_ln, $state_keys_intl_ln);

/*
// GENERATE ACCESSIBILITY STATEMENT
$title_a_de = 'GERMAN TITLE ACCESSIBILITY';
$title_a_en = 'ENGLISH TITLE ACCESSIBILITY';
$alias_a_de = 'GERMAN ALIAS ACCESSIBILITY';
$alias_a_en = 'ENGLISH ALIAS ACCESSIBILITY';
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
      'date'                        => '20.01.2023',
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
      'date'                        => '29.01.2023',
      'overwrite_consent'           => TRUE,
);

$state_keys_lang_a = array('title'                 => '',
                           'alias'                 => '',
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
                           'status'                => '',
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

$form->generatePage($data_a_de, $title_a_de, $alias_a_de, $page_name_a, $lang_a_de, $state_keys_lang_a, $state_keys_intl_a);
$form->generatePage($data_a_en, $title_a_en, $alias_a_en, $page_name_a, $lang_a_en, $state_keys_lang_a, $state_keys_intl_a);


// GENERATE PRIVACY STATEMENT
$title_p_de = 'GERMAN TITLE PRIVACY';
$title_p_en = 'ENGLISH TITLE PRIVACY';
$alias_p_de = 'GERMAN ALIAS PRIVACY';
$alias_p_en = 'ENGLISH ALIAS PRIVACY';
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
      'date'                           => '08.09.2023',
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
      'date'                           => '08.09.2023',
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


$form->generatePage($data_p_de, $title_p_de, $alias_p_de, $page_name_p, $lang_p_de, $state_keys_lang_p, $state_keys_intl_p);
$form->generatePage($data_p_en, $title_p_en, $alias_p_en, $page_name_p, $lang_p_en,$state_keys_lang_p, $state_keys_intl_p);
*/