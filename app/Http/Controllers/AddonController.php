<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class AddonController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->addon_server_side($request->customSearch);
        }
        return view('addon.index');
    }

    public function add()
    {
        return view('addon.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:install,update',
            'file' => 'required|mimes:zip|max:10240', // Ensure the file is a ZIP file and max size is 10MB
        ]);

        if ($request->type == 'install') {
            $purchase_code = null;

            // Verify purchase code for non-localhost
            if ($_SERVER['SERVER_NAME'] !== 'localhost' && $_SERVER['SERVER_NAME'] !== '127.0.0.1') {
                $purchase_code = $request->code;
                $status_response = $this->verify_purchase_code($purchase_code);

                if (!$status_response) {
                    Session::flash('error', get_phrase('purchase_code_is_wrong'));
                    return redirect()->back();
                }
            }

            // Prepare directories
            $this->createDirectoryIfNotExists('application/controllers/addons');
            $this->createDirectoryIfNotExists('application/models/addons');

            // Handle uploaded file
            $uploadedFile = $request->file('file');
            $zipped_file_name = $uploadedFile->getClientOriginalName();
            $dir = public_path('uploads/addons');
            $this->createDirectoryIfNotExists($dir);
            $path = $dir . '/' . $zipped_file_name;
            $uploadedFile->move($dir, $zipped_file_name);

            if (class_exists('ZipArchive')) {
                $zip = new \ZipArchive;

                if ($zip->open($path) === TRUE) {
                    $zip->extractTo($dir);
                    $zip->close();
                    unlink($path);
                } else {
                    Session::flash('error', get_phrase('failed_to_open_the_zip_file'));
                    return redirect()->back();
                }
            } else {
                Session::flash('error', get_phrase('your_server_is_unable_to_extract_the_zip_file') . '. ' . get_phrase('please_enable_the_zip_extension_on_your_server') . ', ' . get_phrase('then_try_again'));
                return redirect()->back();
            }

            $unzipped_file_name = pathinfo($zipped_file_name, PATHINFO_FILENAME);
            $addon_path = $dir . '/' . $unzipped_file_name;
            $config_path = $addon_path . '/config.json';

            if (!file_exists($config_path)) {
                $this->remove_from_uploads($unzipped_file_name);
                Session::flash('error', get_phrase('invalid_addon_structure'));
                return redirect()->back();
            }

            $config_str = file_get_contents($config_path);
            $config = json_decode($config_str, true);

            // Create directories specified in the addon
            if (!empty($config['directories'])) {
                foreach ($config['directories'] as $directory) {
                    $this->createDirectoryIfNotExists($directory['name']);
                }
            }

            // Replace or create new files
            if (!empty($config['files'])) {
                foreach ($config['files'] as $file) {
                    copy($file['root_directory'], $file['update_directory']);
                }
            }

            // Execute SQL file (convert to migration if possible)
            if (!empty($config['sql_file']) && file_exists($addon_path . '/sql/' . $config['sql_file'])) {
                DB::unprepared(file_get_contents($addon_path . '/sql/' . $config['sql_file']));
            }

            // Insert or update the addon in the database
            $data = [
                'name' => $config['name'],
                'unique_identifier' => $config['unique_identifier'],
                'version' => $config['version'],
                'about' => $config['about'],
                'status' => 1,
            ];

            $addon_details = Addon::where('unique_identifier', $data['unique_identifier']);

            if ($addon_details->exists()) {
                $data['updated_at'] = Carbon::now();
                $addon_details->update($data);
            } else {
                $data['purchase_code'] = $purchase_code;
                $data['created_at'] = Carbon::now();
                Addon::insert($data);
            }

            // Clean up temporary files
            $this->remove_from_uploads($unzipped_file_name);

            Session::flash('success', get_phrase('addon_installed_successfully'));
            return redirect()->back();
        }

        Session::flash('error', get_phrase('no_addon_found'));
        return redirect()->back();
    }

    private function createDirectoryIfNotExists($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }

    public function remove_from_uploads($folder_name)
    {
        $dir = public_path('uploads/addons/' . $folder_name);
        if (is_dir($dir)) {
            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
        }
    }


    public function verify_purchase_code($code)
    {
        $purchase_code = $code;

        $personal_token = "FkA9UyDiQT0YiKwYLK3ghyFNRVV9SeUn";
        $url = "https://api.envato.com/v3/market/author/sale?code=" . $purchase_code;
        $curl = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:' . $purchase_code . '.json';
        $ch_verify = curl_init($verify_url . '?code=' . $purchase_code);

        curl_setopt($ch_verify, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);

        $response = json_decode($cinit_verify_data, true);

        if (count($response['verify-purchase']) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
