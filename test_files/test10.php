<?php
$statusLog = array(
    array(
        'date' => date("U", strtotime("2015-10-13")),
        'oldState' => null,
        'newState' => Settings::CAMPAIGN_STATUS_PAUSED
    ),
    array(
        'date' => date("U", strtotime("2015-10-16")),
        'oldState' => Settings::CAMPAIGN_STATUS_PAUSED,
        'newState' => Settings::CAMPAIGN_STATUS_RUNNING
    )
);