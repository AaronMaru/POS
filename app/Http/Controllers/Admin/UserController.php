<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Traits\Authorizable;
use App\Traits\CrudsControllerTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use Authorizable;
    use CrudsControllerTrait;

    protected $itemName = 'user';
    protected $listName = 'users';
    protected $modelPath = User::class;
    protected $viewPrefix = 'users';
    protected $routePrefix = 'users';

    public function __construct()
    {
        try {
            $this->initialize();
            $this->setPageTitle("User");
            $this->setSiteTitle("Users");
            $this->data['roles'] = Role::pluck('name', 'id');
            $this->data['permissions'] = Permission::all('name', 'id');
        } catch (Exception $e) {
            Log::debug($e);
        }
    }

    // Override query all data with search form
    public function getFilterData($request = null)
    {
        $name = $request->get('name', '');
        return User::searchName($name)->latest()->paginate(10);
    }

    public function store1(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles' => 'required|min:1'
        ]);

        $user = User::create($request->except('roles', 'permissions'));
        $this->syncPermissions($request, $user);

        return redirect()->route('users.index')
            ->with('success', 'User was created successfully :D');
    }

    public function update1(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required|min:1'
        ]);

        $user = User::findOrFail($id);
        $user->fill($request->except('roles', 'permissions', 'password'));

        if ($request->get('password')) {
            $user->password = $request->get('password');
        }

        $this->syncPermissions($request, $user);
        $user->save();
        return redirect()->route('users.index')
            ->with('success', 'User was updated successfully :D');
    }

    public function destroy($id)
    {
        if (Auth::user()->id == $id) {
            return redirect()->back()
                ->with('warning', 'Deletion of currently logged in user is not allowed :(');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()
            ->with('success', 'The user with id = ' . $id . ' delete successfully :D');
    }

    private function syncPermissions(Request $request, $user)
    {
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        $roles = Role::find($roles);

        if (!$user->hasAllRoles($roles)) {
            $user->permissions()->sync([]);
        } else {
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);
        return $user;
    }
}
