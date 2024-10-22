<?php

namespace App\Forms;

use App\Http\Controllers\TradeReportController;
use Kris\LaravelFormBuilder\Form;

class TradeReportForm extends Form
{
    public function buildForm()
    {
        $data = $this->getData('data');
        $tradingAccounts = requestApi('get', 'credentials');

        $accountCreds = [];
        foreach ($tradingAccounts as $accCred) {
            $accountCreds[$accCred['id']] = $accCred['funder']['alias'] .' | '. $accCred['funder_account_id'] .' ['. $accCred['user_account']['trading_unit']['name'] .']';
        }

        $tradingAccountId = (!empty($data['trade_account_credential_id']))? $data['trade_account_credential_id'] : '';

        if (isset($accountCreds[$tradingAccountId])) {
            $tradingAccountId = $accountCreds[$tradingAccountId];
        }

        $this
            ->add('trade_account', 'static-field', [
                'tag' => 'div',
                'wrapper_class' => 'border-b border-gray-600 flex form-group items-center mb-4 pb-3',
                'label_attr' => ['class' => 'block font-medium text-gray-900 dark:text-white mr-2'],
                'value_class' => 'bg-gray-900 form px-2 py-1 rounded',
                'label' => 'Funder Account: ',
                'value' => $tradingAccountId
            ])
            ->add('starting_daily_equity', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Starting Daily Equity (Required)'),
                'rules' => ['required'],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['step' => '0.01', 'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['starting_daily_equity']))? $data['starting_daily_equity'] : ''
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
//            ->add('purchase_type', 'select', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Purchase Type (Required)'),
//                'rules' => ['required'],
//                'choices' => [
//                    'buy' => __('Buy'),
//                    'sell' => __('Sell')
//                ],
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
//                'empty_value' => __('-- Choose Purchase Type --'),
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['purchase_type']))? $data['purchase_type'] : ''
//            ])
//            ->add('order_amount', 'number', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Order Amount'),
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['order_amount']))? $data['order_amount'] : ''
//            ])
//            ->add('stop_loss_ticks', 'number', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Stop Loss (Ticks)'),
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['step' => '0.01', 'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['stop_loss_ticks']))? $data['stop_loss_ticks'] : ''
//            ])
//            ->add('take_profit_ticks', 'number', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Take Profit (Ticks)'),
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['step' => '0.01', 'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['take_profit_ticks']))? $data['take_profit_ticks'] : ''
//            ])
            ->add('status', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Status (Required)'),
                'rules' => ['required'],
                'choices' => TradeReportController::$statuses,
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
                    'onclick' => 'window.location.href="'. route('trade.play') .'";'
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
