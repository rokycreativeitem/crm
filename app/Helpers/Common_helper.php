<?php

use App\Models\Milestone;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if (!function_exists('get_phrase')) {
    function get_phrase($phrase = '', $value_replace = array())
    {
        $active_lan    = session('language') ?? get_settings('language');
        $active_lan_id = DB::table('languages')->where('name', 'like', $active_lan)->value('id');
        $lan_phrase    = DB::table('language_phrases')->where('language_id', $active_lan_id)->where('phrase', $phrase)->first();

        if ($lan_phrase) {
            $translated = $lan_phrase->translated;
        } else {
            $translated  = $phrase;
            $english_lan = DB::table('languages')->where('name', 'like', 'english')->first();
            if (DB::table('language_phrases')->where('language_id', $english_lan->id)->where('phrase', $phrase)->count() == 0) {
                DB::table('language_phrases')->insert(['language_id' => $english_lan->id, 'phrase' => $phrase, 'translated' => $translated]);
            }
        }

        if (!is_array($value_replace)) {
            $value_replace = array($value_replace);
        }
        foreach ($value_replace as $replace) {
            $translated = preg_replace('/____/', $replace, $translated, 1); // Replace one placeholder at a time
        }

        return $translated;
    }
}

if (!function_exists('currency')) {
    function currency($price = "")
    {
        // $currency_position = DB::table('system_settings')->where('key', 'currency_position')->value('value');
        // $code = DB::table('system_settings')->where('key', 'system_currency')->value('value');
        $symbol            = DB::table('currencies')->where('id', 2)->value('symbol');
        $currency_position = 'left';
        if ($currency_position == 'left') {
            return $symbol . '' . $price;
        } else {
            return $price . '' . $symbol;
        }
    }
}

if (!function_exists('get_settings')) {
    function get_settings($type = "", $return_type = false)
    {
        $value = DB::table('settings')->where('type', $type);
        if ($value->count() > 0) {
            if ($return_type === true) {
                return json_decode($value->value('description'), true);
            } elseif ($return_type === "object") {
                return json_decode($value->value('description'));
            } else {
                return $value->value('description');
            }
        } else {
            return false;
        }
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
    function get_current_user_role()
    {
        $role = Role::where('id', Auth::user()->role_id)->value('title');
        return $role;
    }
}

if (!function_exists('has_permission')) {
    function has_permission($route)
    {
        if (get_current_user_role() == 'admin') {
            return true;
        } elseif ($route) {
            $permission_id = Permission::where('route', $route)->value('id');
            $role_id       = Role::where('id', Auth::user()->role_id)->value('id');
            $permission    = RolePermission::where('role_id', $role_id)->where('permission_id', $permission_id)->first();

            if ($permission) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
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

if (!function_exists('project_id_by_code')) {
    function project_id_by_code($code = "")
    {
        $project = Project::where('code', $code)->first();
        return $project->id;
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
