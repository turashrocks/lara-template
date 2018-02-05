<?php

namespace Botble\Block\Http\Controllers;

use Assets;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\AjaxResponse;
use Botble\Block\Http\Requests\BlockRequest;
use Botble\Block\Repositories\Interfaces\BlockInterface;
use Illuminate\Http\Request;
use MongoDB\Driver\Exception\Exception;
use Botble\Block\Http\DataTables\BlockDataTable;
use Auth;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;

class BlockController extends BaseController
{
    /**
     * @var BlockInterface
     */
    protected $blockRepository;

    /**
     * BlockController constructor.
     * @param BlockInterface $blockRepository
     * @author Turash Chowdhury
     */
    public function __construct(BlockInterface $blockRepository)
    {
        $this->blockRepository = $blockRepository;
    }

    /**
     * Display all block
     * @param BlockDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Turash Chowdhury
     */
    public function getList(BlockDataTable $dataTable)
    {
        page_title()->setTitle(trans('block::block.list'));

        return $dataTable->renderTable(['title' => trans('block::block.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Turash Chowdhury
     */
    public function getCreate()
    {

        page_title()->setTitle(trans('block::block.create'));

        Assets::addJavascript(['are-you-sure']);
        Assets::addAppModule(['form-validation']);

        return view('block::create');
    }

    /**
     * Insert new Block into database
     *
     * @param BlockRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Turash Chowdhury
     */
    public function postCreate(BlockRequest $request)
    {
        $block = $this->blockRepository->getModel();
        $block->fill($request->input());
        $block->user_id = Auth::user()->getKey();
        $block->alias = $this->blockRepository->createSlug($request->input('alias'), null);

        $this->blockRepository->createOrUpdate($block);

        event(new CreatedContentEvent(BLOCK_MODULE_SCREEN_NAME, $request, $block));

        if ($request->input('submit') === 'save') {
            return redirect()->route('block.list')->with('success_msg', trans('bases::notices.create_success_message'));
        } else {
            return redirect()->route('block.edit', $block->id)->with('success_msg', trans('bases::notices.create_success_message'));
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
        $block = $this->blockRepository->findById($id);
        if (empty($block)) {
            abort(404);
        }
        page_title()->setTitle(trans('block::block.edit') . ' # ' . $id);

        Assets::addJavascript(['are-you-sure']);
        Assets::addAppModule(['form-validation']);

        return view('block::edit', compact('block'));
    }

    /**
     * @param $id
     * @param BlockRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Turash Chowdhury
     */
    public function postEdit($id, BlockRequest $request)
    {
        $block = $this->blockRepository->findById($id);
        if (empty($block)) {
            abort(404);
        }
        $block->fill($request->input());
        $block->alias = $this->blockRepository->createSlug($request->input('alias'), $id);

        $this->blockRepository->createOrUpdate($block);

        event(new UpdatedContentEvent(BLOCK_MODULE_SCREEN_NAME, $request, $block));

        if ($request->input('submit') === 'save') {
            return redirect()->route('block.list')->with('success_msg', trans('bases::notices.update_success_message'));
        } else {
            return redirect()->route('block.edit', $id)->with('success_msg', trans('bases::notices.update_success_message'));
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
            $block = $this->blockRepository->findById($id);
            if (empty($block)) {
                abort(404);
            }
            $this->blockRepository->delete($block);
            event(new DeletedContentEvent(BLOCK_MODULE_SCREEN_NAME, $request, $block));

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
            $block = $this->blockRepository->findById($id);
            $this->blockRepository->delete($block);
            event(new DeletedContentEvent(BLOCK_MODULE_SCREEN_NAME, $request, $block));
        }

        return $response->setMessage(trans('bases::notices.delete_success_message'));
    }

    /**
     * @param Request $request
     * @param AjaxResponse $response
     * @return AjaxResponse
     * @author Turash Chowdhury
     */
    public function postChangeStatus(Request $request, AjaxResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response->setError(true)->setMessage(trans('bases::notices.no_select'));
        }

        foreach ($ids as $id) {
            $block = $this->blockRepository->findById($id);
            $block->status = $request->input('status');
            $this->blockRepository->createOrUpdate($block);
            event(new UpdatedContentEvent(BLOCK_MODULE_SCREEN_NAME, $request, $block));
        }

        return $response->setData($request->input('status'))
            ->setMessage(trans('bases::notices.update_success_message'));
    }
}
