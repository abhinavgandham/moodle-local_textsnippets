<?php

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/snippet.php');
require_once(__DIR__ . '/classes/category.php');
require_once(__DIR__ . '/createsnippet_form.php');
require_once(__DIR__ . '/classes/manager.php');
require_once(__DIR__ . '/classes/snippet_table.php');
require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/feedbackbank/snippets.php'));
$PAGE->set_title("Feedback Bank");
$PAGE->set_heading("Feedback Bank");

$action = optional_param('action', '', PARAM_ALPHA);
$id     = optional_param('id', 0, PARAM_INT);

if ($action === 'delete' && $id) {
    require_sesskey();
    manager::delete_snippet($id);
    redirect($PAGE->url);
}

$createsnippetform = new createsnippet_form();

if ($createsnippetform->is_cancelled()) {
    redirect($PAGE->url);
} else if ($createsnippetform->get_data()) {
    manager::create_snippet($createsnippetform->get_data());
}

echo $OUTPUT->header();

echo 'Manage your reusable feedback snippets here.';

echo $createsnippetform->render();

$table = new snippet_table();
$table->render();

echo $OUTPUT->footer();