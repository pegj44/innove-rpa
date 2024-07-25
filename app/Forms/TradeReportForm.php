<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class TradeReportForm extends Form
{
    public function buildForm()
    {
        $data = $this->getData('data');
        $tradingAccounts = requestApi('get', 'credentials');

        $accountCreds = [];
        foreach ($tradingAccounts as $accCred) {
            $accountCreds[$accCred['id']] = $accCred['account_id'];
        }

        $statuses = [
            'idle' => __('Idle'),
            'ongoing' => __('Ongoing'),
            'passed' => __('Passed'),
            'failed' => __('Failed')
        ];

        $this
            ->add('trade_account_credential_id', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Account ID (Required)'),
                'rules' => ['required'],
                'choices' => $accountCreds,
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Account ID --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['trade_account_credential_id']))? $data['trade_account_credential_id'] : ''
            ])
            ->add('starting_balance', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Starting Balance (Required)'),
                'rules' => ['required'],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['step' => '0.01', 'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['starting_balance']))? $data['starting_balance'] : ''
            ])
            ->add('starting_equity', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Starting Daily Equity (Required)'),
                'rules' => ['required'],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['step' => '0.01', 'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['starting_equity']))? $data['starting_equity'] : ''
            ])
            ->add('latest_equity', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Latest Equity (Required)'),
                'rules' => ['required'],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['step' => '0.01', 'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['latest_equity']))? $data['latest_equity'] : ''
            ])
            ->add('status', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Status (Required)'),
                'rules' => ['required'],
                'choices' => $statuses,
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Status --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['status']))? $data['status'] : 'idle'
            ])
            ->add('remarks', 'textarea', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Remarks'),
                'rules' => [],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['remarks']))? $data['remarks'] : ''
            ]);

        $submitLabel = (empty($data))? __('Save') : __('Update');

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

        $this->add('account_credential_form_buttons_group', 'wrapper', [
            'label_show' => false,
            'wrapper_class' => '',
            'field_col_class' => 'flex gap-4 justify-between mt-10',
            'fields' => $formButtonsField
        ]);
    }
}
