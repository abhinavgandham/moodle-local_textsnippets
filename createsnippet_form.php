<?php

require(__DIR__ . '/../../lib/formslib.php');
require_once(__DIR__ . '/classes/snippet.php');

class createsnippet_form extends \moodleform {
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'label', 'Label');
        $mform->setType('label', PARAM_TEXT);
        $mform->addRule('label', null, 'required', null, 'client');

        $mform->addElement('editor', 'content', 'Content');
        $mform->setType('content', PARAM_RAW);
        $mform->addRule('content', null, 'required', null, 'client');

        $mform->addElement('text', 'category', 'Category');
        $mform->setType('category', PARAM_TEXT);
        $mform->addRule('category', null, 'required', null, 'client');

        $mform->addElement('checkbox', 'shared', 'Shared');
        $mform->setType('shared', PARAM_BOOL);

        $buttonarray = [
            $mform->createElement('submit', 'submitbutton', 'Add snippet'),
            $mform->createElement('cancel', 'cancel', 'Reset'),
        ];
        $mform->addGroup($buttonarray, 'buttonar', '', [' '], false);
        $mform->closeHeaderBefore('buttonar');
    }
        
}