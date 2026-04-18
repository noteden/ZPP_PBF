<?php
// Correct Icons and Groups for resources
$resources = [
    'Categories/CategoryResource.php' => ['Icon' => 'OutlinedFolder', 'Group' => 'Forum System'],
    'Forums/ForumResource.php' => ['Icon' => 'OutlinedChatBubbleLeftEllipsis', 'Group' => 'Forum System'],
    'Threads/ThreadResource.php' => ['Icon' => 'OutlinedChatBubbleBottomCenter', 'Group' => 'Forum System'],
    'Posts/PostResource.php' => ['Icon' => 'OutlinedChatBubbleLeftRight', 'Group' => 'Forum System'],
    'PostReports/PostReportResource.php' => ['Icon' => 'OutlinedFlag', 'Group' => 'Forum System'],
    
    'Charakters/CharakterResource.php' => ['Icon' => 'OutlinedUser', 'Group' => 'Game Mechanics'],
    'CharakterSheets/CharakterSheetResource.php' => ['Icon' => 'OutlinedDocumentText', 'Group' => 'Game Mechanics'],
    'Skills/SkillResource.php' => ['Icon' => 'OutlinedSparkles', 'Group' => 'Game Mechanics'],
    'Equipments/EquipmentResource.php' => ['Icon' => 'OutlinedShoppingBag', 'Group' => 'Game Mechanics'],
    
    'Missions/MissionResource.php' => ['Icon' => 'OutlinedRocketLaunch', 'Group' => 'Gameplay'],
    'Events/EventResource.php' => ['Icon' => 'OutlinedCalendar', 'Group' => 'Gameplay'],
    
    'PrivateMessages/PrivateMessageResource.php' => ['Icon' => 'OutlinedEnvelope', 'Group' => 'Communication'],
    'Suggestions/SuggestionResource.php' => ['Icon' => 'OutlinedLightBulb', 'Group' => 'Communication'],
    
    'Users/UserResource.php' => ['Icon' => 'OutlinedUsers', 'Group' => 'Administration'],
    'Profiles/ProfileResource.php' => ['Icon' => 'OutlinedUserCircle', 'Group' => 'Administration'],
    'Documents/DocumentsResource.php' => ['Icon' => 'OutlinedDocument', 'Group' => 'Administration'],
    'Tutorials/TutorialResource.php' => ['Icon' => 'OutlinedPlayCircle', 'Group' => 'Administration'],
];

foreach ($resources as $path => $data) {
    echo "Processing $path...\n";
    $fullPath = "/home/konra/ZPP_PBF/app/Filament/Resources/" . $path;
    $content = file_get_contents($fullPath);
    
    // Replace Icon
    $content = preg_replace(
        '/protected static string\|BackedEnum\|null \$navigationIcon = Heroicon::\w+;/',
        "protected static string|BackedEnum|null \$navigationIcon = Heroicon::{$data['Icon']};",
        $content
    );
    
    // Replace Group (we already added it with sed, but let's ensure it's correct)
    $content = preg_replace(
        '/protected static string \| \\\\UnitEnum \| null \$navigationGroup = \'.*\';/',
        "protected static string | \\UnitEnum | null \$navigationGroup = '{$data['Group']}';",
        $content
    );
    
    file_put_contents($fullPath, $content);
}
echo "Done!\n";
