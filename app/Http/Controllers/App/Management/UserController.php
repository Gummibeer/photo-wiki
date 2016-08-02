<?php
namespace App\Http\Controllers\App\Management;

use App\DataTables\UserDataTable;
use App\Http\Requests\Management\User\EditRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorize('manage', User::class);
    }

    public function getIndex(UserDataTable $dataTable)
    {
        return $dataTable->render('app.management.user.index');
    }

    public function getEdit(Request $request, User $user)
    {
        $this->authorize('edit', $user);

        return view('app.management.user.edit')->with([
            'model' => $user,
            'title' => __('Benutzer bearbeiten')
        ]);
    }

    public function putEdit(EditRequest $request, User $user)
    {
        if($request->has('password')) {
            $user->setPassword($request->get('password'));
        }

        $user->update([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
        ]);

        \Alert::success(trans('alerts.save_success'))->flash();
        return redirect()->route('app.management.get.user.edit', $user->getKey());
    }
}
