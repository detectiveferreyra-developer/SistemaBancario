<?php
try {
    $word = new COM("Word.Application") or die("Unable to instantiate Word");
    echo "Word is installed. Version: {$word->Version}\n";
    $word->Quit();
} catch (Exception $e) {
    echo "COM error: " . $e->getMessage();
}
