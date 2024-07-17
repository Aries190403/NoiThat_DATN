<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

    public function addImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('/uploads/images/product'), $imageName);

            $title = $request->input('title');
            $subtitle = $request->input('subtitle');
            $url = $request->input('url');

            $config = $this->readConfig();

            $config['slideshow_images'][] = [
                'image' => asset('/uploads/images/product/' . $imageName),
                'title' => $title,
                'subtitle' => $subtitle,
                'url' => $url,
            ];

            $this->saveConfig($config);

            return response()->json(['success' => true, 'path' => asset('/uploads/images/product/' . $imageName)]);
        } else {
            return response()->json(['success' => false, 'message' => 'Không có hình ảnh được tải lên.']);
        }
    }

    public function editImage(Request $request)
    {
        $index = $request->input('index');
        $title = $request->input('title');
        $subtitle = $request->input('subtitle');
        $url = $request->input('url');
    
        $config = $this->readConfig();
    
        if (isset($config['slideshow_images'][$index])) {
            $config['slideshow_images'][$index]['title'] = $title;
            $config['slideshow_images'][$index]['subtitle'] = $subtitle;
            $config['slideshow_images'][$index]['url'] = $url;
    
            $this->saveConfig($config);
    
            return response()->json(['success' => true, 'config' => $config]);
        } else {
            return response()->json(['success' => false, 'message' => 'Index không hợp lệ.']);
        }
    }
    
    private function readConfig()
    {
        $configPath = config_path('settingconfig.php');
        if (file_exists($configPath)) {
            return include $configPath;
        } else {
            return [];
        }
    }
    
    private function saveConfig($config)
    {
        $configPath = config_path('settingconfig.php');
        $content = "<?php\n\nreturn " . var_export($config, true) . ";\n";
        file_put_contents($configPath, $content);
        return response()->json(['success' => true, 'config' => $config]);
    }

    public function deleteImage(Request $request)
    {
        $index = $request->input('index');

        $config = $this->readConfig();

        if (isset($config['slideshow_images'][$index])) {
            array_splice($config['slideshow_images'], $index, 1);

            $this->saveConfig($config);

            return response()->json(['success' => true, 'config' => $config]);
        } else {
            return response()->json(['success' => false, 'message' => 'Index không hợp lệ.']);
        }
    }
    
    public function updateLockStatus(Request $request)
    {
        $newLockStatus = $request->input('lock', false);
        $settings = config('settingconfig');

        $settings['lock'] = $newLockStatus;

        Config::set('settingconfig', $settings);

        $configPath = config_path('settingconfig.php');
        file_put_contents($configPath, '<?php return ' . var_export($settings, true) . ';');

        return response()->json(['success' => true]);
    }
}
