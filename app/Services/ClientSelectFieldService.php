<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Collection;

/**
 * Business Purpose: بناء قوائم المشترك القابلة للبحث (Select2) لنماذج الإدارة والتقارير.
 */
final class ClientSelectFieldService
{
    /**
     * Business Purpose: جلب كل المشتركين مرتّبين بالاسم لنموذج التسليم.
     *
     * @return Collection<int, Client>
     */
    public function allClientsOrdered(): Collection
    {
        return Client::query()
            ->orderBy('name')
            ->get(['id', 'name', 'contract_no', 'phone_one']);
    }

    /**
     * Business Purpose: جلب المشتركين الرئيسيين (الأب) فقط للفواتير والمدفوعات.
     *
     * @return Collection<int, Client>
     */
    public function parentClientsOrdered(): Collection
    {
        return Client::query()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get(['id', 'name', 'contract_no', 'phone_one']);
    }

    /**
     * Business Purpose: تسمية غنية للعرض في البحث (اسم + عقد + هاتف).
     */
    public function richLabel(Client $client): string
    {
        $label = (string) $client->name;

        if (! empty($client->contract_no)) {
            $label .= ' ('.$client->contract_no.')';
        }

        if (! empty($client->phone_one)) {
            $label .= ' - '.$client->phone_one;
        }

        return $label;
    }

    /**
     * @param  Collection<int, Client>  $clients
     * @return array<int, string>
     */
    public function richLabelsFor(Collection $clients): array
    {
        $labels = [];

        foreach ($clients as $client) {
            $labels[(int) $client->id] = $this->richLabel($client);
        }

        return $labels;
    }

    /**
     * Business Purpose: إخراج HTML موحّد لحقل مشترك قابل للبحث داخل نماذج Backpack.
     *
     * @param  array{
     *     name?: string,
     *     label: string,
     *     hint?: string|null,
     *     required?: bool,
     *     allowEmpty?: bool,
     *     emptyLabel?: string,
     *     selectId?: string|null,
     *     placeholder?: string,
     *     selectedId?: int|string|null,
     *     clients?: Collection<int, Client>|null,
     *     optionLabels?: array<int, string>|null,
     *     parentsOnly?: bool,
     *     richLabels?: bool
     * }  $config
     */
    public function crudFieldHtml(array $config): string
    {
        $name = (string) ($config['name'] ?? 'client_id');
        $parentsOnly = (bool) ($config['parentsOnly'] ?? false);
        $richLabels = (bool) ($config['richLabels'] ?? false);

        $clients = $config['clients'] ?? (
            $parentsOnly ? $this->parentClientsOrdered() : $this->allClientsOrdered()
        );

        $optionLabels = $config['optionLabels'] ?? null;
        if ($optionLabels === null && $richLabels) {
            $optionLabels = $this->richLabelsFor($clients);
        }

        $isRequired = (bool) ($config['required'] ?? false);

        return view('admin.partials.crud_client_select_field', [
            'name' => $name,
            'label' => $config['label'],
            'hint' => $config['hint'] ?? null,
            'required' => $isRequired,
            'allowEmpty' => (bool) ($config['allowEmpty'] ?? true),
            'emptyLabel' => (string) ($config['emptyLabel'] ?? ($isRequired ? '-- اختر المشترك --' : 'الكل')),
            'selectId' => $config['selectId'] ?? null,
            'placeholder' => (string) ($config['placeholder'] ?? 'ابحث عن اسم المشترك…'),
            'selectedId' => $config['selectedId'] ?? null,
            'clients' => $clients,
            'optionLabels' => $optionLabels ?? [],
        ])->render();
    }
}
