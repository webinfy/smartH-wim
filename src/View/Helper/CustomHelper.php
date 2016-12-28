<?php

namespace Cake\View\Helper;

use Cake\View\Helper;
use Cake\Datasource\ConnectionManager;

class CustomHelper extends Helper {

    function dateDisplay($datetime) {
        if ($datetime != "" && $datetime != "NULL" && $datetime != "0000-00-00 00:00:00") {
            return date("M d, Y", strtotime($datetime));
        } else {
            return false;
        }
    }

    function dateTimeDisplay($datetime) {
        if ($datetime != "" && $datetime != "NULL" && $datetime != "0000-00-00 00:00:00") {
            return date("M d, Y h:i A", strtotime($datetime));
        } else {
            return false;
        }
    }

    public static function makeSeoUrl($url) {
        if ($url) {
            $url = trim($url);
            $value = preg_replace("![^a-z0-9]+!i", "-", $url);
            $value = trim($value, "-");
            return strtolower($value);
        }
    }

    public static function timeAgo($time_ago) {
        if (!is_numeric($time_ago)) {
            $time_ago = strtotime($time_ago);
        }
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);

        if ($seconds <= 60) {  // Seconds
            echo "$seconds seconds ago";
        } else if ($minutes <= 60) { //Minutes
            if ($minutes == 1) {
                return "one minute ago";
            } else {
                return "$minutes minutes ago";
            }
        } else if ($hours <= 24) { //Hours
            if ($hours == 1) {
                return "an hour";
            } else {
                return "$hours hours ago";
            }
        } else if ($days <= 7) { //Days
            if ($days == 1) {
                return "yesterday";
            } else {
                return "$days days ago";
            }
        } else if ($weeks <= 4.3) { //Weeks
            if ($weeks == 1) {
                return "a week ago";
            } else {
                return "$weeks weeks ago";
            }
        } else if ($months <= 12) { //Months
            if ($months == 1) {
                return "a month ";
            } else {
                return "$months months ago";
            }
        } else { //Years
            if ($years == 1) {
                return "one year ago";
            } else {
                return "$years years ago";
            }
        }
    }

    public function encrypt($text) {
        $text = urlencode(base64_encode($text));
        return $text;
    }

    public function decrypt($text) {
        $text = base64_decode(urldecode($text));
        return $text;
    }

}
