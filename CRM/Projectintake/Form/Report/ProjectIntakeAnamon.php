<?php

class CRM_Projectintake_Form_Report_ProjectIntakeAnamon extends CRM_Report_Form {

  protected $_addressField = FALSE;

  protected $_emailField = FALSE;

  protected $_summary = NULL;

  protected $_customGroupExtends = array();
  protected $_customGroupGroupBy = FALSE;

  function __construct() {
    $this->case_types    = CRM_Case_PseudoConstant::caseType();
    $this->case_statuses = CRM_Case_PseudoConstant::caseStatus();
    $this->activity_statuses = CRM_Core_PseudoConstant::activityStatus();

    $this->cgIntakeCC = civicrm_api3('CustomGroup', 'getsingle', array('name' => 'Intake_Customer_by_CC'));
    $this->cfApproveCC = civicrm_api3('CustomField', 'getsingle', array('name' => 'Conclusion_Do_you_want_to_approve_this_customer_', 'custom_group_id' => $this->cgIntakeCC['id']));
    $this->cgIntakeSC = civicrm_api3('CustomGroup', 'getsingle', array('name' => 'Intake_Customer_by_SC'));
    $this->cfApproveSC = civicrm_api3('CustomField', 'getsingle', array('name' => 'Conclusion_Do_you_want_to_approve_this_customer_', 'custom_group_id' => $this->cgIntakeSC['id']));
    $this->cgIntakeAnamon = civicrm_api3('CustomGroup', 'getsingle', array('name' => 'Intake_Customer_by_Anamon'));
    $this->cfApproveProjectAnamon = civicrm_api3('CustomField', 'getsingle', array('name' => 'Do_you_approve_the_project_', 'custom_group_id' => $this->cgIntakeAnamon['id']));

    $this->_columns = array(
      'civicrm_client' => array(
        'dao' => 'CRM_Contact_DAO_Contact',
        'fields' => array(
          'client_name' => array(
            'name' => 'display_name',
            'title' => ts('Client'),
            'required' => TRUE,
          ),
          'client_id' => array(
            'name' => 'id',
            'no_display' => TRUE,
            'required' => TRUE,
          ),
        ),
        'grouping' => 'contact-fields',
      ),
      'civicrm_address' => array(
        'dao' => 'CRM_Core_DAO_Address',
        'grouping' => 'contact-fields',
        'fields' => array(),
      ),
      'civicrm_country' => array(
        'dao' => 'CRM_Core_DAO_Country',
        'fields' => array(
          'name' => array(
            'title' => 'Country',
            'default' => TRUE
          ),
        ),
        'order_bys' => array(
          'name' => array(
            'title' => 'Country'
          ),
        ),
        'grouping' => 'contact-fields',
      ),
      'civicrm_case' => array(
        'dao' => 'CRM_Case_DAO_Case',
        'fields' => array(
          'id' => array(
            'title' => ts('Case ID'),
            'required' => TRUE,
            'no_display' => FALSE,
          ),
          'status_id' => array(
            'title' => ts('Case Status'),
            'default' => FALSE,
          ),
        ),
        'filters' => array(
          'status_id' => array(
            'title' => ts('Case Status'),
            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
            'options' => $this->case_statuses,
          ),
        ),
        'order_bys' => array(
          'id' => array(
            'title' => ts('Case ID'),
          )
        )
      ),
      'civicrm_case_status' => array(
        'order_bys' => array(
          'case_status' => array(
            'title' => ts('Case Status'),
            'name' => 'label',
          )
        )
      ),
      'civicrm_anamon_relationship' => array(
        'dao' => 'CRM_Contact_DAO_Relationship',
      ),
      'civicrm_anamon' => array(
        'dao' => 'CRM_Contact_DAO_Contact',
        'fields' => array(
          'anamon_name' => array(
            'name' => 'display_name',
            'title' => ts('Anamon'),
            'required' => TRUE,
          ),
          'anamon_id' => array(
            'title' => ts('Contact ID of Anamon'),
            'no_display' => TRUE,
            'required' => TRUE,
            'name' => 'id',
          ),
        ),
        'filters' => array(
          'anamon_id' => array(
            'title' => ts('Anamon'),
            'name' => 'id',
            'operatorType' => CRM_Report_Form::OP_SELECT,
            'options' => array('' => ts(' -- Please select --'))+$this->determineAnamonMembers(),
          )
        ),
        'grouping' => 'anamon-fields',
      ),
      'civicrm_case_contact' => array(
        'dao' => 'CRM_Case_DAO_CaseContact',
      ),
      'intake_cc' => array(
          'alias' => 'intake_cc',
          'dao' => 'CRM_Activity_DAO_Activity',
          'fields' => array(
            'intake_cc_date_time' => array(
              'name' => 'activity_date_time',
              'title' => ts('Date/time Intake CC'),
              'default' => TRUE,
              'type' => CRM_Utils_Type::T_DATE,
            ),
            'intake_cc_status_id' => array(
              'name' => 'status_id',
              'title' => ts('Status of Intake CC'),
            ),
          ),
          'filters' => array(
            'intake_cc_status_id' => array(
              'name' => 'status_id',
              'title' => ts('Status of Intake CC'),
              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
              'options' => $this->activity_statuses,
            ),
          ),
          'order_bys' => array(
            'intake_cc_date_time' => array(
              'name' => 'activity_date_time',
              'title' => ts('Date/time Intake CC'),
            )
          ),
        ),
      'intake_cc_cg' => array(
        'alias' => 'intake_cc_cg',
        'fields' => array(
          'intake_cc_approve' => array(
            'default' => true,
            'name' => $this->cfApproveCC['column_name'],
            'title' => ts('Customer Approved by CC')
          )
        )
      ),
      'intake_sc' => array(
        'alias' => 'intake_sc',
        'dao' => 'CRM_Activity_DAO_Activity',
        'fields' => array(
          'intake_sc_date_time' => array(
            'name' => 'activity_date_time',
            'title' => ts('Date/time Intake SC'),
            'default' => TRUE,
            'type' => CRM_Utils_Type::T_DATE,
          ),
          'intake_sc_status_id' => array(
            'name' => 'status_id',
            'title' => ts('Status of Intake SC'),
          ),
        ),
        'filters' => array(
          'intake_sc_status_id' => array(
            'title' => ts('Status of Intake SC'),
            'name' => 'status_id',
            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
            'options' => $this->activity_statuses,
          ),
        ),
        'order_bys' => array(
          'intake_sc_date_time' => array(
            'name' => 'activity_date_time',
            'title' => ts('Date/time Intake SC'),
          )
        ),
      ),
      'intake_sc_cg' => array(
        'alias' => 'intake_sc_cg',
        'fields' => array(
          'intake_sc_approve' => array(
            'default' => true,
            'name' => $this->cfApproveSC['column_name'],
            'title' => ts('Project approved by SC')
          )
        )
      ),
      'intake_anamon' => array(
        'alias' => 'intake_anamon',
        'dao' => 'CRM_Activity_DAO_Activity',
        'fields' => array(
          'intake_anamon_date_time' => array(
            'name' => 'activity_date_time',
            'title' => ts('Date/time Intake Anamon'),
            'default' => TRUE,
            'type' => CRM_Utils_Type::T_DATE,
          ),
          'intake_anamon_status_id' => array(
            'name' => 'status_id',
            'title' => ts('Status of Intake Anamon'),
          ),
        ),
        'filters' => array(
          'intake_anamon_status_id' => array(
            'title' => ts('Status of Intake Anamon'),
            'name' => 'status_id',
            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
            'options' => $this->activity_statuses,
          ),
        ),
        'order_bys' => array(
          'intake_anamon_date_time' => array(
            'name' => 'activity_date_time',
            'title' => ts('Date/time Intake Anamon'),
          )
        ),
      ),
      'intake_anamon_cg' => array(
        'alias' => 'intake_anamon_cg',
        'fields' => array(
          'intake_anamon_approve_projecct' => array(
            'default' => true,
            'name' => $this->cfApproveProjectAnamon['column_name'],
            'title' => ts('Project approved by Anamon')
          )
        )
      ),
    );

    $this->_groupFilter = FALSE;
    $this->_tagFilter = FALSE;
    $this->_add2groupSupported = FALSE;
    parent::__construct();
  }

  function determineAnamonMembers() {
    $anamon_rel_type_id = civicrm_api3('RelationshipType', 'getvalue', array('return' => 'id', 'name_a_b' => 'Anamon'));
    $sql = "SELECT DISTINCT c.id, c.display_name FROM civicrm_contact c inner join civicrm_relationship r on c.id = r.contact_id_b where r.case_id is not null and r.relationship_type_id = %1 order by c.display_name";
    $params[1] = array($anamon_rel_type_id, 'Integer');
    $dao = CRM_Core_DAO::executeQuery($sql, $params);
    $contacts = array();
    while($dao->fetch()) {
      $contacts[$dao->id] = $dao->display_name;
    }
    return $contacts;
  }

  function determineClause($tableName, $tableAlias) {
    $clauses = array();
    foreach ($this->_columns[$tableName]['filters'] as $fieldName => $field) {
      $aliases = explode(".", $field['dbAlias']);
      $aliases[0] = $tableAlias;
      $field['dbAlias'] = implode(".", $aliases);

      $clause = NULL;
      if (CRM_Utils_Array::value('type', $field) & CRM_Utils_Type::T_DATE) {
        if (CRM_Utils_Array::value('operatorType', $field) == CRM_Report_Form::OP_MONTH) {
          $op = CRM_Utils_Array::value("{$fieldName}_op", $this->_params);
          $value = CRM_Utils_Array::value("{$fieldName}_value", $this->_params);
          if (is_array($value) && !empty($value)) {
            $clause = "(month({$field['dbAlias']}) $op (" . implode(', ', $value) . '))';
          }
        }
        else {
          $relative = CRM_Utils_Array::value("{$fieldName}_relative", $this->_params);
          $from     = CRM_Utils_Array::value("{$fieldName}_from", $this->_params);
          $to       = CRM_Utils_Array::value("{$fieldName}_to", $this->_params);
          $fromTime = CRM_Utils_Array::value("{$fieldName}_from_time", $this->_params);
          $toTime   = CRM_Utils_Array::value("{$fieldName}_to_time", $this->_params);
          $clause   = $this->dateClause($field['dbAlias'], $relative, $from, $to, $field['type'], $fromTime, $toTime);
        }
      }
      else {
        $op = CRM_Utils_Array::value("{$fieldName}_op", $this->_params);
        if ($op) {
          $clause = $this->whereClause($field,
            $op,
            CRM_Utils_Array::value("{$fieldName}_value", $this->_params),
            CRM_Utils_Array::value("{$fieldName}_min", $this->_params),
            CRM_Utils_Array::value("{$fieldName}_max", $this->_params)
          );
        }
      }

      if (!empty($clause)) {
        if (!CRM_Utils_Array::value('having', $field)) {
          $clauses[] = $clause;
        }
      }
    }

    if (!empty($clauses)) {
      return " AND (".implode(" AND ", $clauses).")";
    }
    return "";
  }

  function from() {
    $anamon_rel_type_id = civicrm_api3('RelationshipType', 'getvalue', array('return' => 'id', 'name_a_b' => 'Anamon'));
    $case_status_option_group_id = civicrm_api3('OptionGroup', 'getvalue', array('return' => 'id', 'name' => 'case_status'));

    $activity_type_id = civicrm_api3('OptionGroup', 'getvalue', array('return' => 'id', 'name' => 'activity_type'));
    $intake_cc_id = civicrm_api3('OptionValue', 'getvalue', array('return' => 'value', 'name' => 'Intake Customer by CC', 'option_group_id' => $activity_type_id));
    $intake_sc_id = civicrm_api3('OptionValue', 'getvalue', array('return' => 'value', 'name' => 'Intake Customer by SC', 'option_group_id' => $activity_type_id));
    $intake_anamon_id = civicrm_api3('OptionValue', 'getvalue', array('return' => 'value', 'name' => 'Intake Customer by PrOf', 'option_group_id' => $activity_type_id));

    $intake_cc_clause = $this->determineClause('intake_cc', 'intake_cc_civireport_2');
    $intake_sc_clause = $this->determineClause('intake_sc', 'intake_sc_civireport_2');
    $intake_anamon_clause = $this->determineClause('intake_anamon', 'intake_anamon_civireport_2');

    $this->_from = "
      FROM civicrm_case {$this->_aliases['civicrm_case']}
      INNER JOIN civicrm_case_contact {$this->_aliases['civicrm_case_contact']} ON {$this->_aliases['civicrm_case_contact']}.case_id = {$this->_aliases['civicrm_case']}.id
      INNER JOIN civicrm_contact {$this->_aliases['civicrm_client']} ON {$this->_aliases['civicrm_client']}.id = {$this->_aliases['civicrm_case_contact']}.contact_id
      LEFT JOIN civicrm_relationship {$this->_aliases['civicrm_anamon_relationship']} ON {$this->_aliases['civicrm_anamon_relationship']}.case_id = {$this->_aliases['civicrm_case']}.id AND {$this->_aliases['civicrm_anamon_relationship']}.relationship_type_id = '{$anamon_rel_type_id}'
      LEFT JOIN civicrm_contact {$this->_aliases['civicrm_anamon']} ON {$this->_aliases['civicrm_anamon']}.id = {$this->_aliases['civicrm_anamon_relationship']}.contact_id_b
      LEFT JOIN civicrm_option_value {$this->_aliases['civicrm_case_status']} on {$this->_aliases['civicrm_case']}.status_id = {$this->_aliases['civicrm_case_status']}.value and {$this->_aliases['civicrm_case_status']}.option_group_id = '{$case_status_option_group_id}'

      LEFT JOIN
      (
			  SELECT intake_cc_civireport_2.*, MAX(intake_cc_civireport_2.activity_date_time), civicrm_case_activity_cc.case_id
			  FROM civicrm_activity intake_cc_civireport_2
			  INNER JOIN civicrm_case_activity civicrm_case_activity_cc on  intake_cc_civireport_2.id = civicrm_case_activity_cc.activity_id
			  WHERE intake_cc_civireport_2.is_deleted = 0 AND intake_cc_civireport_2.is_current_revision = 1 AND intake_cc_civireport_2.activity_type_id = {$intake_cc_id}
			  {$intake_cc_clause}
			  GROUP BY civicrm_case_activity_cc.case_id
		  ) AS {$this->_aliases['intake_cc']} ON {$this->_aliases['intake_cc']}.case_id = {$this->_aliases['civicrm_case']}.id


      LEFT JOIN
      (
			  SELECT intake_sc_civireport_2.*, MAX(intake_sc_civireport_2.activity_date_time), civicrm_case_activity_sc.case_id
			  FROM civicrm_activity intake_sc_civireport_2
			  INNER JOIN civicrm_case_activity civicrm_case_activity_sc on  intake_sc_civireport_2.id = civicrm_case_activity_sc.activity_id
			  WHERE intake_sc_civireport_2.is_deleted = 0 AND intake_sc_civireport_2.is_current_revision = 1 AND intake_sc_civireport_2.activity_type_id = {$intake_sc_id}
			  {$intake_sc_clause}
			  GROUP BY civicrm_case_activity_sc.case_id
		  ) AS {$this->_aliases['intake_sc']} ON {$this->_aliases['intake_sc']}.case_id = {$this->_aliases['civicrm_case']}.id


		  LEFT JOIN
      (
			  SELECT intake_anamon_civireport_2.*, MAX(intake_anamon_civireport_2.activity_date_time), civicrm_case_activity_anamon.case_id
			  FROM civicrm_activity intake_anamon_civireport_2
			  INNER JOIN civicrm_case_activity civicrm_case_activity_anamon on  intake_anamon_civireport_2.id = civicrm_case_activity_anamon.activity_id
			  WHERE intake_anamon_civireport_2.is_deleted = 0 AND intake_anamon_civireport_2.is_current_revision = 1 AND intake_anamon_civireport_2.activity_type_id = {$intake_anamon_id}
			  {$intake_anamon_clause}
			  GROUP BY civicrm_case_activity_anamon.case_id
		  ) AS {$this->_aliases['intake_anamon']} ON {$this->_aliases['intake_anamon']}.case_id = {$this->_aliases['civicrm_case']}.id


      LEFT JOIN {$this->cgIntakeCC['table_name']} {$this->_aliases['intake_cc_cg']} ON {$this->_aliases['intake_cc_cg']}.entity_id = {$this->_aliases['intake_cc']}.id
      LEFT JOIN {$this->cgIntakeSC['table_name']} {$this->_aliases['intake_sc_cg']} ON {$this->_aliases['intake_sc_cg']}.entity_id = {$this->_aliases['intake_sc']}.id
      LEFT JOIN {$this->cgIntakeAnamon['table_name']} {$this->_aliases['intake_anamon_cg']} ON {$this->_aliases['intake_anamon_cg']}.entity_id = {$this->_aliases['intake_anamon']}.id

    ";
    if ($this->isTableSelected('civicrm_country') || $this->isTableSelected('civicrm_address')) {
      $this->_from .= "
        LEFT JOIN civicrm_address {$this->_aliases['civicrm_address']} ON {$this->_aliases['civicrm_address']}.is_primary = 1 AND {$this->_aliases['civicrm_address']}.contact_id = {$this->_aliases['civicrm_client']}.id
      ";
      if ($this->isTableSelected('civicrm_country')) {
        $this->_from .= "
          LEFT JOIN civicrm_country {$this->_aliases['civicrm_country']} ON {$this->_aliases['civicrm_address']}.country_id = {$this->_aliases['civicrm_country']}.id
        ";
      }
    }
  }

  function where() {
    parent::where();

    $case_type_id = civicrm_api3('OptionGroup', 'getvalue', array('return' => 'id', 'name' => 'case_type'));
    $project_intake_id = civicrm_api3('OptionValue', 'getvalue', array('return' => 'value', 'name' => 'Projectintake', 'option_group_id' => $case_type_id));
    $this->_where .= " AND ({$this->_aliases['civicrm_case']}.case_type_id LIKE '%".CRM_Core_DAO::VALUE_SEPARATOR.$project_intake_id.CRM_Core_DAO::VALUE_SEPARATOR."%')";
  }

  function modifyColumnHeaders() {
    $this->_columnHeaders['manage_case'] = array(
      'title' => '',
      'type' => CRM_Utils_Type::T_STRING,
    );
  }

  function alterDisplay(&$rows) {
    foreach($rows as $index => $row) {
      if (isset($row['civicrm_client_client_name']) && isset($row['civicrm_client_client_id'])) {
        $url = CRM_Utils_System::url("civicrm/contact/view" , "action=view&reset=1&cid=". $row['civicrm_client_client_id'], $this->_absoluteUrl);
        $rows[$index]['civicrm_client_client_name_link'] = $url;
        $rows[$index]['civicrm_client_client_name_hover'] = ts('View contact');
      }
      if (isset($row['civicrm_anamon_anamon_name']) && isset($row['civicrm_anamon_anamon_id'])) {
        $url = CRM_Utils_System::url("civicrm/contact/view" , "action=view&reset=1&cid=". $row['civicrm_anamon_anamon_id'], $this->_absoluteUrl);
        $rows[$index]['civicrm_anamon_anamon_name_link'] = $url;
        $rows[$index]['civicrm_anamon_anamon_name_hover'] = ts('View contact');
      }
      if (isset($row['civicrm_case_status_id'])) {
        $rows[$index]['civicrm_case_status_id'] = $this->case_statuses[$row['civicrm_case_status_id']];
      }

      if (isset($row['intake_cc_intake_cc_status_id'])) {
        $rows[$index]['intake_cc_intake_cc_status_id'] = $this->activity_statuses[$row['intake_cc_intake_cc_status_id']];
      }
      if (isset($row['intake_sc_intake_sc_status_id'])) {
        $rows[$index]['intake_sc_intake_sc_status_id'] = $this->activity_statuses[$row['intake_sc_intake_sc_status_id']];
      }
      if (isset($row['intake_anamon_intake_anamon_status_id'])) {
        $rows[$index]['intake_anamon_intake_anamon_status_id'] = $this->activity_statuses[$row['intake_anamon_intake_anamon_status_id']];
      }

      if (isset($row['civicrm_case_id'])) {
        $url = CRM_Utils_System::url("civicrm/contact/view/case", 'reset=1&action=view&cid=' . $row['civicrm_client_client_id'] . '&id=' . $row['civicrm_case_id'], $this->_absoluteUrl);
        $rows[$index]['manage_case'] = ts('Manage');
        $rows[$index]['manage_case_link'] = $url;
        $rows[$index]['manage_case_hover'] = ts("Manage Case");
      }
    }
  }

  /*function buildQuery($applyLimit = TRUE) {
    $sql = parent::buildQuery();
    echo $sql; exit();
    return $sql;
  }*/
}
