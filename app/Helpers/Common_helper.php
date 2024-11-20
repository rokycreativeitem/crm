<?php

use App\Models\Milestone;
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists('get_phrase')) {
    function get_phrase($phrase)
    {
        return $phrase;
    }
}

if (!function_exists('get_user_role')) {
    function get_user_role($id)
    {
        $role_id = User::where('id', $id)->value('role_id');
        $role    = Role::where('id', $role_id)->value('title');
        return $role;
    }
}

if (!function_exists('get_current_user_role')) {
    function get_settings($param)
    {
        return $param;
    }
}
if (!function_exists('get_current_user_role')) {
    function get_current_user_role()
    {
        $role = Role::where('id', Auth::user()->role_id)->value('title');
        return $role;
    }
}

if (!function_exists('get_user')) {
    function get_user($id)
    {
        $user = User::where('id', $id)->first();
        return $user;
    }
}

if (!function_exists('get_user_info')) {
    function get_user_info($user_id = "")
    {
        $user_info = User::where('id', $user_id)->firstOrNew();
        return $user_info;
    }
}

if (!function_exists('get_image')) {
    function get_image($url = null, $optimized = false)
    {
        if ($url == null) {
            return asset('uploads/system/placeholder.png');
        }

        // If the value of URL is from an online URL
        if (str_contains($url, 'http://') && str_contains($url, 'https://')) {
            return $url;
        }

        $url_arr = explode('/', $url);
        // File name & Folder path
        $file_name = end($url_arr);
        $path      = str_replace($file_name, '', $url);

        //Optimized image url
        $optimized_image = $path . 'optimized/' . $file_name;

        if (!$optimized) {
            if (is_file(public_path($url)) && file_exists(public_path($url))) {
                return asset($url);
            } else {
                return asset($path . 'placeholder/placeholder.png');
            }
        } else {
            if (is_file(public_path($optimized_image)) && file_exists(public_path($optimized_image))) {
                return asset($optimized_image);
            } else {
                return asset($path . 'placeholder/placeholder.png');
            }
        }
    }
}

if (!function_exists('removeScripts')) {
    function removeScripts($text)
    {
        if (!$text) {
            return;
        }

        // Remove <script> tags and their content
        $pattern_script = '/<script\b[^<](?:(?!</script>)<[^<])</script>/is';
        $cleanText      = preg_replace($pattern_script, '', $text);

        // Remove inline event handlers (e.g., onclick, onmouseover)
        $pattern_inline = '/\son\w+="[^"]"/i';
        $cleanText      = preg_replace($pattern_inline, '', $cleanText);

        // Remove JavaScript: URIs
        $pattern_js_uri = '/\shref="javascript:[^"]"/i';
        $cleanText      = preg_replace($pattern_js_uri, '', $cleanText);

        // Remove other potentially dangerous tags (e.g., <iframe>, <object>, <embed>)
        $pattern_dangerous_tags = '/<(iframe|object|embed|applet|meta|link|style|base|form)\b[^<](?:(?!</\1>)<[^<])</\1>/is';
        $cleanText              = preg_replace($pattern_dangerous_tags, '', $cleanText);

        // Remove any remaining dangerous attributes (e.g., srcset on <img>)
        $pattern_dangerous_attributes = '/\s(src|srcset|data)="[^"]"/i';
        $cleanText                    = preg_replace($pattern_dangerous_attributes, '', $cleanText);

        return $cleanText;
    }
}

if (!function_exists('timeAgo')) {
    function timeAgo($time_ago)
    {
        $time_ago     = strtotime($time_ago);
        $cur_time     = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds      = $time_elapsed;
        $minutes      = round($time_elapsed / 60);
        $hours        = round($time_elapsed / 3600);
        $days         = round($time_elapsed / 86400);
        $weeks        = round($time_elapsed / 604800);
        $months       = round($time_elapsed / 2600640);
        $years        = round($time_elapsed / 31207680);
        // Seconds
        if ($seconds <= 60) {
            return "just now";
        }
        //Minutes
        else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "1 minute ago";
            } else {
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if ($hours <= 24) {
            if ($hours == 1) {
                return "1 hour ago";
            } else {
                return "$hours hours ago";
            }
        }
        //Days
        else if ($days <= 7) {
            if ($days == 1) {
                return "Yesterday";
            } else {
                return "$days days ago";
            }
        }
        //Weeks
        else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "1 week ago";
            } else {
                return "$weeks weeks ago";
            }
        }
        //Months
        else if ($months <= 12) {
            if ($months == 1) {
                return "1 month ago";
            } else {
                return "$months months ago";
            }
        }
        //Years
        else {
            if ($years == 1) {
                return "1 year ago";
            } else {
                return "$years years ago";
            }
        }
    }
}

if (!function_exists('get_task_progress')) {
    function get_task_progress($milestone_id = "")
    {
        $tasks = Milestone::where('id', $milestone_id)->value('tasks');
        if (count($tasks) > 0) {
            $total_progress = Task::whereIn('id', $tasks)->sum('progress');
            $count_tasks    = Task::whereIn('id', $tasks)->count();
            $avg            = $total_progress / $count_tasks;
            return $avg;
        }
        return 0;
    }
}
