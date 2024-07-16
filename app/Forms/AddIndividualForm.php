<?php

namespace App\Forms;

use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

class AddIndividualForm extends Form
{
    public function buildForm()
    {
        $data = $this->getData('metadata');
        $tradingUnits = requestApi( 'get','trading-units');
        $pcUnits = collect($tradingUnits)->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->all();

        $this
        ->add('unit', 'select', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Unit (Required)'),
            'rules' => ['required'],
            'choices' => $pcUnits,
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
            'empty_value' => __('-- Choose Unit --'),
            'default_value' => (!empty($data['unit']))? $data['unit'] : ''
        ])
        ->add('type', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Type (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['type']))? $data['type'] : ''
        ])
        ->add('first_name', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('First Name (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['first_name']))? $data['first_name'] : ''
        ])
        ->add('middle_name', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Middle Name (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['middle_name']))? $data['middle_name'] : ''
        ])
        ->add('last_name', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Last Name (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['last_name']))? $data['last_name'] : ''
        ])
        ->add('email', 'email', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Email (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['email']))? $data['email'] : ''
        ])
        ->add('address', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Address (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['address']))? $data['address'] : ''
        ])
        ->add('city', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('City (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['city']))? $data['city'] : ''
        ])
        ->add('province', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Province (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['province']))? $data['province'] : ''
        ])
        ->add('zip_code', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Zip Code (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['zip_code']))? $data['zip_code'] : ''
        ])
        ->add('contact_number1', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Contact Number 1 (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['contact_number1']))? $data['contact_number1'] : ''
        ])
        ->add('contact_number2', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Contact Number 2'),
            'rules' => [],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['contact_number2']))? $data['contact_number2'] : ''
        ])
        ->add('birth_year', 'number', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Birth Year (Required)'),
            'rules' => ['required', 'numeric'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['birth_year']))? $data['birth_year'] : ''
        ])
        ->add('birth_month', 'select', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Birth Month (Required)'),
            'rules' => ['required'],
            'choices' => [
                '01' => __('January'),
                '02' => __('February'),
                '03' => __('March'),
                '04' => __('April'),
                '05' => __('May'),
                '06' => __('June'),
                '07' => __('July'),
                '08' => __('August'),
                '09' => __('September'),
                '10' => __('October'),
                '11' => __('November'),
                '12' => __('December'),
            ],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
            'empty_value' => __('-- Choose Month --'),
            'default_value' => (!empty($data['birth_month']))? $data['birth_month'] : ''
        ])
        ->add('birth_day', 'number', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Birth Day (Required)'),
            'rules' => ['required', 'numeric'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['birth_day']))? $data['birth_day'] : ''
        ])
        ->add('id_type', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('ID Type (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['id_type']))? $data['id_type'] : ''
        ])
        ->add('billing', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Billing (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['billing']))? $data['billing'] : ''
        ])
        ->add('remarks', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Remarks'),
            'rules' => [],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['remarks']))? $data['remarks'] : ''
        ]);

        $submitLabel = (empty($data))? __('Add Record') : __('Update Record');

        $formButtonsField = [
            $this->makeField('submit', 'submit', [
                'label' => '<svg class="w-[18px] h-[18px] text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M11 16h2m6.707-9.293-2.414-2.414A1 1 0 0 0 16.586 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7.414a1 1 0 0 0-.293-.707ZM16 20v-6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6h8ZM9 4h6v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V4Z"/></svg>'. $submitLabel,
                'attr' => ['class' => 'px-3 py-2 text-sm font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800']
            ])
        ];

        if (!empty($data)) {
            $formButtonsField[] = $this->makeField('cancel-update', 'button', [
                'label' => __('Cancel'),
                'attr' => [
                    'class' => 'px-3 py-2 text-sm font-medium text-center inline-flex items-center text-white bg-gray-700 rounded-md hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800',
                    'onclick' => 'window.location.href="'. route('funders') .'";'
                ]
            ]);
        }

        $this->add('funder_form_buttons_group', 'wrapper', [
            'label_show' => false,
            'wrapper_class' => '',
            'field_col_class' => 'flex gap-4 justify-between mt-10',
            'fields' => $formButtonsField
        ]);
    }
}
