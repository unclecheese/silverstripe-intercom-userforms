<?php

/**
 * Uses the updateForm() extension point to set the Intercom mapping
 * on the UserForm object.
 */
class IntercomUserFormExtension extends DataExtension
{

    public function updateForm()
    {
        if (!$this->owner->getController()->Fields()->find('MapToIntercom', true)) {
            return;
        }
        
        $userData = [];
        $companyData = [];
        $noteData = [];
        
        foreach ($this->owner->getController()->Fields() as $f) {
            if (!$f->MapToIntercom) {
                continue;
            }

            switch ($f->IntercomFieldType) {
                case 'USER':
                    $userData[$f->Name] = $f->getIntercomFieldName();
                    break;
                case 'COMPANY':
                    $companyData[$f->Name] = $f->getIntercomFieldName();
                    break;
                case 'NOTE':
                    $noteData[$f->Name] = $f->NoteLabel;
                    break;
            }
        }
        
        $this->owner->addIntercomUserFieldMapping($userData)
                    ->addIntercomCompanyFieldMapping($companyData)
                    ->addIntercomNoteMapping($noteData)
                    ->setIntercomNoteHeader("Submitted on " . date('d-m-Y'));
    }
}
