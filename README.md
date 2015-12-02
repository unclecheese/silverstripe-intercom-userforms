# SilverStripe Intercom for Userforms module

This module adds (Intercom)[http://intercom.io) integration to the (Userforms)[https://github.com/silverstripe/silverstripe-userforms] module. It can be used to capture leads from user-defined forms in Intercom.

## Installation

`composer require unclecheese/silverstripe-intercom-userforms`

## Requirements

SilverStripe 3.2 or higher

## Dependencies

* `sminnee/silverstripe-intercom`
* `unclecheese/display-logic`

## Screenshots

![Screenshot 1](https://raw.githubusercontent.com/unclecheese/silverstripe-intercom-userforms/master/images/screenshots/1.png)

![Screenshot2] (https://raw.githubusercontent.com/unclecheese/silverstripe-intercom-userforms/master/images/screenshots/2.png)

## Usage

With this module installed, each field in your user-defined form will have a new `Intercom` tab. On that tab, you can click the checkbox that says "Store this field in Intercom." With that selected, you will then be able to choose the entity on which you want to store this field in Intercom:

* *With the user*: Store on the "user" entity (e.g. "email")
* *With the company*: Store on the "company" entity (e.g. "name")
* *In notes*: Store this field in an Intercom note, along with any other fields in the form that are mapped to a note.

### Creating notes

When fields are mapped to notes, you can and should choose a label for them, so that when the readable content of the note is created, there is a label preceding the value, for instance:

`The user added the following message: $UserMessage`

## Support

Ring Uncle Cheese.
