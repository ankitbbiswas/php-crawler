<?php

// File: SqlInjectionRisk.php
function checkSqlInjectionRisk($url) {
    $injectionStrings = ["'", '"', '--', '/*', '*/', '@@', '@', 'char', 'nchar', 'varchar', 'nvarchar', 'alter', 'begin', 'cast', 'create', 'cursor', 'declare', 'delete', 'drop', 'end', 'exec', 'execute', 'fetch', 'insert', 'kill', 'select', 'sys', 'sysobjects', 'syscolumns', 'table', 'update'];
    foreach ($injectionStrings as $injection) {
        if (strpos($url, $injection) !== false) {
            return "Yes";
        }
    }
    return "-";
}