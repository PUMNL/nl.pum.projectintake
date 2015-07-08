<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// http://wiki.civicrm.org/confluence/display/CRMDOC42/Hook+Reference
return array (
  0 => 
  array (
    'name' => 'CRM_Projectintake_Form_Report_ProjectIntakeAnamon',
    'entity' => 'ReportTemplate',
    'params' => 
    array (
      'version' => 3,
      'label' => 'Projectinatke for Anamon',
      'description' => 'Projectintake for Anamon',
      'class_name' => 'CRM_Projectintake_Form_Report_ProjectIntakeAnamon',
      'report_url' => 'nl.pum.projectintake/projectintakeanamon',
      'component' => 'CiviCase',
    ),
  ),
);