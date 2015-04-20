<?php

$custom_group = civicrm_api3('CustomGroup', 'getsingle', array('name' => 'Projectinformation'));
$custom_group_id = $custom_group['id'];
$reason_field = civicrm_api3('CustomField', 'getvalue', array('return' => 'column_name', 'name' => 'reason', 'custom_group_id' => $custom_group_id));
$activities_field = civicrm_api3('CustomField', 'getvalue', array('return' => 'column_name', 'name' => 'activities', 'custom_group_id' => $custom_group_id));
$expected_results_field = civicrm_api3('CustomField', 'getvalue', array('return' => 'column_name', 'name' => 'expected_results', 'custom_group_id' => $custom_group_id));

$customer_data = civicrm_api3('CustomGroup', 'getsingle', array('name' => 'Customers_Data'));
$model = civicrm_api3('CustomField', 'getvalue', array('name' => 'What_is_the_operational_model_of_the_organisation', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$services = civicrm_api3('CustomField', 'getvalue', array('name' => 'Products_and_or_Services_offered', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$start_year = civicrm_api3('CustomField', 'getvalue', array('name' => 'In_which_year_was_your_organisation_founded_', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$legal_form = civicrm_api3('CustomField', 'getvalue', array('name' => 'Legal_form_of_the_Organisation', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$other_legal_form  = civicrm_api3('CustomField', 'getvalue', array('name' => 'Other_Legal_Form', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$is_holding = civicrm_api3('CustomField', 'getvalue', array('name' => 'Is_your_company_part_of_a_holding_group_of_companies_', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$holding_details = civicrm_api3('CustomField', 'getvalue', array('name' => 'Please_list_the_following_details_for_the_entire_holding', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$franchise = civicrm_api3('CustomField', 'getvalue', array('name' => 'Does_your_company_work_under_a_franchising_contract_', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$franchise_details = civicrm_api3('CustomField', 'getvalue', array('name' => 'Please_explain_your_relationship_with_the_franchiseholder', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$foreign_ownship = civicrm_api3('CustomField', 'getvalue', array('name' => 'Is_there_foreign_ownership_', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$percentage_foreign_ownship = civicrm_api3('CustomField', 'getvalue', array('name' => 'Percentage_of_Foreign_Ownership', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$foreign_ownship_details = civicrm_api3('CustomField', 'getvalue', array('name' => 'Please_list_information_of_foreign_owners', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$percantage_private_ownship = civicrm_api3('CustomField', 'getvalue', array('name' => 'Percentage_of_Ownership_Private', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$percantage_gov_ownship = civicrm_api3('CustomField', 'getvalue', array('name' => 'Percentage_of_Ownership_Government', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$percantage_other_ownship = civicrm_api3('CustomField', 'getvalue', array('name' => 'Percentage_of_Ownership_Other', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$how_did_you_hear = civicrm_api3('CustomField', 'getvalue', array('name' => 'How_did_your_company_first_hear_about_CBI_PUM_', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));
$other_how_did_your  = civicrm_api3('CustomField', 'getvalue', array('name' => 'Other_ways_of_hearing_about_PUM', 'return' => 'column_name', 'custom_group_id' => $customer_data['id']));



$view = new view();
$view->name = 'projectrequest_details';
$view->description = '';
$view->tag = 'projectintake';
$view->base_table = 'civicrm_case';
$view->human_name = 'Projectrequest details';
$view->core = 7;
$view->api_version = '3.0';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

/* Display: Master */
$handler = $view->new_display('default', 'Master', 'default');
$handler->display->display_options['title'] = 'Projectrequest';
$handler->display->display_options['css_class'] = 'pum-list-view';
$handler->display->display_options['use_more_always'] = FALSE;
$handler->display->display_options['access']['type'] = 'role';
$handler->display->display_options['access']['role'] = projectintake_get_role_ids(array('Customer', 'Customer (contact)', 'Representative'));
$handler->display->display_options['cache']['type'] = 'none';
$handler->display->display_options['query']['type'] = 'views_query';
$handler->display->display_options['exposed_form']['type'] = 'basic';
$handler->display->display_options['pager']['type'] = 'some';
$handler->display->display_options['pager']['options']['items_per_page'] = '1';
$handler->display->display_options['style_plugin'] = 'grid';
$handler->display->display_options['row_plugin'] = 'fields';
/* Relationship: CiviCRM Case Contact: Case Contact's Contact ID */
$handler->display->display_options['relationships']['contact_id']['id'] = 'contact_id';
$handler->display->display_options['relationships']['contact_id']['table'] = 'civicrm_case_contact';
$handler->display->display_options['relationships']['contact_id']['field'] = 'contact_id';
$handler->display->display_options['relationships']['contact_id']['label'] = 'Customer';
$handler->display->display_options['relationships']['contact_id']['required'] = TRUE;
/* Field: CiviCRM Contacts: Contact ID */
$handler->display->display_options['fields']['id_1']['id'] = 'id_1';
$handler->display->display_options['fields']['id_1']['table'] = 'civicrm_contact';
$handler->display->display_options['fields']['id_1']['field'] = 'id';
$handler->display->display_options['fields']['id_1']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['id_1']['exclude'] = TRUE;
$handler->display->display_options['fields']['id_1']['separator'] = '';
/* Field: CiviCRM Cases: Case ID */
$handler->display->display_options['fields']['id']['id'] = 'id';
$handler->display->display_options['fields']['id']['table'] = 'civicrm_case';
$handler->display->display_options['fields']['id']['field'] = 'id';
$handler->display->display_options['fields']['id']['exclude'] = TRUE;
$handler->display->display_options['fields']['id']['separator'] = '';
/* Field: CiviCRM Contacts: Display Name */
$handler->display->display_options['fields']['display_name']['id'] = 'display_name';
$handler->display->display_options['fields']['display_name']['table'] = 'civicrm_contact';
$handler->display->display_options['fields']['display_name']['field'] = 'display_name';
$handler->display->display_options['fields']['display_name']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['display_name']['label'] = 'Customer';
$handler->display->display_options['fields']['display_name']['alter']['make_link'] = TRUE;
$handler->display->display_options['fields']['display_name']['alter']['path'] = 'customer-profile/[id_1]';
$handler->display->display_options['fields']['display_name']['element_label_type'] = 'strong';
$handler->display->display_options['fields']['display_name']['element_wrapper_type'] = 'p';
$handler->display->display_options['fields']['display_name']['link_to_civicrm_contact'] = 0;
/* Field: CiviCRM Custom: Projectinformation: What is the reason for this request for Assistance? */
if ($reason_field) {
  $handler->display->display_options['fields'][$reason_field]['id'] = $reason_field;
  $handler->display->display_options['fields'][$reason_field]['table'] = $custom_group['table_name'];
  $handler->display->display_options['fields'][$reason_field]['field'] = $reason_field;
  $handler->display->display_options['fields'][$reason_field]['element_label_type'] = 'strong';
  $handler->display->display_options['fields'][$reason_field]['empty'] = '<p>-</a>';
}
/* Field: CiviCRM Custom: Projectinformation: Which project activities do you expect the expert to perform? */
if ($activities_field) {
  $handler->display->display_options['fields'][$activities_field]['id'] = $activities_field;
  $handler->display->display_options['fields'][$activities_field]['table'] = $custom_group['table_name'];
  $handler->display->display_options['fields'][$activities_field]['field'] = $activities_field;
  $handler->display->display_options['fields'][$activities_field]['element_label_type'] = 'strong';
  $handler->display->display_options['fields'][$activities_field]['empty'] = '<p>-</a>';
}
/* Field: CiviCRM Custom: Projectinformation: What are the expected results of the project? */
if ($expected_results_field) {
  $handler->display->display_options['fields'][$expected_results_field]['id'] = $expected_results_field;
  $handler->display->display_options['fields'][$expected_results_field]['table'] = $custom_group['table_name'];
  $handler->display->display_options['fields'][$expected_results_field]['field'] = $expected_results_field;
  $handler->display->display_options['fields'][$expected_results_field]['element_label_type'] = 'strong';
  $handler->display->display_options['fields'][$expected_results_field]['empty'] = '<p>-</a>';
}
/* Field: CiviCRM Custom: Customer Data: What is the operational model of the organisation */
$handler->display->display_options['fields']['what_is_the_operational_model_of_513']['id'] = 'what_is_the_operational_model_of_513';
$handler->display->display_options['fields']['what_is_the_operational_model_of_513']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['what_is_the_operational_model_of_513']['field'] = $model;
$handler->display->display_options['fields']['what_is_the_operational_model_of_513']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['what_is_the_operational_model_of_513']['alter']['strip_tags'] = TRUE;
/* Field: CiviCRM Custom: Customer Data: Products and/or Services offered */
$handler->display->display_options['fields']['products_and_or_services_offered_86']['id'] = 'products_and_or_services_offered_86';
$handler->display->display_options['fields']['products_and_or_services_offered_86']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['products_and_or_services_offered_86']['field'] = $services;
$handler->display->display_options['fields']['products_and_or_services_offered_86']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['products_and_or_services_offered_86']['alter']['strip_tags'] = TRUE;
/* Field: CiviCRM Custom: Customer Data: In which year did your organisation started operations? */
$handler->display->display_options['fields']['in_which_year_was_your_organisat_503']['id'] = 'in_which_year_was_your_organisat_503';
$handler->display->display_options['fields']['in_which_year_was_your_organisat_503']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['in_which_year_was_your_organisat_503']['field'] = $start_year;
$handler->display->display_options['fields']['in_which_year_was_your_organisat_503']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['in_which_year_was_your_organisat_503']['separator'] = '';
/* Field: CiviCRM Custom: Customer Data: Legal form of the Organisation */
$handler->display->display_options['fields']['legal_form_of_the_organisation_76']['id'] = 'legal_form_of_the_organisation_76';
$handler->display->display_options['fields']['legal_form_of_the_organisation_76']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['legal_form_of_the_organisation_76']['field'] = $legal_form;
$handler->display->display_options['fields']['legal_form_of_the_organisation_76']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['legal_form_of_the_organisation_76']['alter']['strip_tags'] = TRUE;
/* Field: CiviCRM Custom: Customer Data: Other Legal form of the Organisation */
$handler->display->display_options['fields']['other_legal_form_of_the_organisation_76']['id'] = 'other_legal_form_of_the_organisation_76';
$handler->display->display_options['fields']['other_legal_form_of_the_organisation_76']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['other_legal_form_of_the_organisation_76']['field'] = $other_legal_form;
$handler->display->display_options['fields']['other_legal_form_of_the_organisation_76']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['other_legal_form_of_the_organisation_76']['alter']['strip_tags'] = TRUE;
$handler->display->display_options['fields']['other_legal_form_of_the_organisation_76']['hide_empty'] = TRUE;
/* Field: CiviCRM Custom: Customer Data: Is your company part of a holding/group of companies? */
$handler->display->display_options['fields']['is_your_company_part_of_a_holdin_504']['id'] = 'is_your_company_part_of_a_holdin_504';
$handler->display->display_options['fields']['is_your_company_part_of_a_holdin_504']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['is_your_company_part_of_a_holdin_504']['field'] = $is_holding;
$handler->display->display_options['fields']['is_your_company_part_of_a_holdin_504']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['is_your_company_part_of_a_holdin_504']['alter']['strip_tags'] = TRUE;
/* Field: CiviCRM Custom: Customer Data: Please list the following details for the entire holding */
$handler->display->display_options['fields']['please_list_the_following_detail_505']['id'] = 'please_list_the_following_detail_505';
$handler->display->display_options['fields']['please_list_the_following_detail_505']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['please_list_the_following_detail_505']['field'] = $holding_details;
$handler->display->display_options['fields']['please_list_the_following_detail_505']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['please_list_the_following_detail_505']['alter']['strip_tags'] = TRUE;
$handler->display->display_options['fields']['please_list_the_following_detail_505']['hide_empty'] = TRUE;
/* Field: CiviCRM Custom: Customer Data: Does your company work under a franchising contract? */
$handler->display->display_options['fields']['does_your_company_work_under_a_f_506']['id'] = 'does_your_company_work_under_a_f_506';
$handler->display->display_options['fields']['does_your_company_work_under_a_f_506']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['does_your_company_work_under_a_f_506']['field'] = $franchise;
$handler->display->display_options['fields']['does_your_company_work_under_a_f_506']['relationship'] = 'contact_id';
/* Field: CiviCRM Custom: Customer Data: Please explain your relationship with the franchiseholder */
$handler->display->display_options['fields']['please_explain_your_relationship_507']['id'] = 'please_explain_your_relationship_507';
$handler->display->display_options['fields']['please_explain_your_relationship_507']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['please_explain_your_relationship_507']['field'] = $franchise_details;
$handler->display->display_options['fields']['please_explain_your_relationship_507']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['please_explain_your_relationship_507']['alter']['strip_tags'] = TRUE;
$handler->display->display_options['fields']['please_explain_your_relationship_507']['hide_empty'] = TRUE;
/* Field: CiviCRM Custom: Customer Data: Is there foreign ownership? */
$handler->display->display_options['fields']['is_there_foreign_ownership__508']['id'] = 'is_there_foreign_ownership__508';
$handler->display->display_options['fields']['is_there_foreign_ownership__508']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['is_there_foreign_ownership__508']['field'] = $foreign_ownship;
$handler->display->display_options['fields']['is_there_foreign_ownership__508']['relationship'] = 'contact_id';
/* Field: CiviCRM Custom: Customer Data: Percentage of Foreign Ownership */
$handler->display->display_options['fields']['percentage_of_foreign_ownership_79']['id'] = 'percentage_of_foreign_ownership_79';
$handler->display->display_options['fields']['percentage_of_foreign_ownership_79']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['percentage_of_foreign_ownership_79']['field'] = $percentage_foreign_ownship;
$handler->display->display_options['fields']['percentage_of_foreign_ownership_79']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['percentage_of_foreign_ownership_79']['hide_empty'] = TRUE;
$handler->display->display_options['fields']['percentage_of_foreign_ownership_79']['empty_zero'] = TRUE;
/* Field: CiviCRM Custom: Customer Data: Please list information of foreign owners */
$handler->display->display_options['fields']['please_list_information_of_forei_509']['id'] = 'please_list_information_of_forei_509';
$handler->display->display_options['fields']['please_list_information_of_forei_509']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['please_list_information_of_forei_509']['field'] = $foreign_ownship_details;
$handler->display->display_options['fields']['please_list_information_of_forei_509']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['please_list_information_of_forei_509']['alter']['strip_tags'] = TRUE;
$handler->display->display_options['fields']['please_list_information_of_forei_509']['hide_empty'] = TRUE;
/* Field: CiviCRM Custom: Customer Data: Percentage of Ownership - Private */
$handler->display->display_options['fields']['percentage_of_ownership_private_82']['id'] = 'percentage_of_ownership_private_82';
$handler->display->display_options['fields']['percentage_of_ownership_private_82']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['percentage_of_ownership_private_82']['field'] = $percantage_private_ownship;
$handler->display->display_options['fields']['percentage_of_ownership_private_82']['relationship'] = 'contact_id';
/* Field: CiviCRM Custom: Customer Data: Percentage of Ownership - Government */
$handler->display->display_options['fields']['percentage_of_ownership_governme_80']['id'] = 'percentage_of_ownership_governme_80';
$handler->display->display_options['fields']['percentage_of_ownership_governme_80']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['percentage_of_ownership_governme_80']['field'] = $percantage_gov_ownship;
$handler->display->display_options['fields']['percentage_of_ownership_governme_80']['relationship'] = 'contact_id';
/* Field: CiviCRM Custom: Customer Data: Percentage of Ownership - Other */
$handler->display->display_options['fields']['percentage_of_ownership_other_81']['id'] = 'percentage_of_ownership_other_81';
$handler->display->display_options['fields']['percentage_of_ownership_other_81']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['percentage_of_ownership_other_81']['field'] = $percantage_other_ownship;
$handler->display->display_options['fields']['percentage_of_ownership_other_81']['relationship'] = 'contact_id';
/* Field: CiviCRM Custom: Customer Data: How did your company first hear about CBI/PUM? */
$handler->display->display_options['fields']['how_did_your_company_first_hear__512']['id'] = 'how_did_your_company_first_hear__512';
$handler->display->display_options['fields']['how_did_your_company_first_hear__512']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['how_did_your_company_first_hear__512']['field'] = $how_did_you_hear;
$handler->display->display_options['fields']['how_did_your_company_first_hear__512']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['how_did_your_company_first_hear__512']['alter']['strip_tags'] = TRUE;
/* Field: CiviCRM Custom: Customer Data: Other How did your company first hear about CBI/PUM? */
$handler->display->display_options['fields']['other_how_did_your_company_first_hear__512']['id'] = 'other_how_did_your_company_first_hear__512';
$handler->display->display_options['fields']['other_how_did_your_company_first_hear__512']['table'] = $customer_data['table_name'];
$handler->display->display_options['fields']['other_how_did_your_company_first_hear__512']['field'] = $other_how_did_your;
$handler->display->display_options['fields']['other_how_did_your_company_first_hear__512']['relationship'] = 'contact_id';
$handler->display->display_options['fields']['other_how_did_your_company_first_hear__512']['alter']['strip_tags'] = TRUE;
$handler->display->display_options['fields']['other_how_did_your_company_first_hear__512']['hide_empty'] = TRUE;
/* Contextual filter: CiviCRM Cases: Case ID */
$handler->display->display_options['arguments']['id']['id'] = 'id';
$handler->display->display_options['arguments']['id']['table'] = 'civicrm_case';
$handler->display->display_options['arguments']['id']['field'] = 'id';
$handler->display->display_options['arguments']['id']['default_action'] = 'not found';
$handler->display->display_options['arguments']['id']['default_argument_type'] = 'fixed';
$handler->display->display_options['arguments']['id']['summary']['number_of_records'] = '0';
$handler->display->display_options['arguments']['id']['summary']['format'] = 'default_summary';
$handler->display->display_options['arguments']['id']['summary_options']['items_per_page'] = '25';
/* Filter criterion: CiviCRM Cases: Case Type */
$handler->display->display_options['filters']['case_type']['id'] = 'case_type';
$handler->display->display_options['filters']['case_type']['table'] = 'civicrm_case';
$handler->display->display_options['filters']['case_type']['field'] = 'case_type';
$handler->display->display_options['filters']['case_type']['value'] = array(
  11 => '11',
);

/* Display: Page */
$handler = $view->new_display('page', 'Page', 'page');
$handler->display->display_options['path'] = 'customer/projectrequest/details';
