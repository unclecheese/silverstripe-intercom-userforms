<?php

class IntercomEditableFormField extends DataExtension
{

    private static $db = array(
        'MapToIntercom' => 'Boolean',
        'IntercomFieldType' => "Varchar(20)",
        'IntercomUserField' => 'Varchar(100)',
        'IntercomCompanyField' => 'Varchar(100)',
        'NoteLabel' => 'Varchar(100)',
        'CustomAttributeName' => 'Varchar(100)'
    );


    public function updateCMSFields(FieldList $fields)
    {
        $userFields = Config::inst()->get('Intercom', 'lead_fields');
        $companyFields = Config::inst()->get('Intercom', 'company_fields');

        $fields->addFieldsToTab('Root.Intercom', array(
            CheckboxField::create('MapToIntercom', 'Store this field in Intercom'),
            DisplayLogicWrapper::create(
                DropdownField::create('IntercomFieldType', 'Where will this field be stored?', array(
                    'USER' => 'On the person',
                    'COMPANY' => 'On the company',
                    'NOTE' => 'In notes'
                ))->setEmptyString('--- Please select ---'),
                DropdownField::create('IntercomUserField', 'Which user field in Intercom does it map to?')
                    ->setSource(ArrayLib::valuekey($userFields))
                    ->displayIf('IntercomFieldType')->isEqualTo('USER')->end(),
                DropdownField::create('IntercomCompanyField', 'Which company field in Intercom does it map to?')
                    ->setSource(ArrayLib::valuekey($companyFields))
                    ->displayIf('IntercomFieldType')->isEqualTo('COMPANY')->end(),
                TextField::create('CustomAttributeName', 'Custom attribute name')
                    ->setDescription('No spaces, ideally lowercase_with_underscores')
                    ->displayIf('IntercomCompanyField')->isEqualTo('custom_attributes')
                        ->orIf('IntercomUserField')->isEqualTo('custom_attributes')->end(),
                TextField::create('NoteLabel', 'Label for this field in the note')
                    ->setDescription('Note: this should probably be the same as the "Title" field on the Main tab')
                    ->displayIf('IntercomFieldType')->isEqualTo('NOTE')->end()
            )->displayIf('MapToIntercom')->isChecked()->end()
        ));
    }

    /**
     * Accessor to get the intercom field name. Handles the $ prefix for custom attributes
     * @return string
     */
    public function getIntercomFieldName()
    {
        if (in_array('custom_attributes', [
                $this->owner->IntercomUserField,
                $this->owner->IntercomCompanyField
            ])
             && $this->owner->CustomAttributeName
        ) {
            return '$'.$this->owner->CustomAttributeName;
        }

        switch ($this->owner->IntercomFieldType) {
            case 'USER':
                return $this->owner->IntercomUserField;
            case 'COMPANY':
                return $this->owner->IntercomCompanyField;
        }
    }
}
