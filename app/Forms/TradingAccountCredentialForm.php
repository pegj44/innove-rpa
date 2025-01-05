<?php

namespace App\Forms;

use App\Http\Controllers\FunderController;
use Kris\LaravelFormBuilder\Form;

class TradingAccountCredentialForm extends Form
{
    public function buildForm()
    {
        $data = $this->getData('data');
        $symbols = getTradingSymbols();

        $tradingAccounts = requestApi('get', 'account/entities', [
            'userAccounts.tradingUnit',
            'funders.metadata'
        ]);

        $individuals = [];

        if (!empty($tradingAccounts['user_accounts'])) {
            foreach ($tradingAccounts['user_accounts'] as $individual) {
                $individuals[$individual['id']] = '['. $individual['trading_unit']['name'] .'] '. $individual['first_name'] .' '. $individual['middle_name']. ' '. $individual['last_name'] .' - '. $individual['email'];
            }
        }

        $funders = [];

        if (!empty($tradingAccounts['funders'])) {
            foreach ($tradingAccounts['funders'] as $funder) {
                $funders[$funder['id']] = $funder['name'];
            }
        }

        $packages = requestApi('get', 'funders/packages');

        if (!empty($packages)) {
            $packages = collect($packages)->mapWithKeys(function ($item) {
                return [$item['id'] => $item['funder']['alias'] .' - '. $item['name']];
            })->toArray();
        }

        $this
            ->add('user_account_id', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('User Account (Required)'),
                'rules' => ['required'],
                'choices' => $individuals,
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Account --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['user_account_id']))? $data['user_account_id'] : ''
            ])
//            ->add('funder_id', 'select', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Funder (Required)'),
//                'rules' => ['required'],
//                'choices' => $funders,
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
//                'empty_value' => __('-- Choose Funder --'),
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['funder_id']))? $data['funder_id'] : ''
//            ])
            ->add('funder_account_id', 'text', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Account ID (Required)'),
                'rules' => ['required'],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['funder_account_id']))? $data['funder_account_id'] : ''
            ])
            ->add('funder_package_id', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Package'),
//                'rules' => ['required'],
                'choices' => $packages,
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Package --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['funder_package_id']))? $data['funder_package_id'] : ''
            ])
//            ->add('asset_type', 'select', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Asset Type (Required)'),
//                'rules' => ['required'],
//                'choices' => [
//                    'futures' => __('Futures'),
//                    'forex' => __('Forex'),
//                    'crypto' => __('Crypto')
//                ],
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
//                'empty_value' => __('-- Choose Asset Type --'),
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['asset_type']))? $data['asset_type'] : ''
//            ])
//            ->add('symbol', 'select', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Symbol (Required)'),
//                'rules' => ['required'],
//                'choices' => $symbols,
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
//                'empty_value' => __('-- Choose Symbol --'),
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['symbol']))? $data['symbol'] : ''
//            ])
//            ->add('account_type', 'select', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Account Type (Required)'),
////                'rules' => ['required'],
//                'choices' => [
//                    '1-step' => __('1-Step'),
//                    '2-steps' => __('2-Steps'),
//                    'funded' => __('Funded')
//                ],
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
//                'empty_value' => __('-- Choose Account Type --'),
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['account_type']))? $data['account_type'] : ''
//            ])
//            ->add('current_phase', 'select', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Current Phase (Required)'),
////                'rules' => ['required'],
//                'choices' => [
//                    'phase-1' => __('Phase 1'),
//                    'phase-2' => __('Phase 2'),
//                    'phase-3' => __('Live')
//                ],
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
//                'empty_value' => __('-- Choose Phase --'),
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['current_phase']))? $data['current_phase'] : ''
//            ])
//            ->add('starting_balance', 'number', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Starting Balance (Required)'),
//                'rules' => ['required'],
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['min' => 0, 'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['starting_balance']))? $data['starting_balance'] : ''
//            ])
//            ->add('drawdown_type', 'select', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Drawdown Type (Required)'),
//                'choices' => [
//                    'static' => __('Static'),
//                    'trailing_intraday' => __('Trailing Intraday'),
//                    'trailing_endofday' => __('Trailing End of Day')
//                ],
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
//                'empty_value' => __('-- Choose Drawdown Type --'),
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['drawdown_type']))? $data['drawdown_type'] : ''
//            ])
//            ->add('phase_1_wrapper', 'wrapper', [
//                'label' => 'Phase 1',
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'wrapper_class' => 'phase-1-wrapper border-gray-600 border-t form-group mb-4 pt-4',
//                'field_col_class' => 'mb-5',
//                'fields' => [
//                    $this->makeField('phase_1_wrapper', 'wrapper', [
//                        'label_show' => false,
//                        'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
//                        'wrapper_class' => '',
//                        'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
//                        'fields' => [
//                            $this->makeField('phase_1_total_target_profit', 'number', [
//                                'label' => __('Total Target Profit'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_1_total_target_profit']))? $data['phase_1_total_target_profit'] : ''
//                            ]),
//                            $this->makeField('phase_1_daily_target_profit', 'number', [
//                                'label' => __('Daily Target Profit'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_1_daily_target_profit']))? $data['phase_1_daily_target_profit'] : ''
//                            ]),
//                        ]
//                    ]),
//                    $this->makeField('phase_1_drawdown_wrapper', 'wrapper', [
//                        'label_show' => false,
//                        'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
//                        'wrapper_class' => '',
//                        'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
//                        'fields' => [
//                            $this->makeField('phase_1_max_drawdown', 'number', [
//                                'label' => __('Max Drawdown'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_1_max_drawdown']))? $data['phase_1_max_drawdown'] : ''
//                            ]),
//                            $this->makeField('phase_1_daily_drawdown', 'number', [
//                                'label' => __('Daily Drawdown'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_1_daily_drawdown']))? $data['phase_1_daily_drawdown'] : ''
//                            ]),
//                        ]
//                    ])
//                ]
//            ])
//
//            ->add('phase_2_wrapper', 'wrapper', [
//                'label' => 'Phase 2',
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'wrapper_class' => 'phase-2-wrapper border-gray-600 border-t form-group mb-4 pt-4',
//                'field_col_class' => 'mb-5',
//                'fields' => [
//                    $this->makeField('phase_2_wrapper', 'wrapper', [
//                        'label_show' => false,
//                        'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
//                        'wrapper_class' => '',
//                        'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
//                        'fields' => [
//                            $this->makeField('phase_2_total_target_profit', 'number', [
//                                'label' => __('Total Target Profit'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_2_total_target_profit']))? $data['phase_2_total_target_profit'] : ''
//                            ]),
//                            $this->makeField('phase_2_daily_target_profit', 'number', [
//                                'label' => __('Daily Target Profit'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_2_daily_target_profit']))? $data['phase_2_daily_target_profit'] : ''
//                            ]),
//                        ]
//                    ]),
//                    $this->makeField('phase_2_drawdown_wrapper', 'wrapper', [
//                        'label_show' => false,
//                        'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
//                        'wrapper_class' => '',
//                        'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
//                        'fields' => [
//                            $this->makeField('phase_2_max_drawdown', 'number', [
//                                'label' => __('Max Drawdown'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_2_max_drawdown']))? $data['phase_2_max_drawdown'] : ''
//                            ]),
//                            $this->makeField('phase_2_daily_drawdown', 'number', [
//                                'label' => __('Daily Drawdown'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_2_daily_drawdown']))? $data['phase_2_daily_drawdown'] : ''
//                            ]),
//                        ]
//                    ])
//                ]
//            ])
//
//            ->add('phase_3_wrapper', 'wrapper', [
//                'label' => 'Live',
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'wrapper_class' => 'phase-3-wrapper border-b border-gray-600 border-t form-group mb-4 pt-4',
//                'field_col_class' => 'mb-5',
//                'fields' => [
//                    $this->makeField('phase_3_wrapper', 'wrapper', [
//                        'label_show' => false,
//                        'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
//                        'wrapper_class' => '',
//                        'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
//                        'fields' => [
//                            $this->makeField('phase_3_total_target_profit', 'number', [
//                                'label' => __('Total Target Profit'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_3_total_target_profit']))? $data['phase_3_total_target_profit'] : ''
//                            ]),
//                            $this->makeField('phase_3_daily_target_profit', 'number', [
//                                'label' => __('Daily Target Profit'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_3_daily_target_profit']))? $data['phase_3_daily_target_profit'] : ''
//                            ]),
//                        ]
//                    ]),
//                    $this->makeField('phase_3_drawdown_wrapper', 'wrapper', [
//                        'label_show' => false,
//                        'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
//                        'wrapper_class' => '',
//                        'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
//                        'fields' => [
//                            $this->makeField('phase_3_max_drawdown', 'number', [
//                                'label' => __('Max Drawdown'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_3_max_drawdown']))? $data['phase_3_max_drawdown'] : ''
//                            ]),
//                            $this->makeField('phase_3_daily_drawdown', 'number', [
//                                'label' => __('Daily Drawdown'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['phase_3_daily_drawdown']))? $data['phase_3_daily_drawdown'] : ''
//                            ]),
//                        ]
//                    ])
//                ]
//            ])
            ->add('status', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Status (Required)'),
                'rules' => ['required'],
                'choices' => [
                    'active' => __('Active'),
                    'inactive' => __('Inactive'),
                    'maintenance' => __('Maintenance')
                ],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Status --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['status']))? $data['status'] : ''
            ])
            ->add('priority', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Priority'),
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3'
                ],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Priority --'),
                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                'default_value' => (!empty($data['priority']))? $data['priority'] : ''
            ]);
//            ->add('platform_type', 'select', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Platform Type (Required)'),
//                'choices' => FunderController::$platforms,
//                'rules' => ['required'],
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
//                'empty_value' => __('-- Choose Platform Type --'),
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['platform_type']))? $data['platform_type'] : 0
//            ])
//            ->add('platform_url', 'text', [
//                'wrapper' => ['class' => 'mb-5 platform-url'],
//                'label' => __('Platform URL'),
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['platform_url']))? $data['platform_url'] : ''
//            ]);

//            ->add('platform_login_wrapper', 'wrapper', [
//                'label' => 'Platform Login',
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'wrapper_class' => '',
//                'field_col_class' => 'mb-5',
//                'fields' => [
////                    $this->makeField('platform_login_url', 'url', [
////                        'wrapper' => ['class' => 'mb-5'],
////                        'label' => __('Login URL'),
////                        'rules' => [],
////                        'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
////                        'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
////                        'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
////                        'default_value' => (!empty($data['platform_login_url']))? $data['platform_login_url'] : ''
////                    ]),
//                    $this->makeField('platform_login_wrapper', 'wrapper', [
//                        'label_show' => false,
//                        'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
//                        'wrapper_class' => '',
//                        'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
//                        'fields' => [
//                            $this->makeField('platform_login_username', 'text', [
//                                'label' => __('Username'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['platform_login_username']))? $data['platform_login_username'] : ''
//                            ]),
//                            $this->makeField('platform_login_password', 'password', [
//                                'label' => __('Password'),
//                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
//                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                                'default_value' => (!empty($data['platform_login_password']))? $data['platform_login_password'] : ''
//                            ]),
//                        ]
//                    ])
//                ]
//            ]);

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
