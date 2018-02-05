<?php

namespace Botble\Member\Http\Controllers;

use Auth;
use Botble\Ecommerce\Http\Requests\EditAccountRequest;
use Botble\Ecommerce\Http\Requests\UpdatePasswordRequest;
use Botble\Member\Http\Requests\MemberChangeAvatarRequest;
use Botble\Member\Repositories\Interfaces\MemberInterface;
use Hash;
use Illuminate\Routing\Controller;
use Theme;

class PublicController extends Controller
{
    /**
     * @var MemberInterface
     */
    protected $memberRepository;

    /**
     * PublicController constructor.
     * @param MemberInterface $memberRepository
     */
    public function __construct(MemberInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * @return \Response
     * @author Turash Chowdhury
     */
    public function getOverview()
    {
        return Theme::of('member::overview')->render();
    }

    /**
     * @return \Response
     * @author Turash Chowdhury
     */
    public function getEditAccount()
    {
        return Theme::of('member::edit-account')->render();
    }

    /**
     * @param EditAccountRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Turash Chowdhury
     */
    public function postEditAccount(EditAccountRequest $request)
    {
        $this->memberRepository->createOrUpdate($request->input(), ['id' => Auth::guard('member')->user()->getKey()]);
        return redirect()->route('public.member.edit')->with('success_msg', __('Update profile successfully!'));
    }

    /**
     * @return \Response
     * @author Turash Chowdhury
     */
    public function getChangePassword()
    {
        return Theme::of('member::change-password')->render();
    }

    /**
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Turash Chowdhury
     */
    public function postChangePassword(UpdatePasswordRequest $request)
    {
        $currentUser = Auth::guard('member')->user();

        if (!Hash::check($request->input('old_password'), $currentUser->getAuthPassword())) {
            return redirect()->back()
                ->with('error_msg', trans('acl::users.current_password_not_valid'));
        }

        $this->memberRepository->update(['id' => $currentUser->getKey()], [
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect()->back()->with('success_msg', trans('acl::users.password_update_success'));
    }

    /**
     * @return \Response
     * @author Turash Chowdhury
     */
    public function getChangeProfileImage()
    {
        return Theme::of('member::change-profile-image')->render();
    }

    /**
     * @author Turash Chowdhury
     * @param MemberChangeAvatarRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postChangeProfileImage(MemberChangeAvatarRequest $request)
    {
        $file = rv_media_handle_upload($request->file('avatar'), 0, 'members');
        if (array_get($file, 'error') == true) {
            return redirect()->back()->with('error_msg', array_get($file, 'message'));
        }
        $this->memberRepository->createOrUpdate(['avatar' => $file['data']->url], ['id' => Auth::guard('member')->user()->getKey()]);
        return redirect()->back()->with('success_msg', __('Update avatar successfully!'));
    }
}