<?php

namespace Drupal\wisski_impressum\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\wisski_impressum\Generator\WisskiLegalGenerator;

use \Drupal\node\Entity\Node;

/**
 * Configure example settings for this site.
 */
class WissKiImpressumForm extends FormBase {

  /**
   * @var \Drupal\wisski_impressum\Generator\WisskiLegalGenerator
   */
  protected $generator;

  public function __construct()
  {
    /** @var \Drupal\wisski_impressum\Generator\WisskiLegalGenerator */
    $this->generator = \Drupal::service('wisski_impressum.generator');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return self::class;
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

  // Fields
  // type of render array element
  // see https://api.drupal.org/api/drupal/elements/8.2.x for available elements


    // Disclaimer
    $form['text_header'] = array(
      '#prefix' => '<p><strong>',
      '#suffix' => '</strong></p>',
      '#markup' => t('Das CDI ist nicht für die Korrektheit der eingegebenen Daten verantwortlich. Bitte überprüfen Sie nach der Generierung die erstellten Seiten auf Richtigkeit.<br/> Bitte beachten Sie außerdem, dass eine Neugenerierung die bestehende Seite komplett überschreibt.'),
      '#weight' => -100,
      );

    // Fields: General
    $form['General'] = array(
      '#type'  => 'details',
      '#title' => t('Allgemein / General'),
      '#open'  => true,
      );

      $form['General']['table1'] = array(
        '#type'   => 'table',
        '#title'  => 'General',
        '#header' => array('German', 'English'),
      );

        $form['General']['table1']['R1.1']['title'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Seitentitel'),
          '#default_value' => t('Impressum'),
          '#required'      => true,
          );

        $form['General']['table1']['R1.1']['Title_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Page title'),
          '#default_value' => t('Legal Notice'),
          '#required'      => true,
          );

        $form['General']['table1']['R1.2']['WissKI_URL'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('WissKI URL'),
          '#default_value' => t('https://mehrdad.wisski.data.fau.de/'),
          '#required'      => true,
          );

        $form['General']['table1']['R1.3']['alias'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Seiten-Alias'),
          '#default_value' => t('impressum'),
          '#required'      => true,
          );

        $form['General']['table1']['R1.3']['alias_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Page alias'),
          '#default_value' => t('legalnotice'),
          '#required'      => true,
          );

        $form['General']['table1']['R1.4']['Project_Name_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Projektname'),
          '#default_value' => t('Mehrdad'),
          '#required'      => true,
          );

        $form['General']['table1']['R1.4']['Project_Name_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Project name'),
          '#default_value' => t('Mehrdad'),
          '#required'      => true,
          );


    // Fields: Publisher
    $form['Publisher'] = array(
      '#type'  => 'details',
      '#title' => t('Herausgebende / Publisher'),
      '#open'  => true,
      );

      $form['Publisher']['table2'] = array(
        '#type'   => 'table',
        '#title'  => 'Publisher',
        '#header' => array('German', 'English'),
      );

        $form['Publisher']['table2']['R2.1']['Pub_Institute_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institut'),
          '#default_value' => t('Friedrich-Alexander-Universität Erlangen-Nürnberg, Institut für Kunstgeschichte'),
          '#required'      => true,
          );

        $form['Publisher']['table2']['R2.1']['Pub_Institute_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institute'),
          '#default_value' => t('Friedrich-Alexander-Universität Erlangen-Nürnberg, Institute of Art History'),
          '#required'      => true,
          );

        $form['Publisher']['table2']['R2.2']['Pub_Name'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Name Herausgebende / Name publisher'),
          '#default_value' => t('Mehrdad Tabrizi'),
          '#required'      => true,
          );

        $form['Publisher']['table2']['R2.3']['Pub_Address'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Straße und Hausnummer / Street name and house number'),
          '#default_value' => t('Mustermannstr. 123'),
          '#required'      => true,
          );

        $form['Publisher']['table2']['R2.4']['Pub_PLZ'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('PLZ / Postal code'),
          '#default_value' => t('91054'),
          '#required'      => true,
          );

        $form['Publisher']['table2']['R2.5']['Pub_City_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Ort'),
          '#default_value' => t('Erlangen'),
          '#required'      => true,
          );

        $form['Publisher']['table2']['R2.5']['Pub_City_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
          '#default_value' => t('Erlangen'),
          '#required'      => true,
          );

        $form['Publisher']['table2']['R2.6']['Pub_Email'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Herausgebende / E-mail publisher'),
          '#default_value' => t('cdi-wisski-support@fau.de'),
          '#required'      => true,
          );

    // Fields: Legal Form and Representation
    $form['Legal_Form_and_Representation'] = array(
      '#type'  => 'details',
      '#title' => t('Rechtsform und Vertretung / Legal form and representation'),
      '#open'  => true,
      );

      $form['Legal_Form_and_Representation']['table3'] = array(
        '#type'   => 'table',
        '#title'  => 'Contact Content',
        '#header' => array('German', 'English'),
      );

        $form['Legal_Form_and_Representation']['table3']['R3.1']['Custom_Legal_Form_DE'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Eigene Angaben (Leer lassen, wenn FAU-spezifischer Text beibehalten werden soll'),
          '#required'      => false,
          );

        $form['Legal_Form_and_Representation']['table3']['R3.1']['Custom_Legal_Form_EN'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Custom Information (Leave empty to display FAU specific text'),
          '#required'      => false,
          );



    // Fields: Contact Person Content
    $form['Contact_Content'] = array(
      '#type'  => 'details',
      '#title' => t('Kontaktperson Inhalt / Contact Person Content'),
      '#open'  => true,
      );

      $form['Contact_Content']['table4'] = array(
        '#type'   => 'table',
        '#title'  => 'Contact Content',
        '#header' => array('German', 'English'),
      );

        $form['Contact_Content']['table4']['R4.1']['Contact_Name'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Name Kontaktperson / Name contact person'),
          '#default_value' => t('Name Kontaktperson'),
          '#required'      => true,
          );

        $form['Contact_Content']['table4']['R4.2']['Contact_Phone'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Telefonnummer Kontaktperson / Phone contact person'),
          '#default_value' => t('+49 9131~ '),
          '#required'      => true,
          );

        $form['Contact_Content']['table4']['R4.3']['Contact_Email'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Kontaktperson / E-mail contact person'),
          '#default_value' => t('email@beispiel.de'),
          '#required'      => true,
          );


    // Fields: Support and Hosting
    $form['Support_and_Hosting'] = array(
      '#type'  => 'details',
      '#title' => t('Betreuung und Hosting / Support and Hosting'),
      '#open'  => true,
      );

      $form['Support_and_Hosting']['table5'] = array(
        '#type'   => 'table',
        '#title'  => 'Support and Hosting',
        '#header' => array('German', 'English'),
      );

        $form['Support_and_Hosting']['table5']['R5.1']['Sup_Institute_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institut'),
          '#default_value' => t('FAU Competence Center for Research Data and Information'),
          '#required'      => true,
          );

        $form['Support_and_Hosting']['table5']['R5.1']['Sup_Institute_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institute'),
          '#default_value' => t('FAU Competence Center for Research Data and Information'),
          '#required'      => true,
          );

        $form['Support_and_Hosting']['table5']['R5.2']['Sup_Email'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Betreuung / E-mail support'),
          '#default_value' => t('cdi-wisski-support@fau.de'),
          '#required'      => true,
          );

        $form['Support_and_Hosting']['table5']['R5.3']['Sup_Staff'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Mitarbeitende ("; " als Separator - e.g. "Alan Angestellter; Beatrice Beispiel;...") / Staff ("; " as separator - e.g. "Eda Employee; Sujin Staff;...")'),
          '#default_value' => t('Mehrdad Tabrizi; Laura Albers'),
          '#required'      => true,
          );

        $form['Support_and_Hosting']['table5']['R5.4']['Sup_URL'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Homepage Betreuung / Hompage support'),
          '#default_value' => t('https://www.cdi.fau.de/'),
          '#required'      => true,
          );


    // Fields: Supervisory Authority
    $form['Supervisory_Authority'] = array(
      '#type'  => 'details',
      '#title' => t('Zuständige Aufsichtsbehörde / Supervisory Authority'),
      '#open'  => true,
      );

      $form['Supervisory_Authority']['table6'] = array(
        '#type'   => 'table',
        '#title'  => 'Supervisory Authority',
        '#header' => array('German', 'English'),
      );

        $form['Supervisory_Authority']['table6']['R6.1']['Auth_Name_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Behördenname'),
          '#default_value' => t('Bayerisches Staatsministerium für Wissenschaft und Kunst'),
          '#required'      => true,
          );

        $form['Supervisory_Authority']['table6']['R6.1']['Auth_Name_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name supervisory authority'),
          '#default_value' => t('Bayerisches Staatsministerium für Wissenschaft und Kunst'),
          '#required'      => true,
          );

        $form['Supervisory_Authority']['table6']['R6.2']['Auth_Address'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Straße und Hausnummer / Street name and house number'),
          '#default_value' => t('Salvatorstraße 2'),
          '#required'      => true,
          );

        $form['Supervisory_Authority']['table6']['R6.3']['Auth_PLZ'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('PLZ / Postal code'),
          '#default_value' => t('80327'),
          '#required'      => true,
          );

        $form['Supervisory_Authority']['table6']['R6.4']['Auth_City_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Ort'),
          '#default_value' => t('München'),
          '#required'      => true,
          );

        $form['Supervisory_Authority']['table6']['R6.4']['Auth_City_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
          '#default_value' => t('Munich'),
          '#required'      => true,
          );

        $form['Supervisory_Authority']['table6']['R6.5']['Auth_URL'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('URL Behörde / URL Supervisory Authority'),
          '#default_value' => t('www.stmwk.bayern.de'),
          '#required'      => true,
          );


    // Fields: Copyright
    $form['Copyright'] = array(
      '#type'  => 'details',
      '#title' => t('Nutzungsbedingungen (Urheberrecht) / Copyright'),
      '#open'  => true,
      );

        $form['Copyright']['table7'] = array(
          '#type'   => 'table',
          '#title'  => 'Copyright',
          '#header' => array('German', 'English'),
        );

          $form['Copyright']['table7']['R7.1']['Licence_Title_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Nutzungsrechte / Lizenztitel'),
            '#default_value' => t('CC BY-NC-SA 4.0'),
            '#required'      => false,
            );

          $form['Copyright']['table7']['R7.1']['Licence_Title_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Right of use / License title'),
            '#default_value' => t('CC BY-NC-SA 4.0'),
            '#required'      => false,
            );

          $form['Copyright']['table7']['R7.2']['Licence_URL'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Lizenz URL / Licence URL'),
            '#default_value' => t('https://creativecommons.org/licenses/by-nc-sa/4.0/'),
            '#required'      => false,
            );

          $form['Copyright']['table7']['R7.3']['Use_FAU_Design_Template'] = array(
            '#type'          => 'checkbox',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Verwendung FAU Corporate Design / Use of FAU corporate design'),
            '#required'      => false,
            );

          $form['Copyright']['table7']['R7.4']['No_Default_Text'] = array(
            '#type'          => 'checkbox',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('\'Eigene Angaben\' ANSTATT Standardtext in \'Nutzungsbedingungen\' (Text zu nicht urheberrechtlich geschützten Inhalten und Privatgebrauch wird weiterhin angezeigt)'),
            '#required'      => false,
            );

          $form['Copyright']['table7']['R7.5']['Custom_Licence_Text_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Eigene Angaben'),
            '#default_value' => t('<<Text mit eigenen Angaben zum Urheberrecht.>>'),
            '#required'      => false,
            );

          $form['Copyright']['table7']['R7.5']['Custom_Licence_Text_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Custom Information'),
            '#default_value' => t('<<Text with custom information on copyright.>>'),
            '#required'      => false,
            );


    // Field: Exclusion of Liability
    $form['Exclusion_Liab'] = array(
      '#type'  => 'details',
      '#title' => t('Haftungsausschluss / Exclusion of Liability'),
      '#open'  => true,
      );

        $form['Exclusion_Liab']['table8'] = array(
          '#type'   => 'table',
          '#title'  => 'Exclusion Liability',
          '#header' => array('German', 'English'),
        );

          $form['Exclusion_Liab']['table8']['R8.1']['Custom_Exclusion_Liab_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Eigene Angaben zum Haftungsausschluss'),
            '#default_value' => t('<<Text mit eigenen Angaben>>'),
            '#required'      => false,
            );

          $form['Exclusion_Liab']['table8']['R8.1']['Custom_Exclusion_Liab_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Custom information on liability exclusion'),
            '#default_value' => t('<<Text with own information>>'),
            '#required'      => false,
            );


    // Field and Checkbox: Diclaimer External Links
    $form['Disclaimer'] = array(
      '#type'  => 'details',
      '#title' => t('Haftung für Links / Disclaimer External Links'),
      '#open'  => true,
      );

        $form['Disclaimer']['table9'] = array(
          '#type'   => 'table',
          '#title'  => 'Disclaimer',
          '#header' => array('German', 'English'),
        );

          $form['Disclaimer']['table9']['R9.1']['Show_Disclaimer'] = array(
            '#type'          => 'checkbox',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Abschnitt \'Haftung für Links\' soll NICHT angezeigt werden / Section \'Links and references (disclaimer)\' should not be displayed'),
            '#required'      => false,
            );

          $form['Disclaimer']['table9']['R9.2']['Custom_Disclaimer_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Eigene Angaben zur Haftung für Links (Feld leer lassen, um Standardtext anzuzeigen)'),
            '#required'      => false,
            );

          $form['Disclaimer']['table9']['R9.2']['Custom_Disclaimer_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Custom information on liability for links (leave empty to display default text)'),
            '#required'      => false,
            );

    // Field: Timestamp
    $form['Timestamp'] = array(
      '#type'  => 'details',
      '#title' => t('Erstellungsdatum / Generation Date'),
      '#open'  => true,
      );

        $form['Timestamp']['Date'] = array(
          '#type'          => 'date',
          '#title'         => t('Erstellungsdatum / Generation Date'),
          '#default_value' => ('2023-06-12'),
          '#required'      => true,
          );



// Sumbit Form Contents and Populate Template
    $form['submit_button'] = array(
        '#type'  => 'submit',
        '#value' => t('Erstellen / Generate'),
        );


    return $form;
  }


  /**
   * Called when the user hits submit button
   * {@inheritdoc}
   */

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    // $template['#title'] =  $values['table1']['R1.1']['title'];
    $title                = $values['table1']['R1.1']['title'];
    $title_en             = $values['table1']['R1.1']['Title_EN'];
    $wisski_url           = $values['table1']['R1.2']['WissKI_URL'];
    $alias                = $values['table1']['R1.3']['alias'];
    $alias_en             = $values['table1']['R1.3']['alias_EN'];
    $project_name_de      = $values['table1']['R1.4']['Project_Name_DE'];
    $project_name_en      = $values['table1']['R1.4']['Project_Name_EN'];
    $pub_institute_de     = $values['table2']['R2.1']['Pub_Institute_DE'];
    $pub_institute_en     = $values['table2']['R2.1']['Pub_Institute_EN'];
    $pub_name             = $values['table2']['R2.2']['Pub_Name'];
    $pub_address          = $values['table2']['R2.3']['Pub_Address'];
    $pub_plz              = $values['table2']['R2.4']['Pub_PLZ'];
    $pub_city_de          = $values['table2']['R2.5']['Pub_City_DE'];
    $pub_city_en          = $values['table2']['R2.5']['Pub_City_EN'];
    $pub_email            = $values['table2']['R2.6']['Pub_Email'];
    $cust_legal_form_de   = $values['table3']['R3.1']['Custom_Legal_Form_DE'];
    $cust_legal_form_en   = $values['table3']['R3.1']['Custom_Legal_Form_EN'];
    $contact_name         = $values['table4']['R4.1']['Contact_Name'];
    $contact_phone        = $values['table4']['R4.2']['Contact_Phone'];
    $contact_email        = $values['table4']['R4.3']['Contact_Email'];
    $sup_institute_de     = $values['table5']['R5.1']['Sup_Institute_DE'];
    $sup_institute_en     = $values['table5']['R5.1']['Sup_Institute_EN'];
    $sup_email            = $values['table5']['R5.2']['Sup_Email'];
    $sup_staff            = $values['table5']['R5.3']['Sup_Staff'];
    $sup_url              = $values['table5']['R5.4']['Sup_URL'];
    $auth_name_de         = $values['table6']['R6.1']['Auth_Name_DE'];
    $auth_name_en         = $values['table6']['R6.1']['Auth_Name_EN'];
    $auth_address         = $values['table6']['R6.2']['Auth_Address'];
    $auth_plz             = $values['table6']['R6.3']['Auth_PLZ'];
    $auth_city_de         = $values['table6']['R6.4']['Auth_City_DE'];
    $auth_city_en         = $values['table6']['R6.4']['Auth_City_EN'];
    $auth_url             = $values['table6']['R6.5']['Auth_URL'];
    $licence_title_de     = $values['table7']['R7.1']['Licence_Title_DE'];
    $licence_title_en     = $values['table7']['R7.1']['Licence_Title_EN'];
    $licence_url          = $values['table7']['R7.2']['Licence_URL'];
    $use_fau_temp         = $values['table7']['R7.3']['Use_FAU_Design_Template'];
    $no_default_txt       = $values['table7']['R7.4']['No_Default_Text'];
    $cust_licence_txt_de  = $values['table7']['R7.5']['Custom_Licence_Text_DE'];
    $cust_licence_txt_en  = $values['table7']['R7.5']['Custom_Licence_Text_EN'];
    $cust_exclusion_de    = $values['table8']['R8.1']['Custom_Exclusion_Liab_DE'];
    $cust_exclusion_en    = $values['table8']['R8.1']['Custom_Exclusion_Liab_EN'];
    $show_disclaim        = $values['table9']['R9.1']['Show_Disclaimer'];
    $cust_disclaim_de     = $values['table9']['R9.2']['Custom_Disclaimer_DE'];
    $cust_disclaim_en     = $values['table9']['R9.2']['Custom_Disclaimer_EN'];
    $date                 = $values['Date'];


    $sup_staff_array = explode('; ', $sup_staff);

    $template = [
      '#theme'                => 'impressum_template',
      '#wisski_url'              => $wisski_url,
      '#project_name_de'         => $project_name_de,
      '#pub_institute_de'        => $pub_institute_de,
      '#pub_name'                => $pub_name,
      '#pub_address'             => $pub_address,
      '#pub_plz'                 => $pub_plz,
      '#pub_city_de'             => $pub_city_de,
      '#pub_email'               => $pub_email,
      '#cust_legal_form_de'      => $cust_legal_form_de,
      '#contact_name'            => $contact_name,
      '#contact_phone'           => $contact_phone,
      '#contact_email'           => $contact_email,
      '#sup_institute_de'        => $sup_institute_de,
      '#sup_email'               => $sup_email,
      '#sup_staff'               => $sup_staff,
      '#sup_staff_array'         => $sup_staff_array,
      '#sup_url'                 => $sup_url,
      '#auth_name_de'            => $auth_name_de,
      '#auth_address'            => $auth_address,
      '#auth_plz'                => $auth_plz,
      '#auth_city_de'            => $auth_city_de,
      '#auth_url'                => $auth_url,
      '#licence_title_de'        => $licence_title_de,
      '#licence_url'             => $licence_url,
      '#use_fau_temp'            => $use_fau_temp,
      '#no_default_txt'          => $no_default_txt,
      '#cust_licence_txt_de'     => $cust_licence_txt_de,
      '#cust_exclusion_de'       => $cust_exclusion_de,
      '#show_disclaim'           => $show_disclaim,
      '#cust_disclaim_de'        => $cust_disclaim_de,
      '#date'                    => $date,
    ];
 dpm($template);
    $deleteQuery = \Drupal::database()->delete('path_alias');
    $deleteQuery->condition('alias', '/'.$alias);
    $deleteQuery->execute();

    $html = \Drupal::service('renderer')->renderPlain($template);

    $this->generateNode($title, $html, $alias);


    $template_en = [
      '#theme'                => 'legalnotice_template',
      '#wisski_url'              => $wisski_url,
      '#project_name_en'         => $project_name_en,
      '#pub_institute_en'        => $pub_institute_en,
      '#pub_name'                => $pub_name,
      '#pub_address'             => $pub_address,
      '#pub_plz'                 => $pub_plz,
      '#pub_city_en'             => $pub_city_en,
      '#pub_email'               => $pub_email,
      '#cust_legal_form_en'      => $cust_legal_form_en,
      '#contact_name'            => $contact_name,
      '#contact_phone'           => $contact_phone,
      '#contact_email'           => $contact_email,
      '#sup_institute_en'        => $sup_institute_en,
      '#sup_email'               => $sup_email,
      '#sup_staff'               => $sup_staff,
      '#sup_staff_array'         => $sup_staff_array,
      '#sup_url'                 => $sup_url,
      '#auth_name_en'            => $auth_name_en,
      '#auth_address'            => $auth_address,
      '#auth_plz'                => $auth_plz,
      '#auth_city_en'            => $auth_city_en,
      '#auth_url'                => $auth_url,
      '#licence_title_en'        => $licence_title_en,
      '#licence_url'             => $licence_url,
      '#use_fau_temp'            => $use_fau_temp,
      '#no_default_txt'          => $no_default_txt,
      '#cust_licence_txt_en'     => $cust_licence_txt_en,
      '#cust_exclusion_en'       => $cust_exclusion_en,
      '#show_disclaim'           => $show_disclaim,
      '#cust_disclaim_en'        => $cust_disclaim_en,
      '#date'                    => $date,

    ];
    $deleteQuery = \Drupal::database()->delete('path_alias');
    $deleteQuery->condition('alias', '/'.$alias_en);
    $deleteQuery->execute();

    $html_en = \Drupal::service('renderer')->renderPlain($template_en);
    $body_en = $html_en;

    $this->generateNode($title_en, $html_en, $alias_en);


  }

  function generateNode($title, $body, $alias){
    $node = Node::create([
        'type'    => 'page',
        'title'   => t($title),
        'body'    => array(
          //'summary' => "this is the summary",
            'value'     => $body,
            'format'    => 'full_html',
          ),
        // set alias for page
        'path'     => array('alias' => "/$alias"),
    ]);
    $node->save();
  }

}