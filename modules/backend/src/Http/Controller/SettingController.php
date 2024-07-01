<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;


class SettingController extends Controller
{
    public function index()
    {
        $title = "Settings";
        $settings = config('settingconfig');
        return view('backend::websetting.index', [
            'title' => $title,
            'settings' => $settings,
        ]);
    }

    public function change(Request $request)
    {
        $newConfig = $request->all();
        $currentConfig = Config::get('settingconfig');

        foreach ($newConfig as $key => $value) {
            if (array_key_exists($key, $currentConfig)) {
                $currentConfig[$key] = $value;
            }
        }
        $configPath = config_path('settingconfig.php');
        $configContent = '<?php' . PHP_EOL . PHP_EOL . 'return ' . var_export($currentConfig, true) . ';' . PHP_EOL;
        File::put($configPath, $configContent);

        return redirect()->back()->with('success', 'Configuration updated successfully.');
    }
}
