<?php

namespace Botble\CustomField\Http\Controllers;

use Assets;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\AjaxResponse;
use Botble\CustomField\Actions\CreateCustomFieldAction;
use Botble\CustomField\Actions\DeleteCustomFieldAction;
use Botble\CustomField\Actions\ExportCustomFieldsAction;
use Botble\CustomField\Actions\ImportCustomFieldsAction;
use Botble\CustomField\Actions\UpdateCustomFieldAction;
use Botble\CustomField\Http\DataTables\CustomFieldDataTable;
use Botble\CustomField\Http\Requests\CreateFieldGroupRequest;
use Botble\CustomField\Http\Requests\UpdateFieldGroupRequest;
use Botble\CustomField\Repositories\Interfaces\FieldItemInterface;
use Botble\CustomField\Repositories\Interfaces\FieldGroupInterface;
use Exception;
use Illuminate\Http\Request;
use Botble\Base\Events\UpdatedContentEvent;

class CustomFieldController extends BaseController
{

    /**
     * @var FieldGroupInterface
     */
    protected $fieldGroupRepository;

    /**
     * @var FieldItemInterface
     */
    protected $fieldItemRepository;

    /**
     * @param FieldGroupInterface $fieldGroupRepository
     * @param FieldItemInterface $fieldItemRepository
     * @author Turash Chowdhury
     */
    public function __construct(FieldGroupInterface $fieldGroupRepository, FieldItemInterface $fieldItemRepository)
    {
        $this->fieldGroupRepository = $fieldGroupRepository;
        $this->fieldItemRepository = $fieldItemRepository;
    }

    /**
     * @param CustomFieldDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Turash Chowdhury
     */
    public function getList(CustomFieldDataTable $dataTable)
    {
        page_title()->setTitle(trans('custom-field::custom-field.custom_field_name'));

        Assets::addJavascriptDirectly('vendor/core/plugins/custom-field/js/import-field-group.js');
        Assets::addJavascript(['blockui']);

        return $dataTable->renderTable(['title' => trans('custom-field::custom-field.custom_field_name')], [], 'custom-field::list');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Turash Chowdhury
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('custom-field::custom-field.create_field_group'));

        Assets::addStylesheetsDirectly(['vendor/core/plugins/custom-field/css/custom-field.css']);
        Assets::addStylesheetsDirectly(['vendor/core/plugins/custom-field/css/edit-field-group.css']);
        Assets::addJavascriptDirectly('vendor/core/plugins/custom-field/js/edit-field-group.js');
        Assets::addJavascript(['jquery-ui']);

        return view('custom-field::create');
    }

    /**
     * @param CreateFieldGroupRequest $request
     * @param CreateCustomFieldAction $action
     * @return \Illuminate\Http\RedirectResponse
     * @author Turash Chowdhury
     */
    public function postCreate(CreateFieldGroupRequest $request, CreateCustomFieldAction $action)
    {
        $data = $request->input('field_group', []);
        $result = $action->run($data);

        $type = 'success_msg';
        $message = trans('bases::notices.create_success_message');
        if ($result['error']) {
            $type = 'error_msg';
            $message = $result['message'];
        }

        if ($request->input('submit') === 'save') {
            return redirect()->route('custom-fields.list')->with($type, $message);
        } else {
            return redirect()->route('custom-fields.edit', $result['data']['id'])->with($type, $message);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Turash Chowdhury, Tedozi Manson
     */
    public function getEdit($id)
    {

        page_title()->setTitle(trans('custom-field::custom-field.edit_field_group') . ' #' . $id);

        Assets::addStylesheetsDirectly(['vendor/core/plugins/custom-field/css/custom-field.css']);
        Assets::addStylesheetsDirectly(['vendor/core/plugins/custom-field/css/edit-field-group.css']);
        Assets::addJavascriptDirectly('vendor/core/plugins/custom-field/js/edit-field-group.js');
        Assets::addJavascript(['jquery-ui']);

        $object = $this->fieldGroupRepository->findById($id);

        if (!$object) {
            return redirect()->route('custom-fields.edit')->with('error_msg', 'This field group not exists');
        }

        $customFieldItems = json_encode($this->fieldGroupRepository->getFieldGroupItems($id));

        return view('custom-field::edit', compact('object', 'customFieldItems'));
    }

    /**
     * @param $id
     * @param UpdateFieldGroupRequest $request
     * @param UpdateCustomFieldAction $action
     * @return \Illuminate\Http\RedirectResponse
     * @author Turash Chowdhury, Tedozi Manson
     */
    public function postEdit($id, UpdateFieldGroupRequest $request, UpdateCustomFieldAction $action)
    {
        $data = $request->input('field_group', []);
        $result = $action->run($id, $data);

        $type = 'success_msg';
        $message = trans('bases::notices.update_success_message');
        if ($result['error']) {
            $type = 'error_msg';
            $message = $result['message'];
        }

        if ($request->input('submit') === 'save') {
            return redirect()->route('custom-fields.list')->with($type, $message);
        } else {
            return redirect()->route('custom-fields.edit', $result['data']['id'])->with($type, $message);
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @param AjaxResponse $response
     * @param DeleteCustomFieldAction $action
     * @return AjaxResponse
     * @author Turash Chowdhury
     */
    public function getDelete($id, AjaxResponse $response, DeleteCustomFieldAction $action)
    {
        try {
            $action->run($id);
            return $response->setMessage(trans('custom-field::field-groups.deleted'));
        } catch (Exception $ex) {
            return $response->setError(true)->setMessage(trans('custom-field::field-groups.cannot_delete'));
        }
    }

    /**
     * @param Request $request
     * @param AjaxResponse $response
     * @param DeleteCustomFieldAction $action
     * @return AjaxResponse
     * @author Turash Chowdhury
     */
    public function postDeleteMany(Request $request, AjaxResponse $response, DeleteCustomFieldAction $action)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response->setError(true)->setMessage(trans('custom-field::field-groups.notices.no_select'));
        }

        foreach ($ids as $id) {
            $action->run($id);
        }

        return $response->setMessage(trans('custom-field::field-groups.field_group_deleted'));
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
            return $response->setError(true)->setMessage(trans('custom-field::field-groups.notices.no_select'));
        }

        foreach ($ids as $id) {
            $field_group = $this->fieldGroupRepository->findById($id);
            $field_group->status = $request->input('status');
            $this->fieldGroupRepository->createOrUpdate($field_group);
            event(new UpdatedContentEvent(CUSTOM_FIELD_MODULE_SCREEN_NAME, $request, $field_group));
        }

        return $response->setData($request->input('status'))->setMessage(trans('custom-field::field-groups.notices.update_success_message'));
    }

    /**
     * @param ExportCustomFieldsAction $action
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExport(ExportCustomFieldsAction $action, $id = null)
    {
        $ids = [];

        if (!$id) {
            foreach ($this->fieldGroupRepository->all() as $item) {
                $ids[] = $item->id;
            }
        } else {
            $ids[] = $id;
        }

        $json = $action->run($ids)['data'];

        return response()->json($json, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param ImportCustomFieldsAction $action
     * @param Request $request
     * @return array
     * @throws Exception
     * @throws Exception
     */
    public function postImport(ImportCustomFieldsAction $action, Request $request)
    {
        $json = $request->input('json_data');

        return $action->run($json);
    }
}
