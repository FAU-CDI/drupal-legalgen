# WissKI Legal Information

Generates Legal Notice, Accessibility Statement, and Privacy Statement. <br />Format and contents of the generated pages are based on the *[RRZE's 'Legal' WordPress plugin](https://github.com/RRZE-Webteam/rrze-legal/tree/main)* adapted to the requirements of WissKI.
</br>
</br>

## Guarantee/Liability

We give no guarantee and assume no liability for the topicality and legal correctness of the legal statements generated via this module. It is incumbent on the user to check the data supplied as well as the generated pages.
</br>
</br>

## Customization

Generates the above-mentioned legal statements in English and German. To enable generation in another language, add specifications for this language to the config and the respective template to the template folder.

A limited number of customization options are available (see below).
</br>
</br>

## Service: LegalGenerator

Each of the three legal statements can be generated through the following function:


><span style="color:PapayaWhip">generatePage</span><span style="color:Gold">(</span><span style="color:CornflowerBlue">array</span> <span style="color:SkyBlue">$data</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$title</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$alias</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$lang</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$page_name</span>, <span style="color:CornflowerBlue">array</span> <span style="color:SkyBlue">$state_keys_lang</span>, <span style="color:CornflowerBlue">array</span> <span style="color:SkyBlue">$state_keys_intl</span><span style="color:Gold">)</span></br>

</br>

### 1. Parameters

|Type|Key|Description|
|----:|----|---|
|array|<span style="color:SkyBlue">$data</span>|Should contain all values to be added to the page identified by the keys specified below<br /> See 2.[123]. a)|
|string|<span style="color:SkyBlue">$title</span>|Page title|
|string|<span style="color:SkyBlue">$alias</span>|URL Path|
|string|<span style="color:SkyBlue">$lang</span>|Language code<br />`Use: 'en' or 'de'`|
|string|<span style="color:SkyBlue">$page_name</span>|Page type to be generated<br />`Use: 'legal_notice', 'accessibility' or 'privacy'`|
|array|<span style="color:SkyBlue">$state_keys_lang</span>|All keys for language-specific values. See 2.[123]. b)|
|array|<span style="color:SkyBlue">$state_keys_intl</span>|All keys for language non-specific values. See 2.[123]. c)|
<br />

<br />

### 2. Keys and Values

#### 2.1. Legal Notice

##### a) <u>Data Array</u>

|Section|Type|Key|Description|Required|Key Array|Example|
|----|----|----|-----|:---:|----|---|
|**General**|String|wisski_url|WissKI URL|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://projectname.wisski.data.fau.de/'|
||String|project_name|Name WissKI|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'WissKI Legalgen'|
|**Publisher**|String|pub_institute|Name institute publisher|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Beispielinstitut'|
||String|pub_name|Name publisher|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Padmal Publisher'|
||String|pub_address|Address publisher|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Main Street'|
||String|pub_plz|Postal code publisher|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|pub_city|City publisher|<span style="color:DarkCyan">&#x2611;</span>|'lang'|Anytown|
||String|pub_email|E-mail publisher|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'padmal.publisher@mail.com'|
||String|cust_legal_form|**`Free text:`** `Leave empty if FAU specific text should be displayed.`</span><br /> `Custom text regarding legal form and representation`|<span style="color:IndianRed">&#x2612;</span>|'lang'|'Umiña University Anytown is a state institution and also a legal personality under public law according to Art. 4 Para. 1 BayHIG. It is legally represented by the President.'|
|**Contact Person Content**|String|contact_name|Name contact person content|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Centola Contactperson'|
||String|contact_phone|Phone number contact person content|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'+49 171 123456'|
||String|contact_email|E-mail contact person content|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'centola.contactperson@mail.de'|
|**Support and Hosting**|String|sup_institute|Name institute support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Center for Support and Hosting'|
||String|sup_url|Support and hosting URL|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://support.hosting.com/'|
||String|sup_email|E-mail support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'support.hosting@mail.de'|
||**`Array`**|sup_staff_array|Individual staff members support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'lang'|array('Mauve Mitarbeiterin', 'Suiji Staff', 'Eda Employee')|
|**Supervisory Authority**|String|auth_name|Name supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Ministry of Supervision'|
||String|auth_address|Address supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Any Avenue'|
||String|auth_plz|Postal code supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|auth_city|City supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Anytown'|
||String|auth_url|Supervisory authority URL|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://supervisory.authority.com/'|
|**ID Numbers**|String|id_vat|VAT registration number|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'DE 123456789'|
||String|id_tax|Tax number|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'123/123/12345 (Tax and Revenue Office)'|
||String|id_duns|DUNS number|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'123456789'|
||String|id_eori|EORI number|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'DE1234567'|
|**Copyright**|String|licence_title_meta|Name copyright license|<span style="color:IndianRed">&#x2612;</span>|'lang'|'CC Licence Title'|
||String|licence_url_meta|Copyright license URL|<span style="color:IndianRed">&#x2612;</span>|'intl'|'https://creativecommons.org/licenses/some-licence-type'|
||String|licence_title_pics|Name copyright license|<span style="color:IndianRed">&#x2612;</span>|'lang'|'CC Licence Title'|
||String|licence_url_pics|Copyright license URL|<span style="color:IndianRed">&#x2612;</span>|'intl'|'https://creativecommons.org/licenses/some-licence-type'|
||**`Boolean`**|use_fau_temp|**`Checkbox:`** `INSTEAD OF default text display` costum information on copyright|<span style="color:IndianRed">&#x2612;</span>|'lang'|FALSE|
||**`Boolean`**|no_default_txt|**`Checkbox:`** WissKI uses FAU corporate design|<span style="color:IndianRed">&#x2612;</span>|'lang'|FALSE|
||String|cust_licence_txt|**`Free text:`** Costum information on copyright|<span style="color:IndianRed">&#x2612;</span>|'lang'|'Custom information on proprietary rights in general or for specific contents. Specifications on contents and works not protected under copyright law as well as on private use will always be displayed.'|
|**Exclusion of Liability**|String|cust_exclusion|**`Free text:`**|<span style="color:IndianRed">&#x2612;</span>|'lang'|'No guarantee, no liability.  Full reservation of the right to temporarily or indefinitely interrupt or terminate services.'|
|**Disclaimer External Links**|**`Boolean`**|hide_disclaim|**`Checkbox:`** Section 'Links and references (disclaimer)' `should not be displayed`|<span style="color:IndianRed">&#x2612;</span>|'intl'|FALSE|
||String|cust_disclaim|**`Free text:`** Custom information on liability for links|<span style="color:IndianRed">&#x2612;</span>|'lang'|'No responsibility and liability for links reference and related content.'|
|**Generation Date**|String|date|Page generation date `"YYYY-MM-DD"`|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'2014.07.10'|
|**Overwrite Consent**|**`Boolean`**|overwrite_consent|**`Checkbox:`** Permission to overwrite existing page|<span style="color:IndianRed">&#x2612;</span>|'lang'|FALSE|
<br />

##### **b) <u>Lang Array</u>**

> $state_keys_lang = array('title'                 => '',
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

<br />

##### **c) <u>Intl Array</u>**

> $state_keys_intl = array('wisski_url'            => '',
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


<br />
<br />

#### **2.2. Accessibility**

##### **a) <u>Data Array</u>**

|Section|Type|Key|Description|Required|Key Array|Example|
|----|----|----|----|:----:|----|---|
|**General**|String|wisski_url|WissKI URL|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://projectname.wisski.data.fau.de/'|
|**Conformity**|String|status|Dropdown: Either `"Completely compliant"` or `"Partially compliant"`|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Partially compliant'|
||String|methodology|Assessment methodology|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Example Assessment Methodology'|
||String|creation_date|Date assessment|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'13.07.2021'|
||String|last_revis_date|Last revision assessment|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'27.08.2023'|
||String|report_url|Report URL|<span style="color:IndianRed">&#x2612;</span>|'intl'|'https://reporturl.de'|
|**Contents Not Accessible to All**|**`Array`**|issues_array|**`Free text:`** Individual issue descriptions|<span style="color:IndianRed">&#x2612;</span>|'lang'|array('Inaccessible content 1', 'Inaccessible content 2', 'Inaccessible content 3')|
||**`Array`**|statement_array|**`Free text:`** Statements for each issue from issues_array|<span style="color:IndianRed">&#x2612;</span>|'lang'|array('Justification for inaccessibility of content 1', 'Justification for inaccessibility of content 2', 'Justification for inaccessibility of content 3')|
||**`Array`**|alternatives_array|**`Free text:`** Alternatives for contents not accessible|<span style="color:IndianRed">&#x2612;</span>|'lang'|array('Contact the contact person via phone.', 'Contact the contact person via e-mail')|
|**Contact Person**|String|contact_access_name|Name contact person accessibility|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Centli Contactperson'|
||String|contact_access_phone|Phone number contact person accessibility|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'+49 1234 1234567'|
||String|contact_access_email|E-mail contact person accessibility|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'centli.contactperson@mail.de'|
|**Support and Hosting**|String|sup_institute|Name institute support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Support Center'|
||String|sup_url|URL support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://support.de'|
||String|sup_address|Address support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Main Street'|
||String|sup_plz|Postal code support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|sup_city|City support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Anytown'|
||String|sup_email|E-mail support and hosting|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'support@mail.de'|
|**Enforcement Oversight Body**|String|overs_name|Name enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Example Agency'|
||String|overs_dept|Department enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Example IT-Service Center'|
||String|overs_address|Address enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Main Street'|
||String|overs_plz|Postal code enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|overs_city|City enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Anytown'|
||String|overs_phone|Phone number enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'+49 1234 67890'|
||String|overs_email|E-mail enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'beispiellandesamt@email.de'|
||String|overs_url|URL enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'https://enforcement.oversight.de'|
|**Generation Date**|String|date|Page generation date `"YYYY-MM-DD"`|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'2023.07.20'|
|**Overwrite Consent**|**`Boolean`**|overwrite_consent|**`Checkbox:`** Permission to overwrite existing page|<span style="color:IndianRed">&#x2612;</span>|'lang'|FALSE|
<br />

##### **b) <u>Lang Keys Array</u>**

> $state_keys_lang = array('title'                 => '',
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

<br />

##### **c) <u>Intl Keys Array</u>**

> $state_keys_intl = array('wisski_url'            => '',
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

<br />
<br />

#### **2.3. Privacy**

##### **a) <u>Data Array</u>**

|Section|Type|Key|Description|Required|Key Array|Example|
|----|----|----|----|:----:|----|---|
|**General**|String|not_fau|`Replace FAU-specific text with custom text otherwise leave empty`|<span style="color:IndianRed">&#x2612;</span>|'lang'|'The Umiña University is responsible for this VRE within the meaning of the General Data Protection Regulation as well as other national data protection laws and regulations. It is legally represented by the president.'|
|**Data Security Official**|String|sec_off_title|Title data security official|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Umiña University Data Security Official'|
||String|sec_off_name|Name data security official|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Dilga Dataofficial'|
||String|sec_off_add|Name line 2 data security official|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'c/o Data Security Center'|
||String|sec_off_address|Address data security official|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Main Street'|
||String|sec_off_plz|Postal code data security official|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|sec_off_city|City data security official|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Anytown'|
||String|sec_off_phone|Phone number data security official|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'+49 1234 567890'|
||String|sec_off_fax|Fax number data security official|<span style="color:IndianRed">&#x2612;</span>|'intl'|'+49 0987 654321'|
||String|sec_off_email|E-mail data security official|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'dilga.dataofficial@mail.de'|
|**Third Party Services**|String|third_service_provider|Name third party service|<span style="color:IndianRed">&#x2612;</span>|'lang'|'Provided Service'|
||String|third_descr_data_coll|**`Free text:`** Description and scope data processing|<span style="color:IndianRed">&#x2612;</span>|'lang'|'User data will be stored when you use a page that integrates Provided Service. Provided Service operates as follows and processes your data in the following ways. '|
||String|third_legal_basis_data_coll|**`Free text:`** Legal basis personal data processing|<span style="color:IndianRed">&#x2612;</span>|'lang'|'The use of Provided Service serves the purpose Purpose. This represents a legitimate interest under article law. Consent can be revoked at any time. Please find further information on the use of personal data at Link.'|
||String|third_objection_data_coll|**`Free text:`** Objection and elimination to personal data collection and processing|<span style="color:IndianRed">&#x2612;</span>|'lang'|'You can object to the collection of your personal data carried out by Provided Service by carrying out action.'|
|**(Bavarian) Data Protection Commissioner**|String|data_comm_title|Title data protection commissioner|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Examplary Commissioner for Data Protection'|
||String|data_comm_address|Address data protection commissioner|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'Main Street'|
||String|data_comm_plz|Postal code data protection commissioner|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'11011'|
||String|data_comm_city|City data protection commissioner|<span style="color:DarkCyan">&#x2611;</span>|'lang'|'Anytown'|
|**Generation Date**|String|date|Page generation date `"YYYY-MM-DD"`</span>|<span style="color:DarkCyan">&#x2611;</span>|'intl'|'2023.08.29'|
|**Overwrite Consent**|**`Boolean`**|overwrite_consent|**`Checkbox:`** Permission to overwrite existing page|<span style="color:IndianRed">&#x2612;</span>|'lang'|FALSE|
<br />

##### **b) <u>Lang Keys Array</u>**

> $state_keys_lang = array('title'                          => '',
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

<br />

##### **c) <u>Intl Keys Array</u>**

> $state_keys_intl = array('sec_off_address'                => '',
                           'sec_off_plz'                    => '',
                           'sec_off_phone'                  => '',
                           'sec_off_fax'                    => '',
                           'sec_off_email'                  => '',
                           'data_comm_address'              => '',
                           'data_comm_plz'                  => '',
                           'date'                           => '',
                           );