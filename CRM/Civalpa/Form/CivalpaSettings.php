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

        // add form elements
        $this->add(
            'select', // field type
            'favorite_color', // field name
            'Favorite Color', // field label
            $this->getColorOptions(), // list of options
            TRUE // is required
        );
        $this->addButtons(array(
            array(
                'type' => 'submit',
                'name' => E::ts('Submit'),
                'isDefault' => TRUE,
            ),
        ));

        // export form elements
        $this->assign('elementNames', $this->getRenderableElementNames());
        parent::buildQuickForm();
    }

    public function postProcess() {
        $values = $this->exportValues();
        $options = $this->getColorOptions();
        CRM_Core_Session::setStatus(E::ts('You picked color "%1"', array(
            1 => $options[$values['favorite_color']],
        )));
        parent::postProcess();
    }

    public function getColorOptions() {
        $options = array(
            '' => E::ts('- select -'),
            '#f00' => E::ts('Red'),
            '#0f0' => E::ts('Green'),
            '#00f' => E::ts('Blue'),
            '#f0f' => E::ts('Purple'),
        );
        foreach (array('1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e') as $f) {
            $options["#{$f}{$f}{$f}"] = E::ts('Grey (%1)', array(1 => $f));
        }
        return $options;
    }

    /**
     * Get the fields/elements defined in this form.
     *
     * @return array (string)
     */
    public function getRenderableElementNames() {
        // The _elements list includes some items which should not be
        // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
        // items don't have labels.  We'll identify renderable by filtering on
        // the 'label'.
        $elementNames = array();
        foreach ($this->_elements as $element) {
            /** @var HTML_QuickForm_Element $element */
            $label = $element->getLabel();
            if (!empty($label)) {
                $elementNames[] = $element->getName();
            }
        }
        return $elementNames;
    }

}
