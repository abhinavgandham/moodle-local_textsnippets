<?php

class snippet_table extends \html_table {

    public function __construct(
            public array $snippets = [],
            public array $categories = []   
        ) {}

    private function get_snippets() {
            global $USER;
            $this->snippets = snippet::get_records(['userid' => $USER->id]);
    }

    private function get_categories () {
        global $USER;
        foreach (category::get_records(['userid' => $USER->id]) as $category) {
            $this->categories[$category->get('id')] = $category->get('name');
        }
    }


    public function render(): void {
         self::get_snippets();
         self::get_categories();
         $this->head = ['Label', 'Preview', 'Category', 'Visibility', 'Actions'];

        foreach ($this->snippets as $snippet) {
            $categoryid = $snippet->get('categoryid');

            $deleteurl = new moodle_url('/local/feedbackbank/snippets.php', 
            ['action' => 'delete', 
            'id' => $snippet->get('id'),
            'sesskey' => sesskey()]);

            $deletelink = html_writer::link($deleteurl, 'Delete', ['class' => 'btn btn-sm btn-danger']);


            $this->data[] = [
                $snippet->get('label'),
                shorten_text(format_text($snippet->get('content'), FORMAT_HTML), 100),
                $this->categories[$categoryid] ?? 'Uncategorised',
                $snippet->is_shared() ? 'Shared' : 'Private',
                $deletelink,
            ];
        }

        echo html_writer::table($this);
    }
}