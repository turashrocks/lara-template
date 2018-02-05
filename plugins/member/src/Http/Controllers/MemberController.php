<?php

namespace Botble\Member\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\AjaxResponse;
use Botble\Member\Http\DataTables\MemberDataTable;
use Botble\Member\Http\Requests\MemberCreateRequest;
use Botble\Member\Http\Requests\MemberEditRequest;
use Botble\Member\Repositories\Interfaces\MemberInterface;
use Exception;
use Illuminate\Http\Request;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;

class MemberController extends BaseController
{

    /**
     * @var MemberInterface
     */
    protected $memberRepository;

    /**
     * @param MemberInterface $memberRepository
     * @author Turash Chowdhury
     */
    public function __construct(MemberInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * Display all members
     * @param MemberDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Turash Chowdhury
     */
    public function getList(MemberDataTable $dataTable)
    {
        page_title()->setTitle(__('Members'));

        return $dataTable->renderTable(['title' => __('Members'), 'icon' => 'fa fa-users']);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Turash Chowdhury
     */
    public function getCreate()
    {
        page_title()->setTitle(__('Create a member'));

        return view('member::admin.create');
    }

    /**
     * Insert new Gallery into database
     *
     * @param MemberCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Turash Chowdhury
     */
    public function postCreate(MemberCreateRequest $request)
    {
        $request->merge(['password' => bcrypt($request->input('password'))]);
        $member = $this->memberRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(MEMBER_MODULE_SCREEN_NAME, $request, $member));

        if ($request->input('submit') === 'save') {
            return redirect()->route('member.list')->with('success_msg', trans('bases::notices.create_success_message'));
        } else {
            return redirect()->route('member.edit', $member->id)->with('success_msg', trans('bases::notices.create_success_message'));
        }
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Turash Chowdhury
     */
    public function getEdit($id)
    {
        $member = $this->memberRepository->findById($id);
        if (empty($member)) {
            abort(404);
        }
        page_title()->setTitle(__('Edit member #') . $id);

        return view('member::admin.edit', compact('member'));
    }

    /**
     * @param $id
     * @param MemberEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Turash Chowdhury
     */
    public function postEdit($id, MemberEditRequest $request)
    {
        if ($request->input('is_change_password') == 1) {
            $request->merge(['password' => bcrypt($request->input('password'))]);
            $data = $request->input();
        } else {
            $data = $request->except('password');
        }
        $member = $this->memberRepository->createOrUpdate($data, ['id' => $id]);

        event(new UpdatedContentEvent(MEMBER_MODULE_SCREEN_NAME, $request, $member));

        if ($request->input('submit') === 'save') {
            return redirect()->route('member.list')->with('success_msg', trans('bases::notices.update_success_message'));
        } else {
            return redirect()->route('member.edit', $id)->with('success_msg', trans('bases::notices.update_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @param AjaxResponse $response
     * @return AjaxResponse
     * @author Turash Chowdhury
     */
    public function getDelete(Request $request, $id, AjaxResponse $response)
    {
        try {
            $member = $this->memberRepository->findById($id);
            if (empty($member)) {
                abort(404);
            }
            $this->memberRepository->delete($member);
            event(new DeletedContentEvent(MEMBER_MODULE_SCREEN_NAME, $request, $member));

            return $response->setMessage(trans('bases::notices.delete_success_message'));
        } catch (Exception $e) {
            return $response->setError(true)->setMessage(trans('bases::notices.cannot_delete'));
        }
    }

    /**
     * @param Request $request
     * @param AjaxResponse $response
     * @return AjaxResponse
     * @author Turash Chowdhury
     */
    public function postDeleteMany(Request $request, AjaxResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response->setError(true)->setMessage(trans('bases::notices.no_select'));
        }

        foreach ($ids as $id) {
            $member = $this->memberRepository->findById($id);
            $this->memberRepository->delete($member);
            event(new DeletedContentEvent(MEMBER_MODULE_SCREEN_NAME, $request, $member));
        }

        return $response->setMessage(trans('bases::notices.delete_success_message'));
    }
}
