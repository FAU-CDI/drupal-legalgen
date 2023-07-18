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

||Section|Type|Key|Description|Required|
|----:|----:|----|----|----|--:|
|**<span style="color:LightSlateGray"><u>Legal Notice</u></span>**|**General**|String|wisski_url|WissKI URL|<span style="color:DarkCyan">&#x2611;</span>|
|||String|project_name_de|Name WissKI|<span style="color:DarkCyan">&#x2611;</span>|
|||String|project_name_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
||**Publisher**|String|pub_institute_de|Name institute publisher|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_institute_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_name|Name publisher|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_address|Address publisher|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_plz|Postal code publisher|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_city_de|City publisher|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_city_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_email|E-mail publisher|<span style="color:DarkCyan">&#x2611;</span>|
|||String|cust_legal_form_de|<span style="color:Aquamarine">Free text: Leave empty if FAU specific text should be displayed.</span> Custom text regarding legal form and representation|<span style="color:IndianRed">&#x2612;</span>|
|||String|cust_legal_form_en|do.|<span style="color:IndianRed">&#x2612;</span>|
||**Contact Person Content**|String|contact_name|Name contact person content|<span style="color:DarkCyan">&#x2611;</span>|
|||String|contact_phone|Phone number contact person content|<span style="color:DarkCyan">&#x2611;</span>|
|||String|contact_email|E-mail contact person content|<span style="color:DarkCyan">&#x2611;</span>|
||**Support and Hosting**|String|sup_institute_de|Name institute support and hosting|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sup_institute_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sup_email|E-mail support and hosting|<span style="color:DarkCyan">&#x2611;</span>|
|||<span style="color:Aquamarine">Array</span>|sup_staff_array|Individual staff members support and hosting|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sup_url|Support and hosting URL|<span style="color:DarkCyan">&#x2611;</span>|
||**Supervisory Authority**|String|auth_name_de|Name supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|
|||String|auth_name_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|auth_address|Address supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|
|||String|auth_plz|Postal code supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|
|||String|auth_city_de|City supervisory authority|<span style="color:DarkCyan">&#x2611;</span>|
|||String|auth_city_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|auth_url|Supervisory authority URL|<span style="color:DarkCyan">&#x2611;</span>|
||**Copyright**|String|licence_title_de|Name copyright license|<span style="color:IndianRed">&#x2612;</span>|
|||String|licence_title_de|do.|<span style="color:IndianRed">&#x2612;</span>|
|||String|licence_url|Copyright license URL|<span style="color:IndianRed">&#x2612;</span>|
|||<span style="color:Aquamarine">Boolean</span>|use_fau_temp|Checkbox: INSTEAD OF default text display costum information on copyright|<span style="color:IndianRed">&#x2612;</span>|
|||<span style="color:Aquamarine">Boolean</span>|no_default_txt|Checkbox: WissKI (partially) uses FAU corporate design|<span style="color:IndianRed">&#x2612;</span>|
|||String|cust_licence_txt_de|<span style="color:Aquamarine">Free text:</span> Costum information on copyright|<span style="color:IndianRed">&#x2612;</span>|
||**Exclusion of Liability**|String|cust_exclusion_de|<span style="color:Aquamarine">Free text:</span> Custom information on liability exclusion|<span style="color:IndianRed">&#x2612;</span>|
||**Disclaimer External Links**|<span style="color:Aquamarine">Boolean</span>|show_disclaim|Checkbox: Section 'Links and references (disclaimer)' should not be displayed|<span style="color:IndianRed">&#x2612;</span>|
|||String|cust_disclaim_de|<span style="color:Aquamarine">Free text:</span> Custom information on liability for links|<span style="color:IndianRed">&#x2612;</span>|
||**Generation Date**|String|date|Page generation date <span style="color:Aquamarine">"YYYY-MM-DD"</span>|<span style="color:DarkCyan">&#x2611;</span>|
|||||||
|||||||
|**<span style="color:LightSlateGray"><u>Accessibility</u></span>**|**General**|String|wisski_url|WissKI URL|<span style="color:DarkCyan">&#x2611;</span>|
|||String|leg_notice_url_de|URL to legal notice|<span style="color:DarkCyan">&#x2611;</span>|
|||String|leg_notice_url_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|project_name_de|Name WissKI|<span style="color:DarkCyan">&#x2611;</span>|
|||String|project_name_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
||**Conformity**|String|status|Dropdown: Either <span style="color:Aquamarine">"Completely compliant"</span> or <span style="color:Aquamarine">"Partially compliant"</span>|<span style="color:DarkCyan">&#x2611;</span>|
|||String|methodology_de|Assessment methodology|<span style="color:DarkCyan">&#x2611;</span>|
|||String|methodology_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|creation_date|Date assessment|<span style="color:DarkCyan">&#x2611;</span>|
|||String|last_revis_date|Last revision assessment|<span style="color:DarkCyan">&#x2611;</span>|
|||String|report_url|Report URL|<span style="color:IndianRed">&#x2612;</span>|
||**Contents Not Accessible to All**|<span style="color:Aquamarine">Array</span>|issues_array_de|<span style="color:Aquamarine">Free text:</span> Individual issue descriptions|<span style="color:IndianRed">&#x2612;</span>|
|||<span style="color:Aquamarine">Array</span>|issues_array_en|do.|<span style="color:IndianRed">&#x2612;</span>|
|||<span style="color:Aquamarine">Array</span>|statement_array_de|<span style="color:Aquamarine">Free text:</span> Statements for each issue from issues_array|<span style="color:IndianRed">&#x2612;</span>|
|||<span style="color:Aquamarine">Array</span>|statement_array_en|do.|<span style="color:IndianRed">&#x2612;</span>|
|||<span style="color:Aquamarine">Array</span>|alternatives_array_de|<span style="color:Aquamarine">Free text:</span> Alternatives for contents not accessible|<span style="color:IndianRed">&#x2612;</span>|
|||<span style="color:Aquamarine">Array</span>|alternatives_array_en|do.|<span style="color:IndianRed">&#x2612;</span>|
||**Publisher**|String|pub_institute_de|Name publisher institute|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_institute_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_inst_url|URL publisher institute|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_name|Name publisher|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_address|Address publisher|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_plz|Postal code publisher|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_city_de|City publisher|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_city_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_email|E-mail publisher|<span style="color:DarkCyan">&#x2611;</span>|
|||String|pub_url|URL publisher|<span style="color:DarkCyan">&#x2611;</span>|
||**Support and Hosting**|String|sup_institute_de|Name institute support and hosting|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sup_institute_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sup_email|E-mail support and hosting|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sup_address|Address support and hosting |<span style="color:DarkCyan">&#x2611;</span>|
|||String|sup_plz|Postal code support and hosting|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sup_city_de|City support and hosting|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sup_city_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sup_url|URL support and hosting|<span style="color:DarkCyan">&#x2611;</span>|
||**Enforcement Oversight Body**|String|overs_name_de|Name enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|
|||String|overs_name_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|overs_dept_de|Department enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|
|||String|overs_dept_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|overs_address|Address enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|
|||String|overs_plz|Postal code enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|
|||String|overs_city_de|City enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|
|||String|overs_city_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|overs_phone|Phone number enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|
|||String|overs_email|E-mail enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|
|||String|overs_url|URL enforcement oversight body|<span style="color:DarkCyan">&#x2611;</span>|
||**Generation Date**|String|date|Page generation date "YYYY-MM-DD"|<span style="color:DarkCyan">&#x2611;</span>|
|||||||
|||||||
|**<span style="color:LightSlateGray"><u>Privacy</span></u>**|**General**|String|wisski_url|URL WissKI|<span style="color:DarkCyan">&#x2611;</span>|
|||String|not_fau_en|<span style="color:Aquamarine">Replace FAU-specific text with custom text otherwise leave empty</span>|<span style="color:IndianRed">&#x2612;</span>|
|||String|not_fau_en|do.|<span style="color:IndianRed">&#x2612;</span>|
||**Data Security Official**|String|sec_off_title_de|Title data security official|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sec_off_title_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sec_off_name|Name data security official|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sec_off_add_de|Name line 2 data security official|<span style="color:IndianRed">&#x2612;</span>|
|||String|sec_off_add_en|do.|<span style="color:IndianRed">&#x2612;</span>|
|||String|sec_off_address|Address data security official|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sec_off_plz|Postal code data security official|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sec_off_city_de|City data security official|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sec_off_city_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sec_off_email|E-mail data security official|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sec_off_phone|Phone number data security official|<span style="color:DarkCyan">&#x2611;</span>|
|||String|sec_off_fax|Fax number data security official|<span style="color:IndianRed">&#x2612;</span>|
||**Third Party Services**|String|third_service_provider|Name third party service|<span style="color:IndianRed">&#x2612;</span>|
|||String|third_descr_data_coll_de|<span style="color:Aquamarine">Free text:</span> Description and scope data processing|<span style="color:IndianRed">&#x2612;</span>|
|||String|third_descr_data_coll_en|do.|<span style="color:IndianRed">&#x2612;</span>|
|||String|third_legal_basis_data_coll_de|<span style="color:Aquamarine">Free text:</span> Legal basis personal data processing|<span style="color:IndianRed">&#x2612;</span>|
|||String|third_legal_basis_data_coll_en|do.|<span style="color:IndianRed">&#x2612;</span>|
|||String|third_objection_data_coll_de|<span style="color:Aquamarine">Free text:</span> Objection and elimination to personal data collection and processing|<span style="color:IndianRed">&#x2612;</span>|
|||String|third_objection_data_coll_en|do.|<span style="color:IndianRed">&#x2612;</span>|
||**(Bavarian) Data Protection Commissioner**|String|data_comm_title_de|Title data protection commissioner <span style="color:Aquamarine">(in German with definite article)|<span style="color:DarkCyan">&#x2611;</span>|
|||String|data_comm_title_en|do. <span style="color:Aquamarine">(in English without definite article)|<span style="color:DarkCyan">&#x2611;</span>|
|||String|data_comm_address|Address data protection commissioner|<span style="color:DarkCyan">&#x2611;</span>|
|||String|data_comm_plz|Postal code data protection commissioner|<span style="color:DarkCyan">&#x2611;</span>|
|||String|data_comm_city_de|City data protection commissioner|<span style="color:DarkCyan">&#x2611;</span>|
|||String|data_comm_city_en|do.|<span style="color:DarkCyan">&#x2611;</span>|
|||String|date|Page generation date "YYYY-MM-DD"|<span style="color:DarkCyan">&#x2611;</span>|

