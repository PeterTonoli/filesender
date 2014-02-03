<?php

$statusMsg = '';
$statusClass = '';

if ($s == "complete" || $s == "completev") {
    if (isset($_REQUEST['gid']) && ensureSaneOpenSSLKey($_REQUEST['gid']) && $functions->isValidGroupId($_REQUEST['gid'])) {
        // Upload completed, display list of uploaded files.
        echo '<div class="box">';
        $groupId = $_REQUEST['gid'];
        $files = $functions->getMultiFileData($groupId);

        $list = "";
        $totalSize = 0;

        foreach ($files as $file) {
            $totalSize += $file['filesize'];
            $list .= '<li>' . $file['fileoriginalname'] . ' (' . formatBytes($file['filesize']) . ')</li>';
        }

        echo lang("_TRACKING_CODE") . ': ' . $files[0]['filetrackingcode'] . '<br /><br />';

        if (isset($_REQUEST['start']) && isset($_REQUEST['end'])) {
            $start = intval($_REQUEST['start']);
            $end = intval($_REQUEST['end']);
            if (isset($_REQUEST['timepaused'])){
                $timePaused = intval($_REQUEST['timepaused']);
            } else {
                $timePaused = 0;
            }

            echo 'Upload start time: ' . date('H:i:s', $start) . '<br />';
            echo 'Upload end time: ' . date('H:i:s', $end) . '<br />';
            echo 'Total time spent paused: ' . date('i:s', $timePaused) . '<br /><br />';

            $uploadSpeed = $totalSize / ($end - $start - $timePaused); // Bytes per second.

            echo 'Average upload speed: ' . formatBytes($uploadSpeed) . '/s. <br /><br />';
        }

        echo lang("_UPLOADED_LIST");
        echo '<ul>' . $list . '</ul>';

        if ($s != "completev") {
            echo lang("_REFER_TO_MY_FILES");
        }
        echo '</div>';

        $statusMsg = lang("_UPLOAD_COMPLETE");
        $statusClass = 'green';
    } else {
        // Group ID wasn't supplied, so nothing to show here.
        if ($isAuth) {
            require_once('../pages/multiupload.php');
        } else {
            require_once('../pages/logon.php');
        }
    }
} else {
    // An error occurred, display error message.

    $statusMsg = lang("_ERROR_UPLOAD_FAILED");
    $statusClass = 'red';

    echo '<div class="box" style="text-align: center">';

    if ($s == "uploaderror") {
        echo lang("_ERROR_UPLOADING_FILE");
    } else if ($s == "emailsenterror") {
        echo lang("_ERROR_SENDING_EMAIL");
    } else if ($s == "filesizeincorrect") {
        echo lang("_ERROR_INCORRECT_FILE_SIZE");
    }

    echo '</div>';
}
?>

<script type="text/javascript">
    var statusMsg = '<?php echo $statusMsg; ?>';
    var statusClass = '<?php echo $statusClass; ?>';
    // doc ready
    $(function() {
        if (statusMsg != '') {
            statusMessage(statusMsg, statusClass);
        }
    });
</script>