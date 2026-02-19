<?php

namespace Framework\Sorting;

/*
 Question 1
     *  |----------Question
     *  |           |-------Type
     *  |           |-------Id
     *  |           |-------body
     *  |
     *  |-----------Answers
     *              |-------Answer
     *              |       |-------id
     *              |       |-------body
     *              |
     *              |-------Answer
     *              |       |-------id
     *              |       |-------body
     */

class Question {
    public int $number;
    public int $id;
    public string $type;
    public string $body;
    public string $picture_url;
    public array $answers = [];

}

class Answer {
    public int $id;
    public string $body;
    public int $is_correct;
}