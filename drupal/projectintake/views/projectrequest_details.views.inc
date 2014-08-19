<?php

$custom_group = civicrm_api3('CustomGroup', 'getsingle', array('name' => 'Projectinformation'));
$custom_group_id = $custom_group['id'];
$reason_field = civicrm_api3('CustomField', 'getvalue', array('return' => 'column_name', 'name' => 'reason', 'custom_group_id' => $custom_group_id));
$activities_field = civicrm_api3('CustomField', 'getvalue', array('return' => 'column_name', 'name' => 'activities', 'custom_group_id' => $custom_group_id));
$expected_results_field = civicrm_api3('CustomField', 'getvalue', array('return' => 'column_name', 'name' => 'expected_results', 'custom_group_id' => $custom_group_id));
$comments_field = civicrm_api3('CustomField', 'getvalue', array('return' => 'column_name', 'name' => 'Additional_Comments_on_Project_Proposal', 'custom_group_id' => $custom_group_id));


$view = new view();
$view->name = 'projectrequest_details';
$view->description = '';
$view->tag = 'default';
$view->base_table = 'civicrm_case';
$view->human_name = 'Projectrequest details';
$view->core = 7;
$view->api_version = '3.0';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

/* Display: Master */
$handler = $view->new_display('default', 'Master', 'default');
$handler->display->display_options['title'] = 'Projectrequest';
$handler->display->display_options['use_more_always'] = FALSE;
$handler->display->display_options['access']['type'] = 'role';
$handler->display->display_options['access']['role'] = array(
  6 => '6',
);
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
$handler->display->display_options['fields']['display_name']['alter']['path'] = '/customer/[id_1]';
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
/* Field: CiviCRM Custom: Projectinformation: Additional Comments on Project Proposal */
if ($comments_field) {
  $handler->display->display_options['fields'][$comments_field]['id'] = $comments_field;
  $handler->display->display_options['fields'][$comments_field]['table'] = $custom_group['table_name'];
  $handler->display->display_options['fields'][$comments_field]['field'] = $comments_field;
  $handler->display->display_options['fields'][$comments_field]['element_label_type'] = 'strong';
  $handler->display->display_options['fields'][$comments_field]['empty'] = '<p>-</a>';
}
/* Field: Global: Custom text */
$handler->display->display_options['fields']['nothing']['id'] = 'nothing';
$handler->display->display_options['fields']['nothing']['table'] = 'views';
$handler->display->display_options['fields']['nothing']['field'] = 'nothing';
$handler->display->display_options['fields']['nothing']['label'] = '';
$handler->display->display_options['fields']['nothing']['alter']['text'] = '<a href="/representative/projects-requests/asses?cid2=[id_1]&caseid=[id]">Asses</a>';
$handler->display->display_options['fields']['nothing']['element_label_colon'] = FALSE;
$handler->display->display_options['fields']['nothing']['element_wrapper_type'] = 'p';
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
$handler->display->display_options['path'] = 'representative/projectrequest/details';
