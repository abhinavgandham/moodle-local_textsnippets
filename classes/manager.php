<?php

class manager {

    static function create_category(string $name): category {
        global $USER;

        $category = new category();
        $category->set('userid', $USER->id);
        $category->set('name', $name);
        $category->create();

        return $category;
    }

    static function create_snippet(\stdClass $data) {
        global $USER, $DB;

        $snippet = new snippet();
        $snippet->set('userid', $USER->id);
        $category =$category = $DB->get_record(category::TABLE, ['userid' => $USER->id, 'name' => $data->category]);
        if ($category) {
            $snippet->set('categoryid', $category->id);
        } else {
            $category = self::create_category($data->category);
            $category = $DB->get_record(category::TABLE, ['userid' => $USER->id, 'name' => $data->category]);
            $snippet->set('categoryid', $category->id); 
        }
        $snippet->set('label', $data->label);
        $snippet->set('content', $data->content['text']);
        $snippet->set('shared', $data->shared ? 1 : 0);
        $snippet->create();
    }
}