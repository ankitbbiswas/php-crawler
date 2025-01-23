<?php

function checkDirectory($directoryToCheck) {
    if (!is_dir($directoryToCheck)) {
        mkdir($directoryToCheck, 0755, true);
    }
}
