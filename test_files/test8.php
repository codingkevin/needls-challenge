<?php
$statusLog = array(
    array(
        'date' => date("U", strtotime("2015-10-15")),
        'oldState' => null,
        'newState' => Settings::CAMPAIGN_STATUS_PAUSED
    ),
    array(
        'date' => date("U", strtotime("2015-10-16")),
        'oldState' => Settings::CAMPAIGN_STATUS_PAUSED,
        'newState' => Settings::CAMPAIGN_STATUS_RUNNING
    ),
    array(
        'date' => date("U", strtotime("2015-10-17")),
        'oldState' => Settings::CAMPAIGN_STATUS_RUNNING,
        'newState' => Settings::CAMPAIGN_STATUS_PAUSED
    ),
    array(
        'date' => date("U", strtotime("2015-10-18")),
        'oldState' => Settings::CAMPAIGN_STATUS_PAUSED,
        'newState' => Settings::CAMPAIGN_STATUS_RUNNING
    ),
    array(
        'date' => date("U", strtotime("2015-10-18 12:00:00")),
        'oldState' => Settings::CAMPAIGN_STATUS_RUNNING,
        'newState' => Settings::CAMPAIGN_STATUS_PAUSED
    ),
    array(
        'date' => date("U", strtotime("2015-10-19")),
        'oldState' => Settings::CAMPAIGN_STATUS_PAUSED,
        'newState' => Settings::CAMPAIGN_STATUS_RUNNING
    )
);