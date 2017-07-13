<?php

Route::post('comment', ['uses' => 'CommentController@store', 'as' => 'comment']);