<?php

namespace Botble\Member\Http\DataTables;

use Botble\Base\Http\DataTables\DataTableAbstract;
use Botble\Member\Repositories\Interfaces\MemberInterface;

class MemberDataTable extends DataTableAbstract
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author Turash Chowdhury
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->datatables
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                return anchor_link(route('member.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('cms.date_format.date'));
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, MEMBER_MODULE_SCREEN_NAME)
            ->addColumn('operations', function ($item) {
                return table_actions('member.edit', 'member.delete', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     * @author Turash Chowdhury
     * @since 2.1
     */
    public function query()
    {
        $model = app(MemberInterface::class)->getModel();
        /**
         * @var \Eloquent $model
         */
        $query = $model->select(['members.id', 'members.name', 'members.created_at',]);
        return $this->applyScopes(apply_filters(BASE_FILTER_DATATABLES_QUERY, $query, $model, MEMBER_MODULE_SCREEN_NAME));
    }

    /**
     * @return array
     * @author Turash Chowdhury
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id' => [
                'name' => 'members.id',
                'title' => trans('bases::tables.id'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
            'name' => [
                'name' => 'members.name',
                'title' => trans('bases::tables.name'),
                'class' => 'text-left searchable',
            ],
            'created_at' => [
                'name' => 'members.created_at',
                'title' => trans('bases::tables.created_at'),
                'width' => '100px',
                'class' => 'searchable',
            ],
        ];
    }

    /**
     * @return array
     * @author Turash Chowdhury
     * @since 2.1
     */
    public function buttons()
    {
        $buttons = [
            'create' => [
                'link' => route('member.create'),
                'text' => view('bases::elements.tables.actions.create')->render(),
            ],
        ];
        return apply_filters(BASE_FILTER_DATATABLES_BUTTONS, $buttons, MEMBER_MODULE_SCREEN_NAME);
    }

    /**
     * @return array
     * @author Turash Chowdhury
     * @since 2.1
     */
    public function actions()
    {
        return [
            'delete' => [
                'link' => route('member.delete.many'),
                'text' => view('bases::elements.tables.actions.delete')->render(),
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     * @author Turash Chowdhury
     * @since 2.1
     */
    protected function filename()
    {
        return MEMBER_MODULE_SCREEN_NAME;
    }
}
