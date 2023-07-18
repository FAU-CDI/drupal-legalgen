<?php

$form = \Drupal::service('wisski_impressum.generator');



// GENERATE PRIVACY STATEMENT
$title_p = 'GERMAN TITLE';
$title_p_en = 'ENGLISH TITLE';
$alias_p = 'GERMAN ALIAS';
$alias_p_en = 'ENGLISH ALIAS';


$data_p = array(
      'wisski_url'                     => 'wisski_url',
      'not_fau_de'                     => 'not_fau_de',
      'not_fau_en'                     => 'not_fau_en',
      'sec_off_title_de'               => 'sec_off_title_de',
      'sec_off_title_en'               => 'sec_off_title_en',
      'sec_off_name'                   => 'sec_off_name',
      'sec_off_add_de'                 => 'sec_off_add_de',
      'sec_off_add_en'                 => 'sec_off_add_en',
      'sec_off_address'                => 'sec_off_address',
      'sec_off_plz'                    => 'sec_off_plz',
      'sec_off_city_de'                => 'sec_off_city_de',
      'sec_off_city_en'                => 'sec_off_city_en',
      'sec_off_email'                  => 'sec_off_email',
      'sec_off_phone'                  => 'sec_off_phone',
      'sec_off_fax'                    => 'sec_off_fax',
      'third_service_provider'         => 'third_service_provider',
      'third_descr_data_coll_de'       => 'third_descr_data_coll_de',
      'third_descr_data_coll_en'       => 'third_descr_data_coll_en',
      'third_legal_basis_data_coll_de' => 'third_legal_basis_data_coll_de',
      'third_legal_basis_data_coll_en' => 'third_legal_basis_data_coll_en',
      'third_objection_data_coll_de'   => 'third_objection_data_coll_de',
      'third_objection_data_coll_en'   => 'third_objection_data_coll_en',
      'data_comm_title_de'             => 'data_comm_title_de',
      'data_comm_title_en'             => 'data_comm_title_en',
      'data_comm_address'              => 'data_comm_address',
      'data_comm_plz'                  => 'data_comm_plz',
      'data_comm_city_de'              => 'data_comm_city_de',
      'data_comm_city_en'              => 'data_comm_city_en',
      'date'                           => '2023-03-05',
);


$form->generateDatenschutz($data_p, $title_p, $title_p_en, $alias_p, $alias_p_en);