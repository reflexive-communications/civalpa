<?php

require_once 'civalpa.civix.php';
// phpcs:disable
use CRM_Civalpa_ExtensionUtil as E;

// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function civalpa_civicrm_config(&$config)
{
    _civalpa_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function civalpa_civicrm_xmlMenu(&$files)
{
    _civalpa_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function civalpa_civicrm_install()
{
    _civalpa_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function civalpa_civicrm_postInstall()
{
    _civalpa_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function civalpa_civicrm_uninstall()
{
    _civalpa_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function civalpa_civicrm_enable()
{
    _civalpa_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function civalpa_civicrm_disable()
{
    _civalpa_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function civalpa_civicrm_upgrade($op, CRM_Queue_Queue $queue = null)
{
    return _civalpa_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function civalpa_civicrm_managed(&$entities)
{
    _civalpa_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function civalpa_civicrm_caseTypes(&$caseTypes)
{
    _civalpa_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function civalpa_civicrm_angularModules(&$angularModules)
{
    _civalpa_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function civalpa_civicrm_alterSettingsFolders(&$metaDataFolders = null)
{
    _civalpa_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function civalpa_civicrm_entityTypes(&$entityTypes)
{
    _civalpa_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function civalpa_civicrm_themes(&$themes)
{
    _civalpa_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function civalpa_civicrm_preProcess($formName, &$form) {
//
//}

// The functions below are changed or added by us.
/**
 * Implements hook_civicrm_alterMailParams().
 */
function civalpa_civicrm_alterMailParams(&$params, $context)
{
    // The format has to be applied only after tokens are applied.
    // It means, in case of messageTemplate context, it has to return.
    if ($context === 'messageTemplate') {
        return;
    }
    $cfg = new CRM_Civalpa_Config(E::SHORT_NAME);
    try {
        $cfg->load();
    } catch (CRM_Core_Exception $e) {
        // error case, don't modify the mail.
        // Create logger then log
        $file_logger = CRM_Core_Error::createDebugLogger(E::SHORT_NAME);
        $file_logger->err($e->getMessage());
        return;
    }
    $config = $cfg->get();
    $result = CRM_Civalpa_TextFormatter::format($config, $params["text"], $params["html"]);
    $params["text"] = $result["text"];
    $params["html"] = $result["html"];
    CRM_Civalpa_HeaderManipulator::update($params, $config, $result["debug"]);
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function civalpa_civicrm_navigationMenu(&$menu)
{
    _civalpa_civix_insert_navigation_menu(
        $menu,
        "Administer/CiviMail",
        [
            "label" => E::ts('CivAlPa Settings'),
            "name" => "civalpa_settings",
            "url" => "civicrm/admin/civalpa",
            "permission" => "administer CiviCRM",
            "separator" => 0,
        ]
    );
    _civalpa_civix_navigationMenu($menu);
}
