<?php
namespace App\Http\Controllers;

use App\Category;
use App\Role;
use App\SysRoutePermission;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{
    public function index(Request $request){
        if(!Auth::check() && $request->path()!= 'login'){
            return redirect('/login');
        }
        if(!Auth::check() && $request->path() == 'login'){
            return view('welcome');
        }
        $user = Auth::user();
        if($user->userType == 'User'){
            return redirect('/login');
        }
        if($request->path() == 'login'){
            return redirect('/');
        }
        return $this->checkForPermission($user,$request);
    }
    public function checkForPermission($user,$req){
        $hasPermission = false;
        $permission = json_decode($user->role->permission);
        foreach ($permission as $p){
            if($p->name == $req->path()){
                if($p->read){
                    $hasPermission = true;
                }
            }
        }
        if($hasPermission) return view('welcome');
        return view('notfound');

    }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    function addTag(Request $request){
        $this->validate($request,[
            'tagName'=> 'required'
        ]);
        return Tag::create([
            'tagName'=> $request->tagName
        ]);
    }
    function editTag(Request $request){
        $this->validate($request,[
            'tagName'=> 'required',
            'id'=>'required'
        ]);
        return Tag::where('id',$request->id)->update([
            'tagName'=>$request->tagName
        ]);
    }
    function deleteTag(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);
        return Tag::where('id',$request->id)->delete();
    }
    function getTag(){
        if ($allTags = Redis::get('tags.all')) {
            return $allTags;
        }
        $allTags = Tag::orderBy('id','desc')->get();
        // store data into redis for next 24 hours
        Redis::setex('tags.all', 60*2 , $allTags);
        return $allTags;
    }
    function getCategory(){
        return Category::orderBy('id','desc')->get();
    }
    function upload(Request $request){
        $this->validate($request,[
            'file'=> 'required|mimes:jpeg,jpg,png'
        ]);
        $picname = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'),$picname);
        return $picname;
    }
    function deleteimage(Request $request){
        $fileName = $request->imgName;
        if($this->deleteFileFromServer($fileName,false)){
            return 'done';
        }
    }
    public function deleteFileFromServer($filename,$hasFullFilePath = false){
        if(!$hasFullFilePath){
            $filePath = public_path().'/uploads/'.$filename;
        }
        if(file_exists($filePath)){
            @unlink($filePath);
            return 1;
        }
        return;
    }
    public function addCategory(Request $request){
        return Category::create([
            'categoryName'=>$request->categoryName,
            'iconImage'=>'/uploads/' .$request->iconImage
        ]);
    }
    public function deleteCategory(Request $request){

    }
    public function createUser(Request $request){
        $data = $request->validate([
            'fullName'=> 'required',
            'email'=> 'bail|required|email|unique:users',
            'password'=> 'bail|required|min:6',
            'role_id'=> 'required'
        ]);
        $data['password'] = bcrypt($request->password);
        return User::create($data);
    }
    function getUsers(){
        return User::orderBy('id','desc')->addSelect(['rolename'=>Role::select('roleName')
            ->whereColumn('id','users.role_id')
            ->limit(1)
        ])->get();
    }
    public function createRole(Request $request){
        $data = $request->validate([
            'roleName'=> 'required'
        ]);
        return Role::create($data);
    }
    function getRoles(){
        return Role::orderBy('id')->get();
    }
    function getResources(){
        return SysRoutePermission::orderBy('id')->get();
    }
    public function editUser(Request $request){
        $request->validate([
            'fullName'=> 'required',
            'email'=> 'bail|required|email|unique:users,email,1',
            'password'=> 'min:6',
            'userType'=> 'required'
        ]);
        $data = [
            'fullName'=> $request->fullName,
            'email'=>  $request->email,
            'userType'=>  $request->userType,
        ];
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        return User::where('id',$request->id)->update($data);
    }
    public function adminLogin(Request $request){
        $request->validate([
            'email'=> 'required|bail|email',
            'password'=> 'required|min:6'
        ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            if($user->role->isAdmin == 0){
                Auth::logout();
                return response()->json([
                    'msg'=> 'Authorization fail'
                ],401);
            }
            return response()->json([
                'msg'=> 'You are successfully loged in',
                'user'=> $user
            ]);
        }else{
            return response()->json([
                'msg'=> 'Email or Password is not correct'
            ],401);
        }

    }
    public function assignRole(Request $request){
        $this->validate($request,[
            'permission'=> 'required',
            'id'=>'required'
        ]);
        return Role::where('id',$request->id)->update([
            'permission'=> $request->permission
        ]);
    }

}
