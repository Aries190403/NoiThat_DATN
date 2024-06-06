<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Address as ModelsAddress;
use App\Models\picture;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Backend\Http\Data\DataUserType;
use Modules\Backend\Http\Request\UserRequest;
use Modules\Backend\Http\Service\UserService;
use Modules\Backend\Extentions\Address\Address;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    private $user;
    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $cities = Address::getProvinces();
        $roles = config('roles.roles');
        $title = "User";
        $users = User::where('status', DataUserType::STATUS_USER_ACTIVE)->get();
        return view('backend::user.index', ['title' => $title, 'users' => $users, 'roles' => $roles, 'cities' => $cities]);
    }

    public function create(UserRequest $request)
    {
        $this->user->createUser($request);

        $roles = config('roles.roles');
        
        $users = User::where('status', DataUserType::STATUS_USER_ACTIVE)->get();
        $title = "Users";
        $cities = Address::getProvinces();
        $html = view('backend::user.index', [
            'users' => $users,
            'roles' => $roles,
            'title' => $title,
            'cities' => $cities,
        ])->render();

        return response()->json(['html' => $html]);
    }

    public function deleted(Request $request, $id)
    {

        $user = User::find($id);
        if (!$user || $user->status === DataUserType::STATUS_USER_DELETED) {
            throw new NotFoundHttpException();
        }
        $user->status = DataUserType::STATUS_USER_DELETED;
        $user->save();

        $title = "Users";
        $cities = Address::getProvinces();
        $roles = config('roles.roles');
        $users = User::where('status', DataUserType::STATUS_USER_ACTIVE)->get();

        $html = view('backend::user.index', [
            'users' => $users,
            'roles' => $roles,
            'cities' => $cities,
            'title' => $title
        ])->render();

        return response()->json(['html' => $html]);
    }

    public function saveEditUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        try {

            DB::beginTransaction();
            try {
                $address = ModelsAddress::findOrFail($user->address_id);

                if($request->District != null){
                    $fullAddressName = Address::getFullAddressNames($request->City, $request->District, $request->Ward);
                    $address->update([
                        'city' => $fullAddressName['province_name'],
                        'district' => $fullAddressName['district_name'],
                        'ward' => $fullAddressName['ward_name'],
                        'street' => $request->street,
                        'status' => $address->status
                    ]);
                }

                $user->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'role' => $request->role,
                ]);
            } catch (ModelNotFoundException $e) {
                $fullAddressName = Address::getFullAddressNames($request->City, $request->District, $request->Ward);
                $address = ModelsAddress::create([
                    'street' => $request->street,
                    'ward' => $fullAddressName['ward_name'],
                    'district' => $fullAddressName['district_name'],
                    'city' => $fullAddressName['province_name'],
                    'created_at' => now(),
                ]);

                $user->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'role' => $request->role,
                    'address_id' => $address->id,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    
        $userData = User::find($id); 
        $roles = config('roles.roles');
        $title = "Users";
        $cities = Address::getProvinces();
        $html = view('backend::user.table.table-edit', [
            'roles' => $roles,
            'title' => $title,
            'cities' => $cities,
            'user' => $userData
        ])->render();
    
        return response()->json(['html' => $html]);
    }
    
    public function userState(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user || $user->status === DataUserType::STATUS_USER_DELETED) {
            throw new NotFoundHttpException();
        }
        if($user->locked == DataUserType::LOCK_USER_NORMAL){
            $user->locked = DataUserType::LOCK_USER_LOCKED;
        }
        else{
            $user->locked = DataUserType::LOCK_USER_NORMAL;
        };
        $user->save();
    
        $title = "Users";
        $roles = config('roles.roles');
        $cities = Address::getProvinces();
        $users = User::where('status', DataUserType::STATUS_USER_ACTIVE)->get();
    
        $html = view('backend::user.index', [
            'users' => $users,
            'roles' => $roles,
            'cities' => $cities,
            'title' => $title
        ])->render();
    
        return response()->json(['html' => $html]);
    }

    public function editUser(Request $request, $id){
        $cities = Address::getProvinces();
        $roles = config('roles.roles');
        $title = "Edit user";
        $user = User::find($id);

        if (!$user || $user->status === DataUserType::STATUS_USER_DELETED) {
            throw new NotFoundHttpException();
        }
        
        return view('backend::user.edit', ['title' => $title, 'user' => $user, 'roles' => $roles, 'cities' => $cities]);
    }

    public function upAvatar(Request $request, $id)
    {
        $disk = 'uploads';
        $directory = 'images/avatars';
    
        if ($request->hasFile('image')) {
            $filePath = $this->storeImage($request->file('image'), $disk, $directory);
            
            $user = User::find($id);
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy người dùng.']);
            }
    
            $image = $user->avatar ? picture::find($user->avatar) : new picture();
    
            if (!$image) {
                $image = new picture();
            }
    
            $image->image = $filePath;
            $image->save();
    
            $user->avatar = $image->id;
            $user->save();
    
            return response()->json(['success' => true, 'path' => $filePath]);
        }
    
        return response()->json(['success' => false, 'message' => 'Không có hình ảnh nào được tải lên.']);
    }
    
    private function storeImage($file, $disk, $directory)
    {
        if (!Storage::disk($disk)->exists($directory)) {
            Storage::disk($disk)->makeDirectory($directory);
        }
    
        $randomFileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs($directory, $randomFileName, $disk);
        return $disk . '/' . $filePath;
    }

    public function changePassword(Request $request, $id)
    {
        $password = $request->input('password');
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        $user->password = Hash::make($password);
        $user->save();
        
        return redirect()->back()->with('success');
    }
    
}
