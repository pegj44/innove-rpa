<?php

namespace App\Forms;

use App\Http\Controllers\FunderController;
use Kris\LaravelFormBuilder\Form;

class FunderPackages extends Form
{
    public function buildForm()
    {
        $funders = [];
        $data = $this->getData();
        $fundersDb = requestApi('get', 'funders');
        $symbols = getTradingSymbols();

        foreach ($fundersDb as $funder) {
            $funders[$funder['id']] = $funder['name'];
        }

        $this
            ->add('name', 'text', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Package Name'),
                'rules' => ['required'],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['name']))? $data['name'] : ''
            ])->add('funder_id', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Funder (Required)'),
                'rules' => ['required'],
                'choices' => $funders,
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Funder --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['funder_id']))? $data['funder_id'] : ''
            ])
            ->add('asset_type', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Asset Type (Required)'),
                'rules' => ['required'],
                'choices' => [
                    'futures' => __('Futures'),
                    'forex' => __('Forex'),
                    'crypto' => __('Crypto')
                ],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Asset Type --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['asset_type']))? $data['asset_type'] : ''
            ])
            ->add('symbol', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Symbol (Required)'),
                'rules' => ['required'],
                'choices' => $symbols,
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Symbol --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['symbol']))? $data['symbol'] : ''
            ])->add('current_phase', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Current Phase (Required)'),
                'rules' => ['required'],
                'choices' => [
                    'phase-1' => __('Phase 1'),
                    'phase-2' => __('Phase 2'),
                    'phase-3' => __('Live')
                ],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Phase --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['current_phase']))? $data['current_phase'] : ''
            ])
            ->add('starting_balance', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Starting Balance (Required)'),
                'rules' => ['required'],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['min' => 0, 'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['starting_balance']))? $data['starting_balance'] : ''
            ])
            ->add('drawdown_type', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'rules' => ['required'],
                'label' => __('Drawdown Type (Required)'),
                'choices' => [
                    'static' => __('Static'),
                    'trailing_intraday' => __('Trailing Intraday'),
                    'trailing_endofday' => __('Trailing End of Day')
                ],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Drawdown Type --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['drawdown_type']))? $data['drawdown_type'] : ''
            ])
            ->add('total_target_profit', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'rules' => ['required'],
                'label' => __('Total Target Profit'),
                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['total_target_profit']))? $data['total_target_profit'] : ''
            ])
            ->add('per_trade_target_profit', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'rules' => ['required'],
                'label' => __('Per Trade Target Profit'),
                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['per_trade_target_profit']))? $data['per_trade_target_profit'] : ''
            ])
            ->add('daily_target_profit', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'rules' => ['required'],
                'label' => __('Daily Target Profit'),
                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['daily_target_profit']))? $data['daily_target_profit'] : ''
            ])
            ->add('max_drawdown', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'rules' => ['required'],
                'label' => __('Max Drawdown'),
                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['max_drawdown']))? $data['max_drawdown'] : ''
            ])
            ->add('per_trade_drawdown', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'rules' => ['required'],
                'label' => __('Per Trade Drawdown'),
                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['per_trade_drawdown']))? $data['per_trade_drawdown'] : ''
            ])
            ->add('daily_drawdown', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'rules' => ['required'],
                'label' => __('Daily Drawdown'),
                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['daily_drawdown']))? $data['daily_drawdown'] : ''
            ])
            ->add('minimum_trading_days', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'rules' => ['required'],
                'label' => __('Minimum Trading Days'),
                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['minimum_trading_days']))? $data['minimum_trading_days'] : 10
            ])
            ->add('positive_trading_days_amount', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'rules' => ['required'],
                'label' => __('Positive Trading Days Amount'),
                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['positive_trading_days_amount']))? $data['positive_trading_days_amount'] : 200
            ])
            ->add('consistency', 'number', [
                'wrapper' => ['class' => 'mb-5'],
                'rules' => ['required'],
                'label' => __('Consistency %'),
                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['consistency']))? $data['consistency'] : 0
            ])
            ->add('platform_type', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Platform Type (Required)'),
                'choices' => FunderController::$platforms,
                'rules' => ['required'],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Platform Type --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['platform_type']))? $data['platform_type'] : 0
            ]);


        $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName();
        $submitLabel = ($currentRouteName === 'funders.packages.edit')? __('Update Package') : __('Add Package');

        $formButtonsField = [
            $this->makeField('submit', 'submit', [
                'label' => '<svg class="w-[18px] h-[18px] text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M11 16h2m6.707-9.293-2.414-2.414A1 1 0 0 0 16.586 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7.414a1 1 0 0 0-.293-.707ZM16 20v-6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6h8ZM9 4h6v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V4Z"/></svg>'. $submitLabel,
                'attr' => ['class' => 'px-3 py-2 text-sm font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800']
            ])
        ];

        if (!empty($metadata)) {
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
