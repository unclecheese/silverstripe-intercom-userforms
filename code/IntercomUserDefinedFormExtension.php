<?php

class IntercomUserDefinedFormExtension extends DataExtension {

	/**
	 * This is a bit of a hack. This is not what this extension point is intended for,
	 * but we're hijacking it because it's the only extension point that passes the
	 * $form object.
	 */
	public function updateFilteredEmailRecipients ($recipients, $data, $form) {
		if($this->owner->Fields()->find('MapToIntercom', true)) {
			$userData = [];
			$companyData = [];
			$noteData = [];
			
			foreach($this->owner->Fields() as $f) {
				if(!$f->MapToIntercom) continue;
				switch($f->IntercomFieldType) {
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

			$form->setIntercomUserFieldMapping($userData)
				 ->setIntercomCompanyFieldMapping($companyData)
				 ->setIntercomNoteMapping($noteData)
				 ->setIntercomNoteHeader("Submitted on " . date('d-m-Y'))
				 ->sendToIntercom();
		}
	}
}