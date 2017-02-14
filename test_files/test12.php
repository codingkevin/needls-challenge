<?php
$statusLog = array(
    array(
        'date' => date("U", strtotime("2015-10-15")),
        'oldState' => null,
        'newState' => Settings::CAMPAIGN_STATUS_PAUSED
    ),
    array(
        'date' => $start + 1800,
        'oldState' => Settings::CAMPAIGN_STATUS_PAUSED,
        'newState' => Settings::CAMPAIGN_STATUS_PAUSED
    )
);
