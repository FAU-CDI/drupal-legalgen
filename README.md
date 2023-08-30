# WissKI Legal Information

Generate Legal Notice, Accessibility Statement, and Privacy Statement. Format and contents of the generated pages are based on the *[RRZE's 'Legal' WordPress plugin](https://github.com/RRZE-Webteam/rrze-legal/tree/main)* adapted to the requirements of WissKI.
</br>
</br>

## Guarantee/Liability

We give no guarantee and assume no liability for the topicality and legal correctness of the legal statements generated via this module. It is incumbent on the user to check the data supplied as well as the generated pages.
</br>
</br>

## Customization
A limited number of customization options are available (see table below).

</br>
</br>

## Service: WisskiLegalGenerator

Each of the three legal statements can be generated through one of the following functions. The English and the German language version are generated simultaneously.


<span style="color:PapayaWhip">generateImpressum</span><span style="color:Gold">(</span><span style="color:CornflowerBlue">array</span> <span style="color:SkyBlue">$data</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$title</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$title_en</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$alias</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$alias_en</span><span style="color:Gold">)</span><br/>
<span style="color:PapayaWhip">generateBarrierefreiheit</span><span style="color:Gold">(</span><span style="color:CornflowerBlue">array</span> <span style="color:SkyBlue">$data</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$title</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$title_en</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$alias</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$alias_en</span><span style="color:Gold">)</span><br/>
<span style="color:PapayaWhip">generateDatenschutz</span><span style="color:Gold">(</span><span style="color:CornflowerBlue">array</span> <span style="color:SkyBlue">$data</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$title</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$title_en</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$alias</span>, <span style="color:CornflowerBlue">string</span> <span style="color:SkyBlue">$alias_en</span><span style="color:Gold">)</span><br/>
</br>

### Parameters

<span style="color:SkyBlue">$title</span>: page title in German</br>
<span style="color:SkyBlue">$title_en</span>:  page title in English</br>
<span style="color:SkyBlue">$alias</span>: Endpoint for the German page</br>
<span style="color:SkyBlue">$alias_en</span> Endpoint for the English page</br>
<span style="color:SkyBlue">$data</span> should contain all values to be added to the page identified by the keys specified below.
</br>

### Keys and Values

All keys with the suffix "_de" refer to values in German that will be displayed on the German version of the page.
Respectively, all keys with the suffix "_en" refer to values in English and will be displayed on the English version of the page. Keys without suffix are language-independent and will be displayed on both the English and the German page.
</br>
</br>

#### **a) <u>Legal Notice</u>**

|Section|Type|Key|Description|Dummy Variable|Required|
|----:|----|----|----|----|--:|
|**General**|String|wisski_url|WissKI URL|'https://projectname.wisski.data.fau.de/'|<span style="color:DarkCyan">&#x2611;</span>|
||String|project_name_de|Name WissKI|'WissKI Legalgen'|<span style="color:DarkCyan">&#x2611;</span>|
||String|project_name_en|do.|'WissKI Legalgen'|<span style="color:DarkCyan">&#x2611;</span>|
|**Publisher**|String|pub_institute_de|Name institute publisher|'Institut für Beispiele'|<span style="color:DarkCyan">&#x2611;</span>|
||String|pub_institute_en|do.|'Institute for Examples'|<span style="color:DarkCyan">&#x2611;</span>|
||String|pub_name|Name publisher|'Padmal Publisher'|<span style="color:DarkCyan">&#x2611;</span>|
||String|pub_address|Address publisher|'Main Street'|<span style="color:DarkCyan">&#x2611;</span>|
||String|pub_plz|Postal code publisher|'11011'|<span style="color:DarkCyan">&#x2611;</span>|
||String|pub_city_de|City publisher|Beispielstadt|<span style="color:DarkCyan">&#x2611;</span>|
||String|pub_city_en|do.|'Anytown'|<span style="color:DarkCyan">&#x2611;</span>|
||String|pub_email|E-mail publisher|'padmal.publisher@mail.com'|<span style="color:DarkCyan">&#x2611;</span>|
||String|cust_legal_form_de|<span style="color:Aquamarine">Free text: Leave empty if FAU specific text should be displayed.</span><br /> Custom text regarding legal form and representation|'Die Umiña Universität Beispielstadt ist eine staatliche Einrichtung und daneben eine rechtsfähige Personalkörperschaft des öffentlichen Rechts nach Art. 4 Abs. 1 BayHIG. Sie wird gesetzlich vertreten durch den Präsidenten.'|<span style="color:IndianRed">&#x2612;</span>|
||String|cust_legal_form_en|do.|'The Umiña University Anytown is a state institution and also a legal personality under public law according to Art. 4 Para. 1 BayHIG. It is legally represented by the President.'|<span style="color:IndianRed">&#x2612;</span>|
|**Contact Person Content**|String|contact_name|Name contact person content|'Centola Contactperson'|<span style="color:DarkCyan">&#x2611;</span>|
||String|contact_phone|Phone number contact person content|'+49 171 123456'|<span style="color:DarkCyan">&#x2611;</span>|
||String|contact_email|E-mail contact person content|'centola.contactperson@mail.de'|<span style="color:DarkCyan">&#x2611;</span>|
|**Support and Hosting**|String|sup_institute_de|Name institute support and hosting|'Support and Hosting Center'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sup_institute_en|do.|'Center for Support and Hosting'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sup_url|Support and hosting URL|'https://support.hosting.com/'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sup_email|E-mail support and hosting|'support.hosting@mail.de'|<span style="color:DarkCyan">&#x2611;</span>|
||<span style="color:Aquamarine">Array</span>|sup_staff_array|Individual staff members support and hosting|array('Mauve Mitarbeiterin', 'Suiji Staff', 'Eda Employee')|<span style="color:DarkCyan">&#x2611;</span>|
|**Supervisory Authority**|String|auth_name_de|Name supervisory authority|'Ministerium für Aufsicht'|<span style="color:DarkCyan">&#x2611;</span>|
||String|auth_name_en|do.|'Ministry of Supervision'|<span style="color:DarkCyan">&#x2611;</span>|
||String|auth_address|Address supervisory authority|'Any Avenue'|<span style="color:DarkCyan">&#x2611;</span>|
||String|auth_plz|Postal code supervisory authority|'11011'|<span style="color:DarkCyan">&#x2611;</span>|
||String|auth_city_de|City supervisory authority|'Beispielstadt'|<span style="color:DarkCyan">&#x2611;</span>|
||String|auth_city_en|do.|'Anytown'|<span style="color:DarkCyan">&#x2611;</span>|
||String|auth_url|Supervisory authority URL|'https://supervisory.authority.com/'|<span style="color:DarkCyan">&#x2611;</span>|
|**Copyright**|String|licence_title_de|Name copyright license|'CC Lizenzart'|<span style="color:IndianRed">&#x2612;</span>|
||String|licence_title_en|do.|'CC Licence Title'|<span style="color:IndianRed">&#x2612;</span>|
||String|licence_url|Copyright license URL|'https://creativecommons.org/licenses/some-licence-type'|<span style="color:IndianRed">&#x2612;</span>|
||<span style="color:Aquamarine">Boolean</span>|use_fau_temp|Checkbox: INSTEAD OF default text display costum information on copyright|FALSE|<span style="color:IndianRed">&#x2612;</span>|
||<span style="color:Aquamarine">Boolean</span>|no_default_txt|Checkbox: WissKI (partially) uses FAU corporate design|FALSE|<span style="color:IndianRed">&#x2612;</span>|
||String|cust_licence_txt_de|<span style="color:Aquamarine">Free text:</span> Costum information on copyright|'Personalisierte Angaben zum Urheberrecht für bestimmte Inhalte oder im Allgemeinen. Informationen zu nicht urheberrechtlich geschützten Inhalten und Werken sowie zur Nutzung für den Privatgebrauch durch Privatpersonen wird weiterhin angezeigt.'|<span style="color:IndianRed">&#x2612;</span>|
||String|cust_licence_txt_en|<span style="color:Aquamarine">do.</span>|'Custom information on proprietary rights in general or for specific contents. Specifications on contents and works not protected under copyright law as well as on private use will always be displayed.'|<span style="color:IndianRed">&#x2612;</span>|
|**Exclusion of Liability**|String|cust_exclusion_de|<span style="color:Aquamarine">Free text:</span>|'Keine Gewähr, keine Haftung. Vorbehalt des Rechts zur zeitweisen oder endgültigen Einstellung.'|<span style="color:IndianRed">&#x2612;</span>|
||String|cust_exclusion_en|<span style="color:Aquamarine">do.</span>|'No guarantee, no liability.  Full reservation of the right to temporarily or indefinitely interrupt or terminate services.'|<span style="color:IndianRed">&#x2612;</span>|
|**Disclaimer External Links**|<span style="color:Aquamarine">Boolean</span>|show_disclaim|Checkbox: Section 'Links and references (disclaimer)' should not be displayed|FALSE|<span style="color:IndianRed">&#x2612;</span>|
||String|cust_disclaim_de|<span style="color:Aquamarine">Free text:</span> Custom information on liability for links|'Keine Gewähr und Haftung für Links zu externen Seiten.'|<span style="color:IndianRed">&#x2612;</span>|
||String|cust_disclaim_en|<span style="color:Aquamarine">do.</span>|'No Responsibility and liability for links reference and related content.'|<span style="color:IndianRed">&#x2612;</span>|
|**Generation Date**|String|date|Page generation date<span style="color:Aquamarine">"YYYY-MM-DD"</span>|'2014.07.10'|<span style="color:DarkCyan">&#x2611;</span>|

<br />
<br />
<br />

#### **b) <u>Accessibility</u>**
|Section|Type|Key|Description|Dummy Variable|Required|
|----:|----|----|----|----|--:|
|**General**|String|wisski_url|WissKI URL|'https://projectname.wisski.data.fau.de/'|<span style="color:DarkCyan">&#x2611;</span>|
|**Conformity**|String|status|Dropdown: Either <span style="color:Aquamarine">"Completely compliant"</span> or <span style="color:Aquamarine">"Partially compliant"</span>|'Partially compliant'|<span style="color:DarkCyan">&#x2611;</span>|
||String|methodology_de|Assessment methodology|'Beispielmethodik'|<span style="color:DarkCyan">&#x2611;</span>|
||String|methodology_en|do.|'Example Assessment Methodology'|<span style="color:DarkCyan">&#x2611;</span>|
||String|creation_date|Date assessment|'13.07.2021'|<span style="color:DarkCyan">&#x2611;</span>|
||String|last_revis_date|Last revision assessment|'27.08.2023'|<span style="color:DarkCyan">&#x2611;</span>|
||String|report_url|Report URL|'https://reporturl.de'|<span style="color:IndianRed">&#x2612;</span>|
|**Contents Not Accessible to All**|<span style="color:Aquamarine">Array</span>|issues_array_de|<span style="color:Aquamarine">Free text:</span> Individual issue descriptions|array('Nicht zugänglicher Inhalt 1', 'Nicht zugänglicher Inhalt 2', 'Nicht zugänglicher Inhalt 3')|<span style="color:IndianRed">&#x2612;</span>|
||<span style="color:Aquamarine">Array</span>|issues_array_en|do.|array('Inaccessible content 1', 'Inaccessible content 2', 'Inaccessible content 3')|<span style="color:IndianRed">&#x2612;</span>|
||<span style="color:Aquamarine">Array</span>|statement_array_de|<span style="color:Aquamarine">Free text:</span> Statements for each issue from issues_array|array('Begründung für die Unzugänglichkeit des Inhalts 1', 'Begründung für die Unzugänglichkeit des Inhalts 2', 'Begründung für die Unzugänglichkeit des Inhalts 3')|<span style="color:IndianRed">&#x2612;</span>|
||<span style="color:Aquamarine">Array</span>|statement_array_en|do.|array('Justification for inaccessibility of content 1', 'Justification for inaccessibility of content 2', 'Justification for inaccessibility of content 3')|<span style="color:IndianRed">&#x2612;</span>|
||<span style="color:Aquamarine">Array</span>|alternatives_array_de|<span style="color:Aquamarine">Free text:</span> Alternatives for contents not accessible|array('Kontaktaufnahme zur Kontaktperson.')|<span style="color:IndianRed">&#x2612;</span>|
||<span style="color:Aquamarine">Array</span>|alternatives_array_en|do.|array('Contact the contact person.')|<span style="color:IndianRed">&#x2612;</span>|
|**Contact Person**|String|contact_access_name|Name contact person accessibility|'Centli Ana Contactperson'|<span style="color:DarkCyan">&#x2611;</span>|
||String|contact_access_phone|Phone number contact person accessibility|'+49 1234 1234567'|<span style="color:DarkCyan">&#x2611;</span>|
||String|contact_access_email|E-mail contact person accessibility|'centli.a.contactperson@mail.de'|<span style="color:DarkCyan">&#x2611;</span>|
|**Support<br />and Hosting**|String|sup_institute_de|Name institute support and hosting|'Suppportzentrum'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sup_institute_en|do.|'Support Center'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sup_url|URL support and hosting|'https://support.de'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sup_address|Address support and hosting|'Main Street'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sup_plz|Postal code support and hosting|'11011'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sup_city_de|City support and hosting|'Beispielstadt'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sup_city_en|do.|'Anytown'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sup_email|E-mail support and hosting|'support@mail.de'|<span style="color:DarkCyan">&#x2611;</span>|
|**Enforcement Oversight Body**|String|overs_name_de|Name enforcement oversight body|'Beispiellandesamt'|<span style="color:DarkCyan">&#x2611;</span>|
||String|overs_name_en|do.|'Example Agency'|<span style="color:DarkCyan">&#x2611;</span>|
||String|overs_dept_de|Department enforcement oversight body|'Beispiel IT-Servicezentrum'|<span style="color:DarkCyan">&#x2611;</span>|
||String|overs_dept_en|do.|'Example IT-Service Center'|<span style="color:DarkCyan">&#x2611;</span>|
||String|overs_address|Address enforcement oversight body|'Main Street'|<span style="color:DarkCyan">&#x2611;</span>|
||String|overs_plz|Postal code enforcement oversight body|'11011'|<span style="color:DarkCyan">&#x2611;</span>|
||String|overs_city_de|City enforcement oversight body|'Beispielstadt'|<span style="color:DarkCyan">&#x2611;</span>|
||String|overs_city_en|do.|'Anytown'|<span style="color:DarkCyan">&#x2611;</span>|
||String|overs_phone|Phone number enforcement oversight body|'+49 1234 67890'|<span style="color:DarkCyan">&#x2611;</span>|
||String|overs_email|E-mail enforcement oversight body|'beispiellandesamt@email.de'|<span style="color:DarkCyan">&#x2611;</span>|
||String|overs_url|URL enforcement oversight body|'https://enforcement.oversight.de'|<span style="color:DarkCyan">&#x2611;</span>|
|**Generation Date**|String|date|Page generation date "YYYY-MM-DD"|'2023.07.20'|<span style="color:DarkCyan">&#x2611;</span>|

<br />
<br />
<br />

#### **c) <u>Privacy</u>**

|Section|Type|Key|Description|Dummy Variable|Required|
|----:|----|----|----|----|--:|
|**General**|String|wisski_url|URL WissKI|'https://projectname.wisski.data.fau.de/'|<span style="color:DarkCyan">&#x2611;</span>|
||String|not_fau_de|<span style="color:Aquamarine">Replace FAU-specific text with custom text otherwise leave empty</span>|'Für diese VFU ist die verantwortliche Person im Sinne der Datenschutzgrundverordnung und anderer nationaler Datenschutzgesetze Umiña University Anytown. Sie wird gesetzlich vertreten durch die Präsidentin.'|<span style="color:IndianRed">&#x2612;</span>|
||String|not_fau_en|do.|'The Umiña University Anytown is responsible for this VRE within the meaning of the General Data Protection Regulation as well as other national data protection laws and regulations. It is legally represented by the president.'|<span style="color:IndianRed">&#x2612;</span>|
|**Data<br />Security Official**|String|sec_off_title_de|Title data security official|'Datenschutzbeauftragte der Umiña University Anytown'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sec_off_title_en|do.|'Umiña University Anytown Data Security Official'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sec_off_name|Name data security official|'Dilga Dataofficial'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sec_off_add_de|Name line 2 data security official|'c/o Data Security Center'|<span style="color:IndianRed">&#x2612;</span>|
||String|sec_off_add_en|do.|'c/o Data Security Center'|<span style="color:IndianRed">&#x2612;</span>|
||String|sec_off_address|Address data security official|'Main Street'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sec_off_plz|Postal code data security official|'11011'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sec_off_city_de|City data security official|'Beispielstadt'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sec_off_city_en|do.|'Anytown'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sec_off_phone|Phone number data security official|'+49 1234 567890'|<span style="color:DarkCyan">&#x2611;</span>|
||String|sec_off_fax|Fax number data security official|'+49 0987 654321'|<span style="color:IndianRed">&#x2612;</span>|
||String|sec_off_email|E-mail data security official|'dilga.dataofficial@mail.de'|<span style="color:DarkCyan">&#x2611;</span>|
|**Third Party<br />Services**|String|third_service_provider|Name third party service|'Provided Service'|<span style="color:IndianRed">&#x2612;</span>|
||String|third_descr_data_coll_de|<span style="color:Aquamarine">Free text:</span> Description and scope data processing|'Wenn Sie eine Seite der VFU aufrufen, die Provided Service einbindet, werden ihre Nutzungsdaten protokolliert. Provided Service funktioniert wie folgt und verarbeitet die Daten entsprechend.'|<span style="color:IndianRed">&#x2612;</span>|
||String|third_descr_data_coll_en|do.|'User data will be stored when you use a page that integrates Provided Service. Provided Service operates as follows and processes your data in the following ways. '|<span style="color:IndianRed">&#x2612;</span>|
||String|third_legal_basis_data_coll_de|<span style="color:Aquamarine">Free text:</span> Legal basis personal data processing|'Die Nutzung von Provided Service erfolgt zum Zweck. Dies stellt ein berechtigtes Interesse gemäß Artikel Gesetzestext. Die Einwilligung kann widerrufen werden. Weitere Informationen zum Umgang mit Nutzerdaten können Sie unter Link Provided Service erhalten.'|<span style="color:IndianRed">&#x2612;</span>|
||String|third_legal_basis_data_coll_en|do.|'The use of Provided Service serves the purpose Purpose. This represents a legitimate interest under article law. Consent can be revoked at any time. Please find further information on the use of personal data at Link.'|<span style="color:IndianRed">&#x2612;</span>|
||String|third_objection_data_coll_de|<span style="color:Aquamarine">Free text:</span> Objection and elimination to personal data collection and processing|'Sie können der Sammlung Ihrer Daten durch Provided Service widersprechen, indem Sie Aktion ausführen.'|<span style="color:IndianRed">&#x2612;</span>|
||String|third_objection_data_coll_en|do.|'You can object to the collection of your personal data carried out by Provided Service by carrying out action.'|<span style="color:IndianRed">&#x2612;</span>|
|**(Bavarian) Data Protection Commissioner**|String|data_comm_title_de|Title data protection commissioner <span style="color:Aquamarine">(in German with definite article)|'die Datenschutzbeauftragte Beispiellands'|<span style="color:DarkCyan">&#x2611;</span>|
||String|data_comm_title_en|do. <span style="color:Aquamarine">(in English without definite article)|'Examplary Commissioner for Data Protection'|<span style="color:DarkCyan">&#x2611;</span>|
||String|data_comm_address|Address data protection commissioner|'Main Street'|<span style="color:DarkCyan">&#x2611;</span>|
||String|data_comm_plz|Postal code data protection commissioner|'11011'|<span style="color:DarkCyan">&#x2611;</span>|
||String|data_comm_city_de|City data protection commissioner|'Beispielstadt'|<span style="color:DarkCyan">&#x2611;</span>|
||String|data_comm_city_en|do.|'Anytown'|<span style="color:DarkCyan">&#x2611;</span>|
||String|date|Page generation date "YYYY-MM-DD"|'2023.08.29'|<span style="color:DarkCyan">&#x2611;</span>|