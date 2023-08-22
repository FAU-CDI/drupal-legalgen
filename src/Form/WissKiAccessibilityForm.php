<?php

namespace Drupal\wisski_impressum\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Drupal\wisski_impressum\Generator\WisskiLegalGenerator;


use \Drupal\node\Entity\Node;


/**
 * Configure example settings for this site.
 */
class WissKiAccessibilityForm extends FormBase {

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
    if(!empty(\Drupal::state()->get('wisski_impressum.accessibility'))){
      return \Drupal::state()->get('wisski_impressum.accessibility');
    }else{
      return NULL;
    }
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Fields:
    // type of render array element
    // see https://api.drupal.org/api/drupal/elements/8.2.x for available elements

    $storedValues = $this->getStateValues();

    // Disclaimer
    $form['text_header'] = array(
      '#prefix' => '<p><strong>',
      '#suffix' => '</strong></p>',
      '#markup' => t('Das CDI ist nicht für die Korrektheit der eingegebenen Daten verantwortlich. Bitte überprüfen Sie nach der Generierung die erstellten Seiten auf Richtigkeit.'),
      '#weight' => -100,
      );


    // Display Link to FAU Accessibility Guidelines (as reference)
    $form['Guidelines'] = array(
      '#type'  => 'details',
      '#title' => t('Leitfaden zur digitalen Barrierefreiheit für Hochschulen für Angewandte Wissenschaft in Bayern'),
      '#open'  => false,
      );

        $form['Guidelines']['Complete_Guidelines_WS'] = array(
          '#type'   => 'item',
          '#markup' => '<a href="https://www.wordpress.rrze.fau.de/tutorials/a11y/">Leitfaden zur digitalen Barrierefreiheit (FAU Webseite)</a>',
          );

        $form['Guidelines']['Complete_Guidelines_GH'] = array(
          '#type'   => 'item',
          '#markup' => '<a href="https://github.com/RZ-BY/Leitfaden-Barrierefreiheit/">Leitfaden zur digitalen Barrierefreiheit (RRZE GitHub)</a>',
          );


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

            $form['General']['table1']['R1.1']['title'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Seitentitel'),
              '#default_value' => (!empty($storedValues['title']))? $storedValues['title'] : t('Barrierefreiheit'),
              '#required'      => TRUE,
              );

            $form['General']['table1']['R1.1']['Title_EN'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Page title'),
              '#default_value' => (!empty($storedValues['title_en']))? $storedValues['title_en'] : t('Accessibility'),
              '#required'      => TRUE,
              );

            $form['General']['table1']['R1.2']['WissKI_URL'] = array(
              '#type'          => 'textfield',
              '#wrapper_attributes' => [
                'colspan' =>  2,
              ],
              '#title'         => t('WissKI URL'),
              '#default_value' => (!empty($storedValues['wisski_url']))? $storedValues['wisski_url'] : t('https://mehrdad.wisski.data.fau.de/'),
              '#required'      => TRUE,
              );


            $form['General']['table1']['R1.3']['alias'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Seiten-Alias'),
              '#default_value' => (!empty($storedValues['alias']))? $storedValues['alias'] : t('barrierefreiheit'),
              '#required'      => TRUE,
              );

            $form['General']['table1']['R1.3']['alias_EN'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Page alias'),
              '#default_value' => (!empty($storedValues['alias_en']))? $storedValues['alias_en'] : t('accessibility'),
              '#required'      => TRUE,
              );


            $form['General']['table1']['R1.4']['Project_Name_DE'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Projektname'),
              '#default_value' => (!empty($valuesFromLegalNotice['project_name_en']))? $valuesFromLegalNotice['project_name_en'] : '',
              '#required'      => TRUE,
              );

            $form['General']['table1']['R1.4']['Project_Name_EN'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Project name'),
              '#default_value' => (!empty($valuesFromLegalNotice['project_name_en']))? $valuesFromLegalNotice['project_name_en'] : '',
              '#required'      => TRUE,
              );


    // Display Link to FAU Accessibility Guidelines for Tests (as reference)
    $form['Guidelines_Tests'] = array(
      '#type'  => 'details',
      '#title' => t('Leitfaden zu Tests der digitalen Barrierefreiheit'),
      '#open'  => false,
      );

        $form['Guidelines_Tests']['Complete_Guidelines'] = array(
          '#type'   => 'item',
          '#markup' => '<a href="https://www.wordpress.rrze.fau.de/tutorials/a11y/tests-der-barrierefreiheit/">Leitfaden der FAU zu Tests der digitalen Barrierefreiheit</a>',
          );



    // Fields: Conformity
    $form['Conformity'] = array(
      '#type'        => 'details',
      '#title'       => t('Konformität / Conformity'),
      '#open'        => TRUE,
      );

      $form['Conformity']['table2'] = array(
        '#type' => 'table',
        '#title' => 'Conformity',
        '#header' => array('German', 'English'),
      );

        $form['Conformity']['table2']['R2.1']['Conformity_Status'] = array(
          '#type'          => 'select',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Konformitätsstatus / Conformity status'),
          '#required'      => TRUE,
          '#options'       => [
            'Completely compliant' => $this->t('Completely compliant'),
            'Partially compliant'   => $this->t('Partially compliant'),
          ],
          '#default_value' => (!empty($storedValues['status']))? $storedValues['status'] : t('Completely compliant'),
          );


        $form['Conformity']['table2']['R2.2']['Assessment_Methodology_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Methodik der Prüfung'),
          '#default_value' => (!empty($storedValues['methodology_de']))? $storedValues['methodology_de'] : t('Selbstbewertung'),
          '#required'      => TRUE,
          );

        $form['Conformity']['table2']['R2.2']['Assessment_Methodology_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Assessment methodology'),
          '#default_value' => (!empty($storedValues['methodology_en']))? $storedValues['methodology_en'] : t('Self-assessment'),
          '#required'      => TRUE,
          );

        $form['Conformity']['table2']['R2.3']['Creation_Date'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Erstellungsdatum Bericht / Report Creation Date'),
          '#default_value' => (!empty($storedValues['creation_date']))? $storedValues['creation_date'] : t('TT.MM.JJJJ'),
          '#required'      => TRUE,
          );

        $form['Conformity']['table2']['R2.4']['Last_Revision_Date'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Datum letzte Prüfung / Date of last revision'),
          '#default_value' => (!empty($storedValues['last_revis_date']))? $storedValues['last_revis_date'] : t('TT.MM.JJJJ'),
          '#required'      => TRUE,
          );

        $form['Conformity']['table2']['R2.5']['Report_URL'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Bericht URL / Report URL'),
          '#default_value' => (!empty($storedValues['report_url']))? $storedValues['report_url'] : t('https://wave.webaim.org/report#/cdi.fau.de'),
          '#required'      => false,
          );


    // Fields: Contents Not Accessible to All
    $form['Issues'] = array(
      '#type'        => 'details',
      '#title'       => t('Nicht barrierefrei zugängliche Inhalte / Contents Not Accessible to All'),
      '#open'        => TRUE,
      );

      $form['Issues']['table3'] = array(
        '#type' => 'table',
        '#title' => 'Issues',
        '#header' => array('German', 'English'),
      );

        $form['Issues']['table3']['R3.1']['Known_Issues_DE'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Nicht barrierefrei zugängliche Inhalte ("; " als Separator für Probleme)'),
          '#default_value'  => (!empty($storedValues['known_issues_de']))? $storedValues['known_issues_de'] : t('Aufzählung; von; nicht; barrierefreien; Inhalten'),
          '#required'       => false,
          );

        $form['Issues']['table3']['R3.1']['Known_Issues_EN'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Content that is not accessible to all ("; " as separator for problems)'),
          '#default_value'  => (!empty($storedValues['known_issues_en']))? $storedValues['known_issues_en'] : t('List; of; contents; which; are; not; barrier-free'),
          '#required'       => false,
          );

        $form['Issues']['table3']['R3.2']['Justification_Statement_DE'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Begründung ("; " als Separator für Unterpunkte)'),
          '#default_value'  => (!empty($storedValues['statement_de']))? $storedValues['statement_de'] : t('Aufzählung; verschiedener; Begründungen'),
          '#required'       => false,
          );

        $form['Issues']['table3']['R3.2']['Justification_Statement_EN'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Justification ("; " as separator for subitems)'),
          '#default_value'  => (!empty($storedValues['statement_en']))? $storedValues['statement_en'] : t('list; of; individual; justifactions'),
          '#required'       => false,
          );

        $form['Issues']['table3']['R3.3']['Alternative_Access_DE'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Alternative Zugangswege ("; " als Separator für Unterpunkte)'),
          '#default_value'  => (!empty($storedValues['alternatives_de']))? $storedValues['alternatives_de'] : t('Auflistung; von; Alternativen'),
          '#required'       => false,
          );

        $form['Issues']['table3']['R3.3']['Alternative_Access_EN'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Alternative access paths ("; " as separator for subitems)'),
          '#default_value'  => (!empty($storedValues['alternatives_en']))? $storedValues['alternatives_en'] : t('List; of; alternatives'),
          '#required'       => false,
          );


    // Fields: Contact Person
    $form['Contact_Accessibility'] = array(
      '#type'  => 'details',
      '#title' => t('Herausgebende / Publisher'),
      '#open'  => TRUE,
      );

      $form['Contact_Accessibility']['table4'] = array(
        '#type' => 'table',
        '#title' => 'Publisher',
        '#header' => array('German', 'English'),
      );

        $form['Contact_Content']['table4']['R4.1']['Contact_Access_Name'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Name Kontaktperson / Name contact person'),
          '#default_value' => (!empty($storedValues['contact_access_name']))? $storedValues['contact_access_name'] : $valuesFromLegalNotice['contact_name'],
          '#required'      => TRUE,
          );

        $form['Contact_Content']['table4']['R4.2']['Contact_Access_Phone'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Telefonnummer Kontaktperson / Phone contact person'),
          '#default_value' => (!empty($storedValues['contact_access_phone']))? $storedValues['contact_access_phone'] : $valuesFromLegalNotice['contact_phone'],
          '#required'      => TRUE,
        );

        $form['Contact_Content']['table4']['R4.3']['Contact_Access_Email'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Kontaktperson / E-mail contact person'),
          '#default_value' => (!empty($storedValues['contact_access_email']))? $storedValues['contact_access_email'] : $valuesFromLegalNotice['contact_email'],
          '#required'      => TRUE,
          );

    // Fields: Suppport and Hosting
    $form['Support_and_Hosting'] = array(
      '#type'   => 'details',
      '#title'  => t('Betreuung und Hosting / Support and Hosting'),
      '#open'   => TRUE,
      );

      $form['Support_and_Hosting']['table5'] = array(
        '#type' => 'table',
        '#title' => 'General',
        '#header' => array('German', 'English'),
      );

        $form['Support_and_Hosting']['table5']['R5.1']['Sup_Institute_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institut'),
          '#default_value' => (!empty($storedValues['sup_institute_de']))? $storedValues['sup_institute_de'] : t('FAU Competence Center for Research Data and Information'),
          '#required'      => TRUE,
          );

        $form['Support_and_Hosting']['table5']['R5.1']['Sup_Institute_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institute'),
          '#default_value' => (!empty($storedValues['sup_institute_en']))? $storedValues['sup_institute_en'] : t('FAU Competence Center for Research Data and Information'),
          '#required'      => TRUE,
          );

        $form['Support_and_Hosting']['table5']['R5.2']['Sup_Email'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Betreuung / E-mail support and hosting'),
          '#default_value' => (!empty($storedValues['sup_email']))? $storedValues['sup_email'] : t('cdi-wisski-support@fau.de'),
          '#required'      => TRUE,
          );

        $form['Support_and_Hosting']['table5']['R5.3']['Sup_Address'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Straße und Hausnummer / Street name and house number'),
          '#default_value' => (!empty($storedValues['sup_address']))? $storedValues['sup_address'] : t('Werner-von-Siemens-Straße 61'),
          '#required'      => TRUE,
          );

        $form['Support_and_Hosting']['table5']['R5.4']['Sup_PLZ'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('PLZ / Postal code'),
          '#default_value' => (!empty($storedValues['sup_plz']))? $storedValues['sup_plz'] : t('91052'),
          '#required'      => TRUE,
          );

        $form['Support_and_Hosting']['table5']['R5.5']['Sup_City_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Ort'),
          '#default_value' => (!empty($storedValues['sup_city_de']))? $storedValues['sup_city_de'] : t('Erlangen'),
          '#required'      => TRUE,
          );

        $form['Support_and_Hosting']['table5']['R5.5']['Sup_City_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
          '#default_value' => (!empty($storedValues['sup_city_en']))? $storedValues['sup_city_en'] : t('Erlangen'),
          '#required'      => TRUE,
          );

        $form['Support_and_Hosting']['table5']['R5.6']['Sup_URL'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Homepage-Betreuung URL / URL support and hosting'),
          '#default_value' => (!empty($storedValues['sup_url']))? $storedValues['sup_url'] : t('https://www.cdi.fau.de/'),
          '#required'      => TRUE,
          );


    // Fields: Enforcement Oversight Body
    $form['Oversight Body'] = array(
      '#type'   => 'details',
      '#title'  => t('Aufsichtsbehörde / Enforcement Oversight Body'),
      '#open'   => TRUE,
      );

      $form['Oversight Body']['table6'] = array(
        '#type' => 'table',
        '#title' => 'General',
        '#header' => array('German', 'English'),
      );

        $form['Oversight Body']['table6']['R6.1']['Oversight_Agency_Name_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name der Behörde'),
          '#default_value' => (!empty($storedValues['overs_name_de']))? $storedValues['overs_name_de'] : t('Landesamt für Digitalisierung, Breitband und Vermessung'),
          '#required'      => TRUE,
          );

        $form['Oversight Body']['table6']['R6.1']['Oversight_Agency_Name_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name of oversight agency'),
          '#default_value' => (!empty($storedValues['overs_name_en']))? $storedValues['overs_name_en'] : t('Agency for Digitalisation, High-Speed Internet and Surveying'),
          '#required'      => TRUE,
          );

        $form['Oversight Body']['table6']['R6.2']['Oversight_Agency_Dept_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name der Abteilung'),
          '#default_value' => (!empty($storedValues['overs_dept_de']))? $storedValues['overs_dept_de'] : t('IT-Dienstleistungszentrum des Freistaats Bayern Durchsetzungs- und Überwachungsstelle für barrierefreie Informationstechnik'),
          '#required'      => TRUE,
          );

        $form['Oversight Body']['table6']['R6.2']['Oversight_Agency_Dept_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name of department'),
          '#default_value' => (!empty($storedValues['overs_dept_en']))? $storedValues['overs_dept_en'] : t('IT Service Center of the Free State of Bavaria Enforcement and Monitoring Body for Barrier-free Information Technology'),
          '#required'      => TRUE,
          );

        $form['Oversight Body']['table6']['R6.3']['Oversight_Address'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Straße und Hausnummer / Street name and house number'),
          '#default_value' => (!empty($storedValues['overs_address']))? $storedValues['overs_address'] : t('St.-Martin-Straße 47'),
          '#required'      => TRUE,
        );

        $form['Oversight Body']['table6']['R6.4']['Oversight_PLZ'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('PLZ / Postal Code'),
          '#default_value' => (!empty($storedValues['overs_plz']))? $storedValues['overs_plz'] : t('81541'),
          '#required'      => TRUE,
          );

        $form['Oversight Body']['table6']['R6.5']['Oversight_City_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Ort'),
          '#default_value' => (!empty($storedValues['overs_city_de']))? $storedValues['overs_city_de'] : t('München'),
          '#required'      => TRUE,
          );

        $form['Oversight Body']['table6']['R6.5']['Oversight_City_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
          '#default_value' => (!empty($storedValues['overs_city_en']))? $storedValues['overs_city_en'] : t('Munich'),
          '#required'      => TRUE,
          );

        $form['Oversight Body']['table6']['R6.6']['Oversight_Phone'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Telefon Aufsichtsbehörde/ Phone oversight agency'),
          '#default_value' => (!empty($storedValues['overs_phone']))? $storedValues['overs_phone'] : t('+49 89 2129-1111'),
          '#required'      => TRUE,
          );

        $form['Oversight Body']['table6']['R6.7']['Oversight_Email'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Aufsichtsbehörde / E-mail oversight agency'),
          '#default_value' => (!empty($storedValues['overs_email']))? $storedValues['overs_email'] : t('bitv@bayern.de'),
          '#required'      => TRUE,
          );

        $form['Oversight Body']['table6']['R6.8']['Oversight_URL'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Webseite / Website '),
          '#default_value' => (!empty($storedValues['overs_url']))? $storedValues['overs_url'] : t('https://www.ldbv.bayern.de/digitalisierung/bitv.html'),
          '#required'      => TRUE,
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


// Submit Form Contents and Populate Template
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
    if(!empty(\Drupal::state()->get('wisski_impressum.accessibility'))){
      \Drupal::state()->delete('wisski_impressum.accessibility');
    }
  }


  /**
   * Called when the user hits submit button
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $title_en              = $values['table1']['R1.1']['Title_EN'];
    $title                 = $values['table1']['R1.1']['title'];
    $wisski_url            = $values['table1']['R1.2']['WissKI_URL'];
    $alias                 = $values['table1']['R1.3']['alias'];
    $alias_en              = $values['table1']['R1.3']['alias_EN'];
    $project_name_de       = $values['table1']['R1.4']['Project_Name_DE'];
    $project_name_en       = $values['table1']['R1.4']['Project_Name_EN'];
    $status                = $values['table2']['R2.1']['Conformity_Status'];
    $methodology_de        = $values['table2']['R2.2']['Assessment_Methodology_DE'];
    $methodology_en        = $values['table2']['R2.2']['Assessment_Methodology_EN'];
    $creation_date         = $values['table2']['R2.3']['Creation_Date'];
    $last_revis_date       = $values['table2']['R2.4']['Last_Revision_Date'];
    $report_url            = $values['table2']['R2.5']['Report_URL'];
    $known_issues_de       = $values['table3']['R3.1']['Known_Issues_DE'];
    $known_issues_en       = $values['table3']['R3.1']['Known_Issues_EN'];
    $statement_de          = $values['table3']['R3.2']['Justification_Statement_DE'];
    $statement_en          = $values['table3']['R3.2']['Justification_Statement_EN'];
    $alternatives_de       = $values['table3']['R3.3']['Alternative_Access_DE'];
    $alternatives_en       = $values['table3']['R3.3']['Alternative_Access_EN'];
    $contact_access_name   = $values['table4']['R4.1']['Contact_Access_Name'];
    $contact_access_phone  = $values['table4']['R4.2']['Contact_Access_Phone'];
    $contact_access_email  = $values['table4']['R4.3']['Contact_Access_Email'];
    $sup_institute_de      = $values['table5']['R5.1']['Sup_Institute_DE'];
    $sup_institute_en      = $values['table5']['R5.1']['Sup_Institute_EN'];
    $sup_email             = $values['table5']['R5.2']['Sup_Email'];
    $sup_address           = $values['table5']['R5.3']['Sup_Address'];
    $sup_plz               = $values['table5']['R5.4']['Sup_PLZ'];
    $sup_city_de           = $values['table5']['R5.5']['Sup_City_DE'];
    $sup_city_en           = $values['table5']['R5.5']['Sup_City_EN'];
    $sup_url               = $values['table5']['R5.6']['Sup_URL'];
    $overs_name_de         = $values['table6']['R6.1']['Oversight_Agency_Name_DE'];
    $overs_name_en         = $values['table6']['R6.1']['Oversight_Agency_Name_EN'];
    $overs_dept_de         = $values['table6']['R6.2']['Oversight_Agency_Dept_DE'];
    $overs_dept_en         = $values['table6']['R6.2']['Oversight_Agency_Dept_EN'];
    $overs_address         = $values['table6']['R6.3']['Oversight_Address'];
    $overs_plz             = $values['table6']['R6.4']['Oversight_PLZ'];
    $overs_city_de         = $values['table6']['R6.5']['Oversight_City_DE'];
    $overs_city_en         = $values['table6']['R6.5']['Oversight_City_EN'];
    $overs_phone           = $values['table6']['R6.6']['Oversight_Phone'];
    $overs_email           = $values['table6']['R6.7']['Oversight_Email'];
    $overs_url             = $values['table6']['R6.8']['Oversight_URL'];
    $date                  = $values['Date'];

    $issues_array_de = explode('; ', $known_issues_de);
    $alternatives_array_de = explode('; ', $alternatives_de);
    $statement_array_de = explode('; ', $statement_de);

    $issues_array_en = explode('; ', $known_issues_en);
    $alternatives_array_en = explode('; ', $alternatives_en);
    $statement_array_en = explode('; ', $statement_en);



    $template = [
      '#theme'                 => 'barrierefreiheit_template',
      '#wisski_url'               => $wisski_url,
      '#project_name_de'          => $project_name_de,
      '#status'                   => $status,
      '#methodology_de'           => $methodology_de,
      '#creation_date'            => $creation_date,
      '#last_revis_date'          => $last_revis_date,
      '#report_url'               => $report_url,
      '#known_issues_de'          => $known_issues_de,
      '#issues_array_de'          => $issues_array_de,
      '#statement_de'             => $statement_de,
      '#statement_array_de'       => $statement_array_de,
      '#alternatives_de'          => $alternatives_de,
      '#alternatives_array_de'    => $alternatives_array_de,
      '#contact_access_name'      => $contact_access_name,
      '#contact_access_phone'     => $contact_access_phone,
      '#contact_access_email'     => $contact_access_email,
      '#sup_institute_de'         => $sup_institute_de,
      '#sup_email'                => $sup_email,
      '#sup_url'                  => $sup_url,
      '#sup_address'              => $sup_address,
      '#sup_plz'                  => $sup_plz,
      '#sup_city_de'              => $sup_city_de,
      '#overs_name_de'            => $overs_name_de,
      '#overs_dept_de'            => $overs_dept_de,
      '#overs_address'            => $overs_address,
      '#overs_plz'                => $overs_plz,
      '#overs_city_de'            => $overs_city_de,
      '#overs_phone'              => $overs_phone,
      '#overs_email'              => $overs_email,
      '#overs_url'                => $overs_url,
      '#date'                     => $date,
    ];

    $deleteQuery = \Drupal::database()->delete('path_alias');
    $deleteQuery->condition('alias', '/'.$alias);
    $deleteQuery->execute();

    $html = \Drupal::service('renderer')->renderPlain($template);

    $this->generateNode($title, $html, $alias);
    \Drupal::messenger()->addMessage($this->t('<a href="/'.$alias.'">Deutsche Barrierefreiheitserklärung erfolgreich erstellt / German accessibility declaration generated successfully</a>'), 'status', TRUE);



    $template_en = [
      '#theme'                 => 'accessibility_template',
      '#wisski_url'               => $wisski_url,
      '#project_name_en'          => $project_name_en,
      '#status'                   => $status,
      '#methodology_en'           => $methodology_en,
      '#creation_date'            => $creation_date,
      '#last_revis_date'          => $last_revis_date,
      '#report_url'               => $report_url,
      '#known_issues_en'          => $known_issues_en,
      '#issues_array_en'          => $issues_array_en,
      '#statement_en'             => $statement_en,
      '#statement_array_en'       => $statement_array_en,
      '#alternatives_en'          => $alternatives_en,
      '#alternatives_array_en'    => $alternatives_array_en,
      '#contact_access_name'      => $contact_access_name,
      '#contact_access_phone'     => $contact_access_phone,
      '#contact_access_email'     => $contact_access_email,
      '#sup_institute_en'         => $sup_institute_en,
      '#sup_email'                => $sup_email,
      '#sup_url'                  => $sup_url,
      '#sup_address'              => $sup_address,
      '#sup_plz'                  => $sup_plz,
      '#sup_city_en'              => $sup_city_en,
      '#overs_name_en'            => $overs_name_en,
      '#overs_dept_en'            => $overs_dept_en,
      '#overs_address'            => $overs_address,
      '#overs_plz'                => $overs_plz,
      '#overs_city_en'            => $overs_city_en,
      '#overs_phone'              => $overs_phone,
      '#overs_email'              => $overs_email,
      '#overs_url'                => $overs_url,
      '#date'                     => $date,
    ];

    $deleteQuery = \Drupal::database()->delete('path_alias');
    $deleteQuery->condition('alias', '/'.$alias_en);
    $deleteQuery->execute();

    $html_en = \Drupal::service('renderer')->renderPlain($template_en);

    $this->generateNode($title_en, $html_en, $alias_en);
    \Drupal::messenger()->addMessage($this->t('<a href="/'.$alias_en.'">Englische Barrierefreiheitserklärung erfolgreich erstellt / English accessibility declaration generated successfully</a>'), 'status', TRUE);


    $valuesStoredInState = array('wisski_impressum.accessibility' => array('title'                 => $title,
                                                                           'title_en'              => $title_en,
                                                                           'wisski_url'            => $wisski_url,
                                                                           'alias'                 => $alias,
                                                                           'alias_en'              => $alias_en,
                                                                           'project_name_de'       => $project_name_de,
                                                                           'project_name_en'       => $project_name_en,
                                                                           'status'                => $status,
                                                                           'methodology_de'        => $methodology_de,
                                                                           'methodology_en'        => $methodology_en,
                                                                           'creation_date'         => $creation_date,
                                                                           'last_revis_date'       => $last_revis_date,
                                                                           'report_url'            => $report_url,
                                                                           'known_issues_de'       => $known_issues_de,
                                                                           'known_issues_en'       => $known_issues_en,
                                                                           'issues_array_de'       => $issues_array_de,
                                                                           'issues_array_en'       => $issues_array_en,
                                                                           'statement_de'          => $statement_de,
                                                                           'statement_array_de'    => $statement_array_de,
                                                                           'alternatives_de'       => $alternatives_de,
                                                                           'statement_array_en'    => $statement_array_en,
                                                                           'alternatives_en'       => $alternatives_en,
                                                                           'alternatives_array_de' => $alternatives_array_de,
                                                                           'alternatives_array_en' => $alternatives_array_en,
                                                                           'contact_access_name'   => $contact_access_name,
                                                                           'contact_access_phone'  => $contact_access_phone,
                                                                           'contact_access_email'  => $contact_access_email,
                                                                           'sup_institute_de'      => $sup_institute_de,
                                                                           'sup_institute_en'      => $sup_institute_en,
                                                                           'sup_email'             => $sup_email,
                                                                           'sup_url'               => $sup_url,
                                                                           'sup_address'           => $sup_address,
                                                                           'sup_plz'               => $sup_plz,
                                                                           'sup_city_de'           => $sup_city_de,
                                                                           'overs_name_de'         => $overs_name_de,
                                                                           'overs_name_en'         => $overs_name_en,
                                                                           'overs_dept_de'         => $overs_dept_de,
                                                                           'overs_dept_en'         => $overs_dept_en,
                                                                           'overs_address'         => $overs_address,
                                                                           'overs_plz'             => $overs_plz,
                                                                           'overs_city_de'         => $overs_city_de,
                                                                           'overs_city_en'         => $overs_city_en,
                                                                           'overs_phone'           => $overs_phone,
                                                                           'overs_email'           => $overs_email,
                                                                           'overs_url'             => $overs_url,
                                                                           'date'                  => $date,

    )
    );

      // Store current German and English input in state:
      \Drupal::state()->setMultiple($valuesStoredInState);

  }


  function generateNode($title, $body, $alias){
    $node = Node::create([
        'type'    => 'page',
        'title'   => $title,
        'body'    => array(
          //'summary' => "this is the summary",
            'value'     => $body,
            'format'    => 'full_html',
          ),
        // set alias for page
        'path'    => array('alias' => "/$alias"),
    ]);
    $node->save();
  }

}


