<?php

namespace App\Addons\Support\Controllers;

use App\Addons\Support\Models\Faq;
use App\Addons\Support\Models\Ticket;
use App\Addons\Support\Models\Ticket_category;
use App\Addons\Support\Models\Ticket_priority;
use App\Http\Controllers\Controller;

class AddonServerSideDataController extends Controller
{

    public function ticket_server_side($string, $category, $priority, $status, $client, $staff)
    {
        $query = Ticket::query();
        if (! empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('subject', 'like', "%{$string}%");
            });
        }

        $filter_count = [];
        if ($category != 'all') {
            $filter_count[] = $category;
            $query->where(function ($q) use ($category) {
                $q->where('category_id', $category);
            });
        }
        if ($priority != 'all') {
            $filter_count[] = $priority;
            $query->where(function ($q) use ($priority) {
                $q->where('priority_id', $priority);
            });
        }
        if ($status != 'all') {
            $filter_count[] = $status;
            $query->where(function ($q) use ($status) {
                $q->where('status', $status);
            });
        }
        if ($client != 'all') {
            $filter_count[] = $client;
            $query->where(function ($q) use ($client) {
                $q->where('client_id', $client);
            });
        }
        if ($staff != 'all') {
            $filter_count[] = $staff;
            $query->where(function ($q) use ($staff) {
                $q->where('staff_id', $staff);
            });
        }

        if (get_current_user_role() == 'client') {
            $column = ['id', 'subject', 'status', 'priority', 'category', 'options'];
        } else {
            $column = ['id', 'subject', 'customer', 'status', 'priority', 'assigned_to', 'category', 'options'];
        }
        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($ticket) {

                static $key = 1;
                return '
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                    <p class="row-number fs-12px">' . $key++ . '</p>
                    <input type="hidden" class="datatable-row-id" value="' . $ticket->id . '">
                </div>
            ';
            })
            ->addColumn('subject', function ($ticket) {
                return $ticket?->subject;
            })

            ->addColumn('customer', function ($ticket) {
                return $ticket->user?->name;
            })

            ->addColumn('status', function ($ticket) {
                $status      = $ticket->status;
                $statusLabel = '';
                if ($status == 'in_progress') {
                    $statusLabel = '<span class="in_progress">' . get_phrase('In Progress') . '</span>';
                } elseif ($status == 'not_started') {
                    $statusLabel = '<span class="not_started">' . get_phrase('Not Started') . '</span>';
                } elseif ($status == 'completed') {
                    $statusLabel = '<span class="completed">' . get_phrase('Completed') . '</span>';
                }
                // Return the wrapped HTML
                return $statusLabel;
            })
            ->addColumn('priority', function ($ticket) {
                return $ticket->priority?->title;
            })
            ->addColumn('assigned_to', function ($ticket) {
                return $ticket->staff?->name;
            })
            ->addColumn('category', function ($ticket) {
                return $ticket->category?->title;
            })
            ->addColumn('options', function ($ticket) {
                // Generate routes dynamically
                $editRoute   = route(get_current_user_role() . '.addon.ticket.edit', $ticket->id);
                $deleteRoute = route(get_current_user_role() . '.addon.ticket.delete', $ticket->id);
                $viewRoute   = route(get_current_user_role() . '.addon.ticket.message', $ticket->code);

                return '
                <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                    <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fi-rr-menu-dots-vertical"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit ticket\')" href="#">' . get_phrase('Edit') . '</a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                        </li>
                         <li>
                            <a class="dropdown-item" href="' . $viewRoute . '">' . get_phrase('View Ticket') . '</a>
                        </li>
                    </ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($ticket) {
                $editRoute   = route(get_current_user_role() . '.addon.ticket.edit', $ticket->id);
                $deleteRoute = route(get_current_user_role() . '.addon.ticket.delete', $ticket->id);

                // Generate the context menu
                $contextMenu = [
                    'Edit'   => [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit ticket',
                    ],
                    'Delete' => [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete ticket',
                    ],
                ];

                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })

            ->rawColumns($column)
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function ticket_category_server_side($string)
    {
        $query = Ticket_category::query();
        if (! empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($category) {

                static $key = 1;
                return '
            <div class="d-flex align-items-center">
                <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                <p class="row-number fs-12px">' . $key++ . '</p>
                <input type="hidden" class="datatable-row-id" value="' . $category->id . '">
            </div>
            ';
            })
            ->addColumn('title', function ($category) {
                return $category?->title;
            })
            ->addColumn('status', function ($category) {
                $statusLabel = '';
                if ($category->status == 1) {
                    $statusLabel = '<span class="completed">' . get_phrase('Active') . '</span>';
                } elseif ($category->status == 0) {
                    $statusLabel = '<span class="in_progress">' . get_phrase('De-Active') . '</span>';
                }
                return $statusLabel;
            })
            ->addColumn('options', function ($category) {
                // Generate routes dynamically
                $editRoute   = route(get_current_user_role() . '.addon.ticket.category.edit', $category->id);
                $deleteRoute = route(get_current_user_role() . '.addon.ticket.category.delete', $category->id);
                // $viewRoute   = route(get_current_user_role() . '.ticket.details', $ticket->code);

                return '
            <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fi-rr-menu-dots-vertical"></span>
                </button>
                <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit category\')" href="#">' . get_phrase('Edit') . '</a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                        </li>
                </ul>
            </div>
        ';
            })
            ->addColumn('context_menu', function ($category) {
                $editRoute   = route(get_current_user_role() . '.addon.ticket.category.edit', $category->id);
                $deleteRoute = route(get_current_user_role() . '.addon.ticket.category.delete', $category->id);

                // Generate the context menu
                $contextMenu = [
                    'Edit'   => [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit category',
                    ],
                    'Delete' => [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete category',
                    ],
                ];

                //     // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(['id', 'title', 'status', 'options'])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->make(true);
    }

    public function ticket_priority_server_side($string)
    {
        $query = Ticket_priority::query();
        if (! empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($priority) {

                static $key = 1;
                return '
        <div class="d-flex align-items-center">
            <input type="checkbox" class="checkbox-item me-2 table-checkbox">
            <p class="row-number fs-12px">' . $key++ . '</p>
            <input type="hidden" class="datatable-row-id" value="' . $priority->id . '">
        </div>
        ';
            })
            ->addColumn('title', function ($priority) {
                return $priority?->title;
            })
            ->addColumn('status', function ($priority) {
                $statusLabel = '';
                if ($priority->status == 1) {
                    $statusLabel = '<span class="completed">' . get_phrase('Active') . '</span>';
                } elseif ($priority->status == 0) {
                    $statusLabel = '<span class="in_progress">' . get_phrase('De-Active') . '</span>';
                }
                return $statusLabel;
            })
            ->addColumn('options', function ($priority) {
                // Generate routes dynamically
                $editRoute   = route(get_current_user_role() . '.addon.ticket.priority.edit', $priority->id);
                $deleteRoute = route(get_current_user_role() . '.addon.ticket.priority.delete', $priority->id);
                // $viewRoute   = route(get_current_user_role() . '.ticket.details', $ticket->code);

                return '
        <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
            <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="fi-rr-menu-dots-vertical"></span>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit priority\')" href="#">' . get_phrase('Edit') . '</a>
                </li>
                <li>
                    <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                </li>
            </ul>
        </div>
    ';
            })
            ->addColumn('context_menu', function ($priority) {
                $editRoute   = route(get_current_user_role() . '.addon.ticket.priority.edit', $priority->id);
                $deleteRoute = route(get_current_user_role() . '.addon.ticket.priority.delete', $priority->id);

                // Generate the context menu
                $contextMenu = [
                    'Edit'   => [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit priority',
                    ],
                    'Delete' => [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete priority',
                    ],
                ];

                //     // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(['id', 'title', 'status', 'options'])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->make(true);

    }

    public function faq_server_side($string)
    {
        $query = Faq::query();
        if (! empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('question', 'like', "%{$string}%");
            });
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($faq) {

                static $key = 1;
                return '
            <div class="d-flex align-items-center">
                <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                <p class="row-number fs-12px">' . $key++ . '</p>
                <input type="hidden" class="datatable-row-id" value="' . $faq->id . '">
            </div>
            ';
            })
            ->addColumn('question', function ($faq) {
                return $faq?->question;
            })
            ->addColumn('answer', function ($faq) {
                return $faq?->answer;
            })
            ->addColumn('options', function ($faq) {
                // Generate routes dynamically
                $editRoute   = route(get_current_user_role() . '.addon.faq.edit', $faq->id);
                $deleteRoute = route(get_current_user_role() . '.addon.faq.delete', $faq->id);
                // $viewRoute   = route(get_current_user_role() . '.ticket.details', $ticket->code);

                return '
            <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fi-rr-menu-dots-vertical"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit ticket\')" href="#">' . get_phrase('Edit') . '</a>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                    </li>
                </ul>
            </div>
        ';
            })
            ->addColumn('context_menu', function ($faq) {
                $editRoute   = route(get_current_user_role() . '.addon.faq.edit', $faq->id);
                $deleteRoute = route(get_current_user_role() . '.addon.faq.delete', $faq->id);

                // Generate the context menu
                $contextMenu = [
                    'Edit'   => [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit faq',
                    ],
                    'Delete' => [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete faq',
                    ],
                ];

                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(['id', 'question', 'answer', 'options'])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->make(true);
    }

}
