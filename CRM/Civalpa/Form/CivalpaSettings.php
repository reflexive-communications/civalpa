<?php

use CRM_Civalpa_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Civalpa_Form_CivalpaSettings extends CRM_Core_Form {

    /**
     * Configdb
     *
     * @var CRM_Civalpa_Config
     */
    private $config;

    /**
     * Preprocess form
     * This function is called prior to building and submitting the form
     *
     * @throws CRM_Core_Exception
     */
    public function preProcess() {
        // Get current settings
        $this->config = new CRM_Civalpa_Config(E::SHORT_NAME);
        $this->config->load();
    }

    public function buildQuickForm() {

        // get the current configuration object
        $config = $this->config->get();
        // add the debug header option:
        $this->add(
            "checkbox", // field type
            "debugMode", // field name
            "Debug header", // field label
        );
        $this->add(
            "text", // field type
            "textLineWidth", // field name
            "Text line width", // field label
        );
        $this->add(
            "checkbox", // field type
            "useTextRule", // field name
            "Use text wrap rule", // field label
        );
        $this->add(
            "text", // field type
            "htmlLineWidth", // field name
            "HTML line width", // field label
        );
        $this->add(
            "checkbox", // field type
            "useHtmlRule", // field name
            "Use HTML wrap rule", // field label
        );
        $this->addButtons(
            [
                [
                    'type' => 'submit',
                    'name' => ts('Update settings'),
                    'isDefault' => true,
                ],
            ]
        );

        $this->setTitle(ts('Civalpa Settings'));

        parent::buildQuickForm();
    }

    /**
     * If your form requires special validation, add one or more callbacks here
     */
    public function addRules() {
        $this->addFormRule(array('CRM_Civalpa_Form_CivalpaSettings', 'configValidator'));
    }

    /**
     * Validate configuration
     *
     * @param array $values Submitted values
     *
     * @return array|bool
     */
    public function configValidator($values) {
        $errors = [];
        if (!is_numeric($values["textLineWidth"]) || intval($values["textLineWidth"], 10) < 1) {
            $errors["textLineWidth"] = ts("Only positiv integer values allowed.");
        }
        if (!is_numeric($values["htmlLineWidth"]) || intval($values["htmlLineWidth"], 10) < 1) {
            $errors["htmlLineWidth"] = ts("Only positiv integer values allowed.");
        }
        return empty($errors) ? true : $errors;
    }

    /**
     * Post process form
     *
     * @throws CRM_Core_Exception
     */
    public function postProcess() {
        $newConfig = [
            "debug-mode" => $this->_submitValues["debugMode"],
            "text-line-width" => [
                "use" =>  (bool)($this->_submitValues["useTextRule"]),
                "value" => intval($this->_submitValues["textLineWidth"], 10),
            ],
            "html-line-width" => [
                "use" =>  (bool)($this->_submitValues["useHtmlRule"]),
                "value" => intval($this->_submitValues["htmlLineWidth"], 10),
            ],
        ];
        if ($newConfig !== $this->config->get()) {
            if (!$this->config->update($newConfig)) {
                CRM_Core_Session::setStatus(ts("Error while updating the config"), E::SHORT_NAME, "error");
            } else {
                CRM_Core_Session::setStatus(ts("The config has been updated."), E::SHORT_NAME, "success", [ "expires" => 5000, ]);
            }
        } else {
            CRM_Core_Session::setStatus(ts("The config is not changed. No update was needed."), E::SHORT_NAME, "info", [ "expires" => 5000, ]);
        }
        parent::postProcess();
    }

    /**
     * This virtual function is used to set the default values of various form elements.
     *
     * @return array|NULL
     *   reference to the array of default values
     */
    public function setDefaultValues()    {
        $config = $this->config->get();
        $this->_defaults['debugMode'] = $config["debug-mode"];
        $this->_defaults['textLineWidth'] = $config["text-line-width"]["value"];
        $this->_defaults['useTextRule'] = $config["text-line-width"]["use"];
        $this->_defaults['htmlLineWidth'] = $config["html-line-width"]["value"];
        $this->_defaults['useHtmlRule'] = $config["html-line-width"]["use"];

        return $this->_defaults;
    }
}
