<?php

namespace Drupal\wisski_impressum\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Drupal\wisski_impressum\Generator\WisskiLegalGenerator;
use Drupal\Core\Datetime\DrupalDateTime;

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

  public function getState(){
    return \Drupal::state();
  }


  public function getStateValues(){
    if(!empty(\Drupal::state()->get('wisski_impressum.legalNotice'))){
      return \Drupal::state()->get('wisski_impressum.legalNotice');
    }else{
      return NULL;
    }
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

  // Fields
  // type of render array element
  // see https://api.drupal.org/api/drupal/elements/8.2.x for available elements

  $storedValues = $this->getStateValues();

  $defaultValues = WisskiLegalGenerator::REQUIRED_DATA_ALL['REQUIRED_LEGALNOTICE'];


    // Fields: General
    $form['General'] = array(
      '#type'  => 'details',
      '#title' => t('Allgemein / General'),
      '#open'  => TRUE,
      );

      $form['General']['table1'] = array(
        '#type'   => 'table',
        '#title'  => 'General',
        '#header' => array('German', 'English'),
      );

        $form['General']['table1']['R1.1']['Title_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Seitentitel'),
          '#default_value' => $storedValues['title_de']?? $defaultValues['title_de'],
          '#required'      => TRUE,
          );

        $form['General']['table1']['R1.1']['Title_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Page title'),
          '#default_value' => $storedValues['title_en']?? $defaultValues['title_en'],
          '#required'      => TRUE,
          );

        $form['General']['table1']['R1.2']['WissKI_URL'] = array(
          '#type'          => 'link',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('WissKI URL'),
          '#default_value' => $storedValues['wisski_url']?? $defaultValues['wisski_url'],
          '#required'      => TRUE,
          );

        $form['General']['table1']['R1.3']['Alias_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Seiten-Alias'),
          '#default_value' => $storedValues['alias_de']?? $defaultValues['alias_de'],
          '#required'      => TRUE,
          );

        $form['General']['table1']['R1.3']['Alias_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Page alias'),
          '#default_value' => $storedValues['alias_en']?? $defaultValues['alias_en'],
          '#required'      => TRUE,
          );

        $form['General']['table1']['R1.4']['Project_Name_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Projektname'),
          '#default_value' => $storedValues['project_name_de']?? $defaultValues['project_name_de'],
          '#required'      => TRUE,
          );

        $form['General']['table1']['R1.4']['Project_Name_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Project name'),
          '#default_value' => $storedValues['project_name_en']?? $defaultValues['project_name_en'],
          '#required'      => TRUE,
          );


    // Fields: Publisher
    $form['Publisher'] = array(
      '#type'  => 'details',
      '#title' => t('Herausgebende / Publisher'),
      '#open'  => TRUE,
      );

      $form['Publisher']['table2'] = array(
        '#type'   => 'table',
        '#title'  => 'Publisher',
        '#header' => array('German', 'English'),
      );

        $form['Publisher']['table2']['R2.1']['Pub_Institute_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institut'),
          '#default_value' => $storedValues['pub_institute_de']?? $defaultValues['pub_institute_de'],
          '#required'      => TRUE,
          );

        $form['Publisher']['table2']['R2.1']['Pub_Institute_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institute'),
          '#default_value' => $storedValues['pub_institute_en']?? $defaultValues['pub_institute_en'],
          '#required'      => TRUE,
          );

        $form['Publisher']['table2']['R2.2']['Pub_Name'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Name Herausgebende / Name publisher'),
          '#default_value' => $storedValues['pub_name']?? $defaultValues['pub_name'],
          '#required'      => TRUE,
          );

        $form['Publisher']['table2']['R2.3']['Pub_Address'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Straße und Hausnummer / Street name and house number'),
          '#default_value' => $storedValues['pub_address']?? $defaultValues['pub_address'],
          '#required'      => TRUE,
          );

        $form['Publisher']['table2']['R2.4']['Pub_PLZ'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('PLZ / Postal code'),
          '#default_value' => $storedValues['pub_plz']?? $defaultValues['pub_plz'],
          '#required'      => TRUE,
          );

        $form['Publisher']['table2']['R2.5']['Pub_City_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Ort'),
          '#default_value' => $storedValues['pub_city_de']?? $defaultValues['pub_city_de'],
          '#required'      => TRUE,
          );

        $form['Publisher']['table2']['R2.5']['Pub_City_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
          '#default_value' => $storedValues['pub_city_en']?? $defaultValues['pub_city_en'],
          '#required'      => TRUE,
          );

        $form['Publisher']['table2']['R2.6']['Pub_Email'] = array(
          '#type'          => 'email',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Herausgebende / E-mail publisher'),
          '#default_value' => $storedValues['pub_email']?? $defaultValues['pub_email'],
          '#required'      => TRUE,
          );

    // Fields: Legal Form and Representation
    $form['Legal_Form_and_Representation'] = array(
      '#type'  => 'details',
      '#title' => t('Rechtsform und Vertretung / Legal form and representation'),
      '#open'  => TRUE,
      );

      $form['Legal_Form_and_Representation']['table3'] = array(
        '#type'   => 'table',
        '#title'  => 'Contact Content',
        '#header' => array('German', 'English'),
      );

        $form['Legal_Form_and_Representation']['table3']['R3.1']['Custom_Legal_Form_DE'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Eigene Angaben (Leer lassen, wenn FAU-spezifischer Text beibehalten werden soll)'),
          '#required'      => FALSE,
          '#default_value' => $storedValues['cust_legal_form_de']?? t(''),
          );

        $form['Legal_Form_and_Representation']['table3']['R3.1']['Custom_Legal_Form_EN'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Custom Information (Leave empty to display FAU specific text)'),
          '#default_value' => $storedValues['cust_legal_form_en']?? t(''),
          '#required'      => FALSE,
          );



    // Fields: Contact Person Content
    $form['Contact_Content'] = array(
      '#type'  => 'details',
      '#title' => t('Kontaktperson Inhalt / Contact Person Content'),
      '#open'  => TRUE,
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
          '#default_value' => $storedValues['contact_name']?? $defaultValues['contact_name'],
          '#required'      => TRUE,
          );

        $form['Contact_Content']['table4']['R4.2']['Contact_Phone'] = array(
          '#type'          => 'tel',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Telefonnummer Kontaktperson / Phone contact person'),
          '#default_value' => $storedValues['contact_phone']?? $defaultValues['contact_phone'],
          '#required'      => TRUE,
        );

        $form['Contact_Content']['table4']['R4.3']['Contact_Email'] = array(
          '#type'          => 'email',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Kontaktperson / E-mail contact person'),
          '#default_value' => $storedValues['contact_email']?? $defaultValues['contact_email'],
          '#required'      => TRUE,
          );


    // Fields: Support and Hosting
    $form['Support_and_Hosting'] = array(
      '#type'  => 'details',
      '#title' => t('Betreuung und Hosting / Support and Hosting'),
      '#open'  => TRUE,
      );

      $form['Support_and_Hosting']['table5'] = array(
        '#type'   => 'table',
        '#title'  => 'Support and Hosting',
        '#header' => array('German', 'English'),
      );

        $form['Support_and_Hosting']['table5']['R5.1']['Sup_Institute_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institut'),
          '#default_value' => $storedValues['sup_institute_de']?? $defaultValues['sup_institute_de'],
          '#required'      => TRUE,
          );

        $form['Support_and_Hosting']['table5']['R5.1']['Sup_Institute_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institute'),
          '#default_value' => $storedValues['sup_institute_en']?? $defaultValues['sup_institute_en'],
          '#required'      => TRUE,
          );

        $form['Support_and_Hosting']['table5']['R5.2']['Sup_URL'] = array(
          '#type'          => 'link',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Homepage Betreuung / Hompage support'),
          '#default_value' => $storedValues['sup_url']?? $defaultValues['sup_url'],
          '#required'      => TRUE,
          );

        $form['Support_and_Hosting']['table5']['R5.3']['Sup_Email'] = array(
          '#type'          => 'email',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Betreuung / E-mail support'),
          '#default_value' => $storedValues['sup_email']?? t('sup_email'),
          '#required'      => TRUE,
          );

        $form['Support_and_Hosting']['table5']['R5.4']['Sup_Staff'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Mitarbeitende ("; " als Separator - e.g. "Alan Angestellter; Beatrice Beispiel;...") / Staff ("; " as separator - e.g. "Eda Employee; Sujin Staff;...")'),
          '#default_value' =>  $storedValues['sup_staff_array']?? $defaultValues['sup_staff_array'],
          '#required'      => TRUE,
          );



    // Fields: Supervisory Authority
    $form['Supervisory_Authority'] = array(
      '#type'  => 'details',
      '#title' => t('Zuständige Aufsichtsbehörde / Supervisory Authority'),
      '#open'  => TRUE,
      );

      $form['Supervisory_Authority']['table6'] = array(
        '#type'   => 'table',
        '#title'  => 'Supervisory Authority',
        '#header' => array('German', 'English'),
      );

        $form['Supervisory_Authority']['table6']['R6.1']['Auth_Name_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Behördenname'),
          '#default_value' => $storedValues['auth_name_de']?? $defaultValues['auth_name_de'],
          '#required'      => TRUE,
          );

        $form['Supervisory_Authority']['table6']['R6.1']['Auth_Name_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name supervisory authority'),
          '#default_value' => $storedValues['auth_name_en']?? $defaultValues['auth_name_en'],
          '#required'      => TRUE,
          );

        $form['Supervisory_Authority']['table6']['R6.2']['Auth_Address'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Straße und Hausnummer / Street name and house number'),
          '#default_value' => $storedValues['auth_address']?? $defaultValues['auth_address'],
          '#required'      => TRUE,
          );

        $form['Supervisory_Authority']['table6']['R6.3']['Auth_PLZ'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('PLZ / Postal code'),
          '#default_value' => $storedValues['auth_plz']?? $defaultValues['auth_plz'],
          '#required'      => TRUE,
          );

        $form['Supervisory_Authority']['table6']['R6.4']['Auth_City_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Ort'),
          '#default_value' => $storedValues['auth_city_de']?? $defaultValues['auth_city_de'],
          '#required'      => TRUE,
          );

        $form['Supervisory_Authority']['table6']['R6.4']['Auth_City_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
          '#default_value' => $storedValues['auth_city_en']?? $defaultValues['auth_city_en'],
          '#required'      => TRUE,
          );

        $form['Supervisory_Authority']['table6']['R6.5']['Auth_URL'] = array(
          '#type'          => 'link',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('URL Behörde / URL Supervisory Authority'),
          '#default_value' => $storedValues['auth_url']?? $defaultValues['auth_url'],
          '#required'      => TRUE,
          );


    // Fields: Copyright
    $form['Copyright'] = array(
      '#type'  => 'details',
      '#title' => t('Nutzungsbedingungen (Urheberrecht) / Copyright'),
      '#open'  => TRUE,
      );

        $form['Copyright']['table7'] = array(
          '#type'   => 'table',
          '#title'  => 'Copyright',
          '#header' => array('German', 'English'),
        );

          $form['Copyright']['table7']['R7.1']['Licence_Title_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Nutzungsrechte / Lizenztitel'),
            '#default_value' => $storedValues['licence_title_de']?? t(''),
            '#required'      => FALSE,
            );

          $form['Copyright']['table7']['R7.1']['Licence_Title_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Right of use / License title'),
            '#default_value' => $storedValues['licence_title_en']?? t(''),
            '#required'      => FALSE,
            );

          $form['Copyright']['table7']['R7.2']['Licence_URL'] = array(
            '#type'          => 'link',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Lizenz URL / Licence URL'),
            '#default_value' => $storedValues['licence_url']?? t(''),
            '#required'      => FALSE,
            );

          $form['Copyright']['table7']['R7.3']['Use_FAU_Design_Template'] = array(
            '#type'          => 'checkbox',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Verwendung FAU Corporate Design / Use of FAU corporate design'),
            '#default_value' => $storedValues['use_fau_temp']?? (FALSE),
            '#required'      => FALSE,
            );

          $form['Copyright']['table7']['R7.4']['No_Default_Text'] = array(
            '#type'          => 'checkbox',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('\'Eigene Angaben\' ANSTATT Standardtext in \'Nutzungsbedingungen\' (Text zu nicht urheberrechtlich geschützten Inhalten und Privatgebrauch wird weiterhin angezeigt)'),
            '#default_value' => $storedValues['no_default_txt']?? (FALSE),
            '#required'      => FALSE,
            );

          $form['Copyright']['table7']['R7.5']['Custom_Licence_Text_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Eigene Angaben'),
            '#default_value' => $storedValues['cust_licence_txt_de']?? t(''),
            '#required'      => FALSE,
            );

          $form['Copyright']['table7']['R7.5']['Custom_Licence_Text_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Custom Information'),
            '#default_value' => $storedValues['cust_licence_txt_en']?? t(''),
            '#required'      => FALSE,
            );


    // Field: Exclusion of Liability
    $form['Exclusion_Liab'] = array(
      '#type'  => 'details',
      '#title' => t('Haftungsausschluss / Exclusion of Liability'),
      '#open'  => TRUE,
      );

        $form['Exclusion_Liab']['table8'] = array(
          '#type'   => 'table',
          '#title'  => 'Exclusion Liability',
          '#header' => array('German', 'English'),
        );

          $form['Exclusion_Liab']['table8']['R8.1']['Custom_Exclusion_Liab_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Eigene Angaben zum Haftungsausschluss'),
            '#default_value' => $storedValues['cust_exclusion_de']?? t(''),
            '#required'      => FALSE,
            );

          $form['Exclusion_Liab']['table8']['R8.1']['Custom_Exclusion_Liab_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Custom information on liability exclusion'),
            '#default_value' => $storedValues['cust_exclusion_en']?? t(''),
            '#required'      => FALSE,
            );


    // Field and Checkbox: Diclaimer External Links
    $form['Disclaimer'] = array(
      '#type'  => 'details',
      '#title' => t('Haftung für Links / Disclaimer External Links'),
      '#open'  => TRUE,
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
            '#default_value' => $storedValues['show_disclaim']?? (FALSE),
            '#required'      => FALSE,
            );

          $form['Disclaimer']['table9']['R9.2']['Custom_Disclaimer_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Eigene Angaben zur Haftung für Links (Feld leer lassen, um Standardtext anzuzeigen)'),
            '#default_value' => $storedValues['cust_disclaim_de']?? t(''),
            '#required'      => FALSE,
            );

          $form['Disclaimer']['table9']['R9.2']['Custom_Disclaimer_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Custom information on liability for links (leave empty to display default text)'),
            '#default_value' => $storedValues['cust_disclaim_en']?? t(''),
            '#required'      => FALSE,
            );

    // Field: Timestamp
    $form['Timestamp'] = array(
      '#type'  => 'details',
      '#title' => t('Erstellungsdatum / Generation Date'),
      '#open'  => TRUE,
      );

        $current_timestamp = \Drupal::time()->getCurrentTime();
        $todays_date = \Drupal::service('date.formatter')->format($current_timestamp, 'custom', 'Y-m-d');

        $form['Timestamp']['Date'] = array(
          '#type'          => 'date',
          '#title'         => t('Erstellungsdatum / Generation Date'),
          '#default_value' => $todays_date,
          '#required'      => TRUE,
        );

    // Disclaimer
        $form['notice'] = array(
          '#type'   => 'item',
          '#prefix' => '<br /><p><strong>',
          '#suffix' => '</strong></p><br />',
          '#markup' => t('Es wird keine Haftung für die Korrektheit der eingegebenen Daten übernommen. / No liability is assumed for the correctness of the data entered.<br />
                          Bitte überprüfen Sie nach der Generierung die erstellten Seiten auf Richtigkeit. / Please verify the accuracy of the generated pages.'),
          );


// Sumbit Form and Populate Template
    $form['submit_button'] = array(
        '#type'  => 'submit',
        '#value' => t('Erstellen / Generate'),
        );

// Reset Form Contents to Default
    $form['reset_button'] = array(
      '#class' => 'button',
      '#type' => 'submit',
      '#value' => t('Zurücksetzen / Reset to default'),
      '#submit' => [[$this, 'resetAllValues']],
      );

    return $form;
  }


  /**
   * Called when user hits reset button
   * {@inheritdoc}
   */
  public function resetAllValues(array &$valuesStoredInState, FormStateInterface $form_state) {
    if(!empty(\Drupal::state()->get('wisski_impressum.legalNotice'))){
      \Drupal::state()->delete('wisski_impressum.legalNotice');
    }
  }


  /**
   * Called when the user hits submit button
   * {@inheritdoc}
   */

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $title_de             = $values['table1']['R1.1']['Title_DE'];
    $title_en             = $values['table1']['R1.1']['Title_EN'];
    $wisski_url           = $values['table1']['R1.2']['WissKI_URL'];
    $alias_de             = $values['table1']['R1.3']['Alias_DE'];
    $alias_en             = $values['table1']['R1.3']['Alias_EN'];
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
    $sup_url              = $values['table5']['R5.2']['Sup_URL'];
    $sup_email            = $values['table5']['R5.3']['Sup_Email'];
    $sup_staff            = $values['table5']['R5.4']['Sup_Staff'];
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

    $data = [
              'wisski_url'             => $wisski_url,
              'project_name_de'        => $project_name_de,
              'project_name_en'        => $project_name_en,
              'pub_institute_de'       => $pub_institute_de,
              'pub_institute_en'       => $pub_institute_en,
              'pub_name'               => $pub_name,
              'pub_address'            => $pub_address,
              'pub_plz'                => $pub_plz,
              'pub_city_de'            => $pub_city_de,
              'pub_city_en'            => $pub_city_en,
              'pub_email'              => $pub_email,
              'cust_legal_form_de'     => $cust_legal_form_de,
              'cust_legal_form_en'     => $cust_legal_form_en,
              'contact_name'           => $contact_name,
              'contact_phone'          => $contact_phone,
              'contact_email'          => $contact_email,
              'sup_institute_de'       => $sup_institute_de,
              'sup_institute_en'       => $sup_institute_en,
              'sup_url'                => $sup_url,
              'sup_email'              => $sup_email,
              'sup_staff_array'        => $sup_staff_array,
              'auth_name_de'           => $auth_name_de,
              'auth_name_en'           => $auth_name_en,
              'auth_address'           => $auth_address,
              'auth_plz'               => $auth_plz,
              'auth_city_de'           => $auth_city_de,
              'auth_city_en'           => $auth_city_en,
              'auth_url'               => $auth_url,
              'licence_title_de'       => $licence_title_de,
              'licence_title_en'       => $licence_title_en,
              'licence_url'            => $licence_url,
              'use_fau_temp'           => $use_fau_temp,
              'no_default_txt'         => $no_default_txt,
              'cust_licence_txt_de'    => $cust_licence_txt_de,
              'cust_licence_txt_en'    => $cust_licence_txt_en,
              'cust_exclusion_de'      => $cust_exclusion_de,
              'cust_exclusion_en'      => $cust_exclusion_en,
              'show_disclaim'          => $show_disclaim,
              'cust_disclaim_de'       => $cust_disclaim_de,
              'cust_disclaim_en'       => $cust_disclaim_en,
              'date'                   => $date,
    ];


    // Call Service:

    $success =  \Drupal::service('wisski_impressum.generator')->generateImpressum($data, $title_de, $title_en, $alias_de, $alias_en);

    // Display Success Message:
    if($success){
      \Drupal::messenger()->addMessage($this->t('<a href="/'.$alias_de.'">Deutsches Impressum erfolgreich erstellt / German legal notice generated successfully</a>'), 'status', TRUE);
      \Drupal::messenger()->addMessage($this->t('<a href="/'.$alias_en.'">Englisches Impressum erfolgreich erstellt / English legal notice generated successfully</a>'), 'status', TRUE);
    } else {
      \Drupal::messenger()->addMessage($this->t('Leider ist ein Fehler aufgetreten'), 'status', TRUE);
    }
  }
}