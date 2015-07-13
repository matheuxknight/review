<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/25/15
 * Time: 11:56 AM
 */

move_uploaded_file(
    $_FILES['recording']['tmp_name'],
    sprintf('./temp/%s.%s',
        sha1_file($_FILES['recording']['tmp_name']),
        'mp3'
    )
);