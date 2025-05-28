<?php
echo "<h2>Activity Log</h2><pre>";
echo htmlspecialchars(file_get_contents('activity.log'));
echo "</pre>";

echo "<h2>Error Log</h2><pre>";
echo htmlspecialchars(file_get_contents('error.log'));
echo "</pre>";
?>
