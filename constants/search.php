<?php

define('SEARCH_FIELDS_COURSE', [
    'id',
    'name',
    'credits',
]);

define('SEARCH_FIELDS_DELIBE', [
    'year_academic_id',
    'id',
    'semester',
    'created_at',
    'updated_at',
    'start_at',
    'level_id'
]);

define('SEARCH_FIELDS_YEAR', [
    'year_academic_id',
    'id',
    'name',
    'start',
    'end',
    'created_at',
    'updated_at',
]);


define('SEARCH_FIELDS_LEVEL', [
    'name',
    'id',
    'alias',
    'created_at',
    'updated_at',
]);


define('SEARCH_FIELDS_EVENT', [
    'id',
    'title',
    'content',
    'description',
    'start_at',
    'created_at',
    'updated_at',
]);


define('SEARCH_FIELDS_DEPARTMENT', [
    'name',
    'id',
    'alias',
    'created_at',
    'updated_at',
]);

define('SEARCH_FIELDS_TEACHER', [
    'name',
    'id',
    'firstname',
    'gender',
    'created_at',
    'updated_at',
]);


define('SEARCH_FIELDS_STUDENT', [
    'id',
    'name',
    'firstname',
    'gender',
    'phone',
    'registration_token',
    'created_at',
    'updated_at',
]);

define('SEARCH_FIELDS_USER', [
    'id',
    'name',
    'email',
    'created_at',
    'updated_at',
]);

define('SEARCH_FIELDS_RESULT', [
    'is_eligible',
    'id',
    'is_paid_labo',
    'is_paid_academic',
    'created_at',
    'updated_at',
]);

define('SEARCH_FIELDS_COURSE_FOLLOW', [
    'id',
    'student_id',
    'course_id',
    'year_academic_id',
    'created_at',
    'updated_at',
]);


define('SEARCH_FIELDS_ACTUALITY', [
    'id',
    'title',
    'description',
    'created_at',
    'updated_at',
]);
