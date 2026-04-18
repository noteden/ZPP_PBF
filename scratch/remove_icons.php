<?php
$dir = "/home/konra/ZPP_PBF/app/Filament/Resources/";
$files = glob($dir . "*/*Resource.php");

foreach ($files as $file) {
    echo "Processing $file...\n";
    $content = file_get_contents($file);
    
    // Remove the navigationIcon property line
    $content = preg_replace('/^\s*protected static string\|BackedEnum\|null \$navigationIcon = .*?;/m', '', $content);
    
    // Remove navigationIcon from the Dashboard if it's there (it's not, usually)
    
    file_put_contents($file, $content);
}
echo "Done!\n";
