#!/usr/bin/env php
<?php
class Settings {
    const CAMPAIGN_STATUS_PAUSED = 'paused';
    const CAMPAIGN_STATUS_RUNNING = 'running';
    const CAMPAIGN_STATUS_COMPLETE = 'complete';
}

function calc_diff($startTS, $endTS) {
    return abs((int)$endTS - (int)$startTS);
}

/**
 * parse_state_log
 *
 * @param array $states array of state logs to parse.  Assumed to be in the format of array(array( 'date' => string, 'oldState' => string, 'newState' => string))
 * @param string $startDate (optional) valid date string format please.  Defaults to null
 * @param string $stopDate (optional) valid date string format please.  Defaults to null
 * @param string $checkState (optional) The state to check the total time a campaign was in.  Defaults to 'running'
 *
 * @return array Returns an array with data in the form of array('start' => startDate or null, 'stop' => stopDate or null, 'runtime' => int [time in seconds that it was in the state], 'state' => the state checked)
 */
function parse_state_log($states, $startDate = null, $stopDate = null, $checkState = Settings::CAMPAIGN_STATUS_RUNNING) {
    $runTime = 0;
    $inState = false;
    $changeAt = null;
    $startDate = (int)$startDate;
    $stopDate = (int)$stopDate;

    $len = count($states);

    foreach ($states as $idx => $log) {
        if ($log['newState'] == $checkState) {
            $changed = (int)$log['date'];
            if (($startDate < $changed) && ($stopDate && ($changed < $stopDate))) {
                $changeAt = $changed;
            }
        }

        if ($log['oldState'] == $checkState) {
            $runTime += calc_diff($log['date'], $changeAt);
        }
        
        if ((($idx + 1) == $len)  && ($log['newState'] == $checkState)) {
            if ($stopDate) {
                $runTime += calc_diff($stopDate, $log['date']);
            } else {
                $inState = true;
            }
        }
    }

    if ($inState) {
        $runTime = time() - $changeAt + $runTime;
    } 

    return array("start" => $startDate,
                 "stop" => $stopDate,
                 "runtime" => $runTime,
                 "state" => $checkState);
}


if (php_sapi_name() === 'cli') {

    $VALID_CHECKS = [Settings::CAMPAIGN_STATUS_RUNNING, 
                    Settings::CAMPAIGN_STATUS_PAUSED,
                    Settings::CAMPAIGN_STATUS_COMPLETE];

    if (!defined("STDIN")) {
        define("STDIN", fopen('php://stdin', 'r'));
    }

    $shortopts = "t:f:";
    $longopts = array(
        "start::",
        "stop::"
    );

    $start = null;
    $stop = null;

    $args = getopt($shortopts, $longopts);

    $checkType = strtolower($args['t']);

    if (!in_array($checkType, $VALID_CHECKS)) {
        print("That isn't a valid type to check.".PHP_EOL);
        exit();
    }

    if (isset($args['start'])) {
        $start = strtotime($args['start']);
    }

    if (isset($args['stop'])) {
        $stop = strtotime($args['stop']);
    }

    $path = join(DIRECTORY_SEPARATOR, array(__DIR__, $args['f']));
    include($path);

    $res = parse_state_log($statusLog, $start, $stop, $args['t']);

    echo "StartDate: ", (isset($res['start']) ? $res['start'] : 'null'), PHP_EOL;
    echo "StopDate: ", (isset($res['stop']) ? $res['stop'] : 'null'), PHP_EOL;
    echo "Answer: ", $res['runtime'], PHP_EOL;
}
