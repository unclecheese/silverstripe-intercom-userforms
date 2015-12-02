<?php

class IntercomUserDefinedFormExtension extends DataExtension {


	/**
	 * This is a bit of a hack. This is not what this extension point is intended for,
	 * but we're hijacking it because it's the only extension point that passes the
	 * $form object.
	 */
	public function updateFilteredEmailRecipients ($recipients, $data, $form) {
		$form->sendToIntercom();
	}	
}