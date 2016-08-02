<?php
namespace App\Http\Controllers\App\Management;

use App\DataTables\UserDataTable;
use App\Http\Requests\App\Management\User\EditRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorize('is-root');
    }

    public function getIndex(UserDataTable $dataTable)
    {
        return $dataTable->render('app.management.user.index');
    }

    public function getEdit(Request $request, User $user)
    {
        return view('app.management.user.edit')->with([
            'model' => $user,
            'title' => __('Benutzer bearbeiten')
        ]);
    }

    public function putEdit(EditRequest $request, User $user)
    {
        $user->update([
            'is_root' => $request->get('is_root'),
            'language' => $request->get('language'),
        ]);

        \Alert::success(trans('alerts.save_success'))->flash();
        return redirect()->route('app.management.get.user.edit', $user->getKey());
    }
}
