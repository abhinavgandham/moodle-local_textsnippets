<?php

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/snippet.php');
require_once(__DIR__ . '/classes/category.php');
require_once(__DIR__ . '/createsnippet_form.php');
require_once(__DIR__ . '/classes/manager.php');
require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/feedbackbank/snippets.php'));
$PAGE->set_title("Feedback Bank");
$PAGE->set_heading("Feedback Bank");

$createsnippetform = new createsnippet_form();

if ($createsnippetform->is_cancelled()) {
    redirect($PAGE->url);
} else if ($createsnippetform->get_data()) {
    manager::create_snippet($createsnippetform->get_data());
}

echo $OUTPUT->header();

echo "Manage your reusable feedback snippets here.";

echo $createsnippetform->render();

$snippets = snippet::get_records(['userid' => $USER->id]);

$categorynames = [];
foreach (category::get_records(['userid' => $USER->id]) as $category) {
    $categorynames[$category->get('id')] = $category->get('name');
}

$table = new html_table();
$table->head = ['Label', 'Preview', 'Category', 'Visibility', 'Actions'];

foreach ($snippets as $snippet) {
    $categoryid = $snippet->get('categoryid');

    $table->data[] = [
        $snippet->get('label'),
        shorten_text(format_text($snippet->get('content'), FORMAT_HTML), 100),
        $categorynames[$categoryid] ?? 'Uncategorised',
        $snippet->is_shared() ? 'Shared' : 'Private',
        '',
    ];
}

echo html_writer::table($table);

echo $OUTPUT->footer();