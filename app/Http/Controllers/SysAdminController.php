<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\User;

class SysAdminController extends Controller
{
    /**
     * Display the System Administrator Dashboard
     */
    public function index()
    {
        // ✅ 1. Get all monitoring admins
        $admins = User::where('role', 'admin')->get();

        // ✅ 2. Calculate DB size in MB
        $dbName = DB::connection()->getDatabaseName();

        $dbSizeResult = DB::select("
            SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size
            FROM information_schema.tables
            WHERE table_schema = ?
        ", [$dbName]);

        $dbSizeMB = $dbSizeResult[0]->size ?? 0;

        // ✅ 3. Application Configuration Info
        $config = [
            'php_version'      => phpversion(),
            'laravel_version'  => app()->version(),
            'env'              => config('app.env'),
            'db_connection'    => config('database.default'),
        ];

        // ✅ 4. Basic Security Overview
        $security = [
            'https'            => request()->secure(),
            'debug_mode'       => config('app.debug'),
            'csrf_protection'  => true, // Laravel always protects forms via @csrf
            'session_driver'   => config('session.driver'),
        ];

        return view('sysadmin.dashboard', compact(
            'admins',
            'dbSizeMB',
            'config',
            'security'
        ));
    }
}
