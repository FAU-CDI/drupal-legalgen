# WissKI LegalGenerator


Generates Legal Notice, Accessibility Statement, and Privacy Statement in English and German. <br />Format and contents of the generated pages are based on the *[RRZE's 'Legal' WordPress plugin](https://github.com/RRZE-Webteam/rrze-legal/tree/main)* adapted to the requirements of WissKI.<br />
To enable generation in another language, add specifications for this language to the config and the respective template to the template folder.

A limited number of customization options are available (see below).
</br>
</br>

## Guarantee / Liability

We give no guarantee and assume no liability for the topicality and legal correctness of the legal statements generated via this module. It is incumbent on the user to check the data supplied as well as the generated pages.
</br>
</br>


## Table of Contents
1. [Service: LegalGenerator](#paragraph1)
    1. [Parameters](#subparagraph1.1)
    2. [Keys and Values](#subparagraph1.2)
       1. [Legal Notice](#subparagraph1.2.1)
          1. [Data Array](#subparagraph1.2.1.1)
          2. [Lang Array](#subparagraph1.2.1.2)
          3. [Intl Array](#subparagraph1.2.1.3)
       2. [Accessibility](#subparagraph1.2.2)
          1. [Data Array](#subparagraph1.2.2.1)
          2. [Lang Array](#subparagraph1.2.2.2)
          3. [Intl Array](#subparagraph1.2.2.3)
       3. [Privacy](#subparagraph1.2.3)
          1. [Data Array](#subparagraph1.2.3.1)
          2. [Lang Array](#subparagraph1.2.3.2)
          3. [Intl Array](#subparagraph1.2.3.3)

2. [Forms](#paragraph2)
3. [Required and Default Values](#paragraph3)
4. [Controller](#paragraph4)
5. [Config](#paragraph5)
6. [CSS](#paragraph6)

<br />
<br />

## 1. Service: LegalGenerator

Each of the three legal statements can be generated using the following function:

```PHP
generatePage(array $data, string $title, string $alias, string $page_type, string $lang, array $state_keys_lang, array $state_keys_intl)
```

</br>

### 1.1. Parameters

|Type|Key|Description|
|----:|----|---|
|array|**$data**|Should contain all values to be added to the page identified by the keys specified below<br /> See 1.2.[123]. a)|
|string|**$title**|Page title|
|string|**$alias**|URL Path|
|string|**$page_type**|Page type to be generated<br />Use: `'legal_notice'`, `'accessibility'` or `'privacy'`|
|string|**$lang**|Language code<br />Use: `'en'` or `'de'`|
|array|**$state_keys_lang**|All keys for language-specific values. See 1.2.[123]. b)|
|array|**$state_keys_intl**|All keys for language non-specific values. See 1.2.[123]. c)|

<br />

<br />

### 1.2. Keys and Values

#### 1.2.1. Legal Notice

##### 1.2.1.1. <u>Data Array</u>

|Section|Type|Key|Description|Required|Key Array|Example|
|----|----|----|-----|:---:|----|---|
|**General**|String|wisski_url|WissKI URL|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://projectname.wisski.data.fau.de/'|
||String|project_name|Name WissKI|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'WissKI Legalgen'|
|**Publisher**|String|publisher_institution|Name institution publisher||<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Beispieluniversität'|
||String|publisher_institute|Name institute publisher|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Beispielinstitut'|
||String|publisher_name|Name publisher|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Padmal Publisher'|
||String|publisher_address|Address publisher|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Main Street'|
||String|publisher_plz|Postal code publisher|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|publisher_city|City publisher|<span style="color:DarkCyan">&#x2611;</span>|'lang'|Anytown|
||email|publisher_email|E-mail publisher|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'padmal.publisher@mail.com'|
||String|custom_legal_form|**`Free text:`** `Leave empty if FAU specific text should be displayed.`</span><br /> `Custom text regarding legal form and representation`|<span style="color:IndianRed">&#x2612;</span>|'lang'|'Umiña University Anytown is a state institution and also a legal personality under public law according to Art. 4 Para. 1 BayHIG. It is legally represented by the President.'|
|**Contact Person Content**|String|contact_name|Name contact person content|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Centola Contactperson'|
||tel|contact_phone|Phone number contact person content|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'+49 171 123456'|
||email|contact_email|E-mail contact person content|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'centola.contactperson@mail.de'|
|**Support and Hosting**|String|support_institute|Name institute support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Center for Support and Hosting'|
||String|support_url|Support and hosting URL|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://support.hosting.com/'|
||email|support_email|E-mail support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'support.hosting@mail.de'|
||**`Array`**|support_staff_array|Individual staff members support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'lang'|array('Mauve Mitarbeiterin', 'Suiji Staff', 'Eda Employee')|
|**Supervisory Authority**|String|authority_name|Name supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Ministry of Supervision'|
||String|authority_address|Address supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Any Avenue'|
||String|authority_plz|Postal code supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|authority_city|City supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Anytown'|
||String|authority_url|Supervisory authority URL|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://supervisory.authority.com/'|
|**ID Numbers**|String|id_vat|VAT registration number|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'DE 123456789'|
||String|id_tax|Tax number|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'123/123/12345 (Tax and Revenue Office)'|
||String|id_duns|DUNS number|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'123456789'|
||String|id_eori|EORI number|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'DE1234567'|
|**Copyright**|String|licence_title_meta|Name copyright licence|<span style="color:IndianRed">&#x2612;</span>|'lang'|'CC Licence Title'|
||String|licence_url_meta|Copyright licence URL|<span style="color:IndianRed">&#x2612;</span>|'intl'|'https://creativecommons.org/licenses/some-licence-type'|
||String|licence_title_pics|Name copyright licence|<span style="color:IndianRed">&#x2612;</span>|'lang'|'CC Licence Title'|
||String|licence_url_pics|Copyright licence URL|<span style="color:IndianRed">&#x2612;</span>|'intl'|'https://creativecommons.org/licenses/some-licence-type'|
||**`Boolean`**|uses_fau_design|**`Checkbox:`** `INSTEAD OF default text display` costum information on copyright|<span style="color:IndianRed">&#x2612;</span>|'lang'|FALSE|
||**`Boolean`**|no_default_txt|**`Checkbox:`** WissKI uses FAU corporate design|<span style="color:IndianRed">&#x2612;</span>|'lang'|FALSE|
||String|custom_licence_txt|**`Free text:`** Costum information on copyright|<span style="color:IndianRed">&#x2612;</span>|'lang'|'Custom information on proprietary rights in general or for specific contents. Specifications on contents and works not protected under copyright law as well as on private use will always be displayed.'|
|**Exclusion of Liability**|String|custom_exclusion|**`Free text:`**|<span style="color:IndianRed">&#x2612;</span>|'lang'|'No guarantee, no liability.  Full reservation of the right to temporarily or indefinitely interrupt or terminate services.'|
|**Disclaimer External Links**|**`Boolean`**|hide_disclaimer|**`Checkbox:`** Section 'Links and references (disclaimer)' `should not be displayed`|<span style="color:IndianRed">&#x2612;</span>|'intl'|FALSE|
||String|custom_disclaimer|**`Free text:`** Custom information on liability for links|<span style="color:IndianRed">&#x2612;</span>|'lang'|'No responsibility and liability for links reference and related content.'|
|**Generation Date**|String|date|Page generation date `"YYYY-MM-DD"`|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'2014.07.10'|
|**Overwrite Consent**|**`Boolean`**|overwrite_consent|**`Checkbox:`** Permission to overwrite existing page|<span style="color:IndianRed">&#x2612;</span>|'lang'|FALSE|
<br />

##### **1.2.1.2. <u>Lang Array</u>**

```PHP
$state_keys_lang = array('title'                => '',
                         'alias'                => '',
                         'project_name'         => '',
                         'publisher_institute'  => '',
                         'publisher_name'       => '',
                         'publisher_city'       => '',
                         'custom_legal_form'    => '',
                         'contact_name'         => '',
                         'support_institute'    => '',
                         'support_staff_array'  => '',
                         'authority_name'       => '',
                         'authority_city'       => '',
                         'licence_title'        => '',
                         'uses_fau_design'      => '',
                         'custom_licence_txt'   => '',
                         'no_default_txt'       => '',
                         'custom_exclusion'     => '',
                         'custom_disclaimer'    => '',
                         'overwrite_consent'    => '',
                        );
```

<br />

##### **1.2.1.3. <u>Intl Array</u>**

```PHP
$state_keys_intl = array('wisski_url'         => '',
                         'publisher_address'  => '',
                         'publisher_plz'      => '',
                         'publisher_email'    => '',
                         'contact_phone'      => '',
                         'contact_email'      => '',
                         'support_url'        => '',
                         'support_email'      => '',
                         'licence_url'        => '',
                         'authority_address'  => '',
                         'authority_plz'      => '',
                         'authority_url'      => '',
                         'hide_disclaimer'    => '',
                         'date'               => '',
                        );
```

<br />
<br />

#### **1.2.2. Accessibility**

##### **1.2.2.1. <u>Data Array</u>**

|Section|Type|Key|Description|Required|Key Array|Example|
|----|----|----|----|:----:|----|---|
|**General**|String|wisski_url|WissKI URL|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://projectname.wisski.data.fau.de/'|
|**Conformity**|String|status|Dropdown: Either `"Completely compliant"` or `"Partially compliant"`|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Partially compliant'|
||String|methodology|Assessment methodology|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Example Assessment Methodology'|
||String|creation_date|Date assessment|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'13.07.2021'|
||String|last_revision_date|Last revision assessment|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'27.08.2023'|
||String|report_url|Report URL|<span style="color:IndianRed">&#x2612;</span>|'intl'|'https://reporturl.de'|
|**Contents Not Accessible to All**|**`Array`**|issues_array|**`Free text:`** Individual issue descriptions|<span style="color:IndianRed">&#x2612;</span>|'lang'|array('Inaccessible content 1', 'Inaccessible content 2', 'Inaccessible content 3')|
||**`Array`**|justification_array|**`Free text:`** Statements for each issue from issues_array|<span style="color:IndianRed">&#x2612;</span>|'lang'|array('Justification for inaccessibility of content 1', 'Justification for inaccessibility of content 2', 'Justification for inaccessibility of content 3')|
||**`Array`**|alternatives_array|**`Free text:`** Alternatives for contents not accessible|<span style="color:IndianRed">&#x2612;</span>|'lang'|array('Contact the contact person via phone.', 'Contact the contact person via e-mail')|
|**Contact Person**|String|contact_accessibility_name|Name contact person accessibility|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Centli Contactperson'|
||tel|contact_accessibility_phone|Phone number contact person accessibility|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'+49 1234 1234567'|
||email|contact_accessibility_email|E-mail contact person accessibility|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'centli.contactperson@mail.de'|
|**Support and Hosting**|String|support_institute|Name institute support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Support Center'|
||String|support_url|URL support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://support.de'|
||String|support_address|Address support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Main Street'|
||String|support_plz|Postal code support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|support_city|City support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Anytown'|
||email|support_email|E-mail support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'support@mail.de'|
|**Enforcement Oversight Body**|String|oversight_name|Name enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Example Agency'|
||String|oversight_dept|Department enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Example IT-Service Center'|
||String|oversight_address|Address enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Main Street'|
||String|oversight_plz|Postal code enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|oversight_city|City enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Anytown'|
||tel|oversight_phone|Phone number enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'+49 1234 67890'|
||email|oversight_email|E-mail enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'beispiellandesamt@email.de'|
||String|oversight_url|URL enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://enforcement.oversight.de'|
|**Generation Date**|String|date|Page generation date `"YYYY-MM-DD"`|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'2023.07.20'|
|**Overwrite Consent**|**`Boolean`**|overwrite_consent|**`Checkbox:`** Permission to overwrite existing page|<span style="color:IndianRed">&#x2612;</span>|'lang'|FALSE|
<br />

##### **1.2.2.2. <u>Lang Keys Array</u>**

```PHP
$state_keys_lang = array('title'                       => '',
                         'alias'                       => '',
                         'methodology'                 => '',
                         'issues_array'                => '',
                         'justification_array'         => '',
                         'alternatives_array'          => '',
                         'contact_accessibility_name'  => '',
                         'support_institute'           => '',
                         'support_city'                => '',
                         'oversight_name'              => '',
                         'oversight_dept'              => '',
                         'oversight_city'              => '',
                         'overwrite_consent'           => '',
                        );
```

<br />

##### **1.2.2.3. <u>Intl Keys Array</u>**

```PHP
$state_keys_intl = array('wisski_url'                   => '',
                         'status'                       => '',
                         'creation_date'                => '',
                         'last_revision_date'           => '',
                         'report_url'                   => '',
                         'contact_accessibility_phone'  => '',
                         'contact_accessibility_email'  => '',
                         'support_url'                  => '',
                         'support_address'              => '',
                         'support_plz'                  => '',
                         'support_email'                => '',
                         'oversight_address'            => '',
                         'oversight_plz'                => '',
                         'oversight_phone'              => '',
                         'oversight_email'              => '',
                         'oversight_url'                => '',
                         'date'                         => '',
                        );
```

<br />
<br />

#### **1.2.3. Privacy**

##### **1.2.3.1. <u>Data Array</u>**

|Section|Type|Key|Description|Required|Key Array|Example|
|----|----|----|----|:----:|----|---|
|**General**|String|not_fau|`Replace FAU-specific text with custom text otherwise leave empty`|<span style="color:IndianRed">&#x2612;</span>|'lang'|'The Umiña University is responsible for this VRE within the meaning of the General Data Protection Regulation as well as other national data protection laws and regulations. It is legally represented by the president.'|
|**Data Security Official**|String|security_official_title|Title data security official|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Umiña University Data Security Official'|
||String|security_official_name|Name data security official|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Dilga Dataofficial'|
||String|security_official_add|Name line 2 data security official|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'c/o Data Security Center'|
||String|security_official_address|Address data security official|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Main Street'|
||String|security_official_plz|Postal code data security official|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|security_official_city|City data security official|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Anytown'|
||tel|security_official_phone|Phone number data security official|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'+49 1234 567890'|
||String|security_official_fax|Fax number data security official|<span style="color:IndianRed">&#x2612;</span>|'intl'|'+49 0987 654321'|
||email|security_official_email|E-mail data security official|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'dilga.dataofficial@mail.de'|
|**Third Party Services**|String|third_service_provider|Name third party service|<span style="color:IndianRed">&#x2612;</span>|'lang'|'Provided Service'|
||String|third_service_description_data_collection|**`Free text:`** Description and scope data processing|<span style="color:IndianRed">&#x2612;</span>|'lang'|'User data will be stored when you use a page that integrates Provided Service. Provided Service operates as follows and processes your data in the following ways. '|
||String|third_service_legal_basis_data_collection|**`Free text:`** Legal basis personal data processing|<span style="color:IndianRed">&#x2612;</span>|'lang'|'The use of Provided Service serves the purpose Purpose. This represents a legitimate interest under article law. Consent can be revoked at any time. Please find further information on the use of personal data at Link.'|
||String|third_service_objection_data_collection|**`Free text:`** Objection and elimination to personal data collection and processing|<span style="color:IndianRed">&#x2612;</span>|'lang'|'You can object to the collection of your personal data carried out by Provided Service by carrying out action.'|
|**(Bavarian) Data Protection Commissioner**|String|data_commissioner_title|Title data protection commissioner|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Examplary Commissioner for Data Protection'|
||String|data_commissioner_address|Address data protection commissioner|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Main Street'|
||String|data_commissioner_plz|Postal code data protection commissioner|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|data_commissioner_city|City data protection commissioner|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Anytown'|
|**Generation Date**|String|date|Page generation date `"YYYY-MM-DD"`</span>|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'2023.08.29'|
|**Overwrite Consent**|**`Boolean`**|overwrite_consent|**`Checkbox:`** Permission to overwrite existing page|<span style="color:IndianRed">&#x2612;</span>|'lang'|FALSE|
<br />

##### **1.2.3.2. <u>Lang Keys Array</u>**

```PHP
$state_keys_lang = array('title'                                      => '',
                         'alias'                                      => '',
                         'not_fau'                                    => '',
                         'security_official_title'                    => '',
                         'security_official_name'                     => '',
                         'security_official_add'                      => '',
                         'security_official_city'                     => '',
                         'third_service_provider'                     => '',
                         'third_service_description_data_collection'  => '',
                         'third_service_legal_basis_data_collection'  => '',
                         'third_service_objection_data_collection'    => '',
                         'data_commissioner_title'                    => '',
                         'data_commissioner_city'                     => '',
                         'overwrite_consent'                          => '',
                        );
```

<br />

##### **1.2.3.3. <u>Intl Keys Array</u>**

```PHP
$state_keys_intl = array('security_official_address'   => '',
                         'security_official_plz'       => '',
                         'security_official_phone'     => '',
                         'security_official_fax'       => '',
                         'security_official_email'     => '',
                         'data_commissioner_address'   => '',
                         'data_commissioner_plz'       => '',
                         'date'                        => '',
                        );
```

<br />
<br />

## 2. Forms
A render array of the type select to choose the language to be used for form generation. After selection the complete form will be displayed. Please note that titles and explanations are in English for all forms irrespective of the language of the generated page. All form fields are pre-populated with values from the the state as saved during the last page generation, if applicable. If the page has never been generated before or values have been reset (see below), default values as specified in **legalgen.required.and.email.yml** (see below).<br />
Values are differentiated into either language specific values and international values and are treated differently. The latter group contains all values that cannot be translated such as names, street name and house number, postal codes, phone numbers, fax numbers, urls, dates and e-mail addresses. This group is stored to the state in a separate array and if reset for one language version will be reset for all language version of the form for the same page.<br />
Each form has a submit and a reset button. The first generates the page calling the service and storing the values submitted to the state. If the generation was completed succcessfully, a status message with a link to the generated page will be displayed. An error message is shown in unsuccessful cases.
Clicking the reset button will open a modal dialog to ensure the user really wishes to reset. Upon confirming this, they will be forwarded to a controller (see below) which handles the request and returns the user to the form page they initially came from.

<br />

## 3. Required and Default Values
The file **legalgen.required.and.email.yml** contains one array per page plus an extra array for the legal notice alias. The latter is stored separately, as it is also used in the templates for the accessibility as well as the privacy page.<br />
All keys in the page specific array are set to required in the form. If their value is not empty the given string is used as default in case the page has never been generated or when values will be reset (see above).The function checking this is part of each form file.<br />
There are a few exceptions: Whether those values are required or not depends on values in other fields.
+ For all pages the value for `'Overwrite'` is managed directly in Form via a condition at the bottom of the form's source code.
+ The following fields are managed directly in the respective render array of the specific form via the `#states` property:<br />
**Legal Notice**: `'Licence_Title'` and `'Custom_Licence_Text'`<br />
**Accessibility**: `'Known_Issues'`, `'Justification_Statement'`, and `'Alternative_Access'`<br />
**Privacy**: `'Third_Party_Service'`

<br />

## 4. Controller
The user is sent to the **LegalgenController** after clicking the reset button at the end of a form and subsequently confirming this choice in a modal dialog box. Through the query string information on the page type and chosen language is passed. The validity of those values will be checked before continuing. Thereafter, all values specific to the respective page in the chosen language as well as the international values for said page will be deleted from the state. The user is redirected to the page they initially came from and a success message will be displayed indicating whether the values were successfully reset or already the default values.

<br />

## 5. Config
The file **legalgen.languages.yml** specifies all languages available for generation through stating the file name of each respective template for a page. Additionally, the specific language needs to be added to the language list. If this is not the case, the user will be prompted to do so when selecting the respective language instead of diplaying the form.<br />
`option`: Specifies how this language option will be displayed in the language selector (drop down) when choosing the language to display the form.<br />
`empty_text`: The text shown for a default language page generated "empty". This happens if the user generates a page for a non-default language when the page in the default language does currently not exist (either because it has never been generated or was deleted by the user). This happens as all language versions of a page are stored as translations in the node of the page in the default language.

<br />

## 6. CSS
For accessibility reasons, the identification numbers (`VAT_Number`,`Tax_Number`, `DUNS_Number` and `EORI_Number`) in the legal notice are given a 'table'-like structure via CSS, thus avoiding the use of a table.