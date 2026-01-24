<?php

namespace App\Http\Controllers\Admin\Traits;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait HasUnifiedActionsDropdown
{
    /**
     * إضافة عمود الإجراءات الموحد مع dropdown menu
     * 
     * @param string $routePrefix مثال: 'client-type', 'city', 'subscription-type'
     * @param string $deleteMessage رسالة التأكيد عند الحذف
     * @param string $entityName اسم الكيان (لرسالة الحذف)
     */
    protected function addUnifiedActionsColumn($routePrefix, $deleteMessage = null, $entityName = null)
    {
        // إزالة جميع الأزرار الافتراضية
        CRUD::removeButton('show');
        CRUD::removeButton('edit');
        CRUD::removeButton('delete');
        CRUD::removeButton('revisions');
        CRUD::removeButton('reorder');
        
        // تعطيل عمود الإجراءات الافتراضي
        CRUD::setOperationSetting('lineButtonsAsDropdown', false);
        
        // رسالة الحذف الافتراضية
        if (!$deleteMessage) {
            $deleteMessage = $entityName 
                ? 'هل أنت متأكد من حذف ' . $entityName . ' هذا؟'
                : 'هل أنت متأكد من الحذف؟';
        }
        
        // إضافة عمود الإجراءات مع dropdown menu
        CRUD::addColumn([
            'name'  => 'actions',
            'label' => 'أجراءات',
            'type'  => 'custom_html',
            'value' => function ($entry) use ($routePrefix, $deleteMessage) {
                $editUrl = url(config('backpack.base.route_prefix') . '/' . $routePrefix . '/' . $entry->id . '/edit');
                $deleteUrl = url(config('backpack.base.route_prefix') . '/' . $routePrefix . '/' . $entry->id);
                
                return '
                <div class="btn-group unified-actions-dropdown dropdown" style="position: relative;">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="la la-cog"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="'.$editUrl.'">
                            <i class="la la-edit"></i> تعديل
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="'.$deleteUrl.'" 
                           onclick="event.preventDefault(); if(confirm(\''.$deleteMessage.'\')) { document.getElementById(\'delete-form-'.$entry->id.'\').submit(); }">
                            <i class="la la-trash"></i> حذف
                        </a></li>
                        <form id="delete-form-'.$entry->id.'" action="'.$deleteUrl.'" method="POST" style="display: none;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                        </form>
                    </ul>
                </div>';
            },
        ]);
    }
}

