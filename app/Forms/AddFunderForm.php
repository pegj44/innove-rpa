<?php

namespace App\Forms;

use App\Http\Controllers\FunderController;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class AddFunderForm extends Form
{
    public function buildForm()
    {
        $data = $this->getData();
        $metadata = (!empty($data['metadata']))? $data['metadata'] : [];

        $this
        ->add('name', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Funder Name (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['name']))? $data['name'] : ''
        ])
        ->add('alias', 'text', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Funder Alias (Required)'),
            'rules' => ['required'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['alias']))? $data['alias'] : ''
        ])
//        ->add('dashboard_url', 'text', [
//            'wrapper' => ['class' => 'mb-5'],
//            'label' => __('Dashboard URL'),
//            'rules' => ['url'],
//            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//            'default_value' => (!empty($metadata['dashboard_url']))? $metadata['dashboard_url'] : ''
//        ])
        ->add('automation', 'select', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Platform Type'),
            'rules' => ['required'],
            'choices' => FunderController::$platforms,
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
            'empty_value' => __('-- Select Platform Type --'),
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($data['automation']))? $data['automation'] : ''
        ])
        ->add('platform_url', 'text', [
            'wrapper' => ['class' => 'mb-5 platform-url'],
            'label' => __('Platform URL (Required)'),
            'rules' => ['url'],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($metadata['platform_url']))? $metadata['platform_url'] : ''
        ])
//        ->add('asset_type', 'select', [
//            'wrapper' => ['class' => 'mb-5'],
//            'label' => __('Instrument/Symbol'),
//            'rules' => ['required'],
//            'choices' => [
//                'XAUUSD' => __('XAUUSD'),
//                'BTCUSD' => __('BTCUSD'),
//                'ETHUSD' => __('ETHUSD'),
//            ],
//            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//            'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
//            'empty_value' => __('-- Select Asset Type --'),
//            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//            'default_value' => (!empty($data['asset_type']))? $data['asset_type'] : ''
//        ])
        ->add('evaluation_type', 'select', [
            'wrapper' => ['class' => 'mb-5'],
            'label' => __('Evaluation Type (Required)'),
            'rules' => ['required'],
            'choices' => [
                '1-step' => __('1 Step'),
                '2-step' => __('2 Step'),
                'funded' => __('Funded')
            ],
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
            'empty_value' => __('-- Choose Type --'),
            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
            'default_value' => (!empty($metadata['evaluation_type']))? $metadata['evaluation_type'] : ''
        ])
        ->add('daily_threshold_group', 'wrapper', [
            'label' => __('Daily Threshold (Required)'),
            'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
            'wrapper_class' => '',
            'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
            'fields' => [
                $this->makeField('daily_threshold', 'number', [
                    'label' => __('Value'),
                    'rules' => ['required'],
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full'],
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['daily_threshold']))? $metadata['daily_threshold'] : ''
                ]),
                $this->makeField('daily_threshold_type', 'select', [
                    'label' => __('Type'),
                    'rules' => ['required'],
                    'choices' => [
                        'percentage' => __('Percentage'),
                        'fixed' => __('Fixed')
                    ],
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['daily_threshold_type']))? $metadata['daily_threshold_type'] : ''
                ])
            ]
        ])
        ->add('max_drawdown_group', 'wrapper', [
            'label' => __('Max Drawdown (Required)'),
            'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
            'wrapper_class' => '',
            'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
            'fields' => [
                $this->makeField('max_drawdown', 'number', [
                    'label' => __('Value'),
                    'rules' => ['required'],
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full'],
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['max_drawdown']))? $metadata['max_drawdown'] : 0
                ]),
                $this->makeField('max_drawdown_type', 'select', [
                    'label' => __('Type'),
                    'rules' => ['required'],
                    'choices' => [
                        'percentage' => __('Percentage'),
                        'fixed' => __('Fixed')
                    ],
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['max_drawdown_type']))? $metadata['max_drawdown_type'] : ''
                ])
            ]
        ])
        ->add('phase_one_target_profit_group', 'wrapper', [
            'label' => 'Phase 1 Target Profit (Required)',
            'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
            'wrapper_class' => '',
            'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
            'fields' => [
                $this->makeField('phase_one_target_profit', 'number', [
                    'label' => __('Value'),
                    'rules' => ['required'],
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full'],
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['phase_one_target_profit']))? $metadata['phase_one_target_profit'] : 0
                ]),
                $this->makeField('phase_one_target_profit_type', 'select', [
                    'label' => __('Type'),
                    'rules' => ['required'],
                    'choices' => [
                        'percentage' => __('Percentage'),
                        'fixed' => __('Fixed')
                    ],
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['phase_one_target_profit_type']))? $metadata['phase_one_target_profit_type'] : ''
                ])
            ]
        ])
        ->add('phase_two_target_profit_group', 'wrapper', [
            'label' => 'Phase 2 Target Profit (Required)',
            'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
            'wrapper_class' => '',
            'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
            'fields' => [
                $this->makeField('phase_two_target_profit', 'number', [
                    'label' => __('Value'),
                    'rules' => ['required'],
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full'],
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['phase_two_target_profit']))? $metadata['phase_two_target_profit'] : 0
                ]),
                $this->makeField('phase_two_target_profit_type', 'select', [
                    'label' => __('Type'),
                    'rules' => ['required'],
                    'choices' => [
                        'percentage' => __('Percentage'),
                        'fixed' => __('Fixed')
                    ],
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['phase_two_target_profit_type']))? $metadata['phase_two_target_profit_type'] : ''
                ])
            ]
        ])
        ->add('consistency_rule', 'wrapper', [
            'label' => 'Consistency Rule',
            'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
            'wrapper_class' => '',
            'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
            'fields' => [
                $this->makeField('consistency_rule', 'number', [
                    'label' => __('Value'),
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full'],
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['consistency_rule']))? $metadata['consistency_rule'] : 0
                ]),
                $this->makeField('consistency_rule_type', 'select', [
                    'label' => __('Type'),
                    'choices' => [
                        'percentage' => __('Percentage'),
                        'fixed' => __('Fixed')
                    ],
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['consistency_rule_type']))? $metadata['consistency_rule_type'] : ''
                ])
            ]
        ])
        ->add('reset_time_group', 'wrapper', [
            'label' => 'Reset Time',
            'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
            'wrapper_class' => '',
            'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
            'fields' => [
                $this->makeField('reset_time', 'time', [
                    'label' => __('Time'),
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full'],
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['reset_time']))? $metadata['reset_time'] : ''
                ]),
                $this->makeField('reset_time_zone', 'select', [
                    'label' => __('Timezone'),
                    'choices' => getTimezonesWithOffsets(),
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                    'empty_value' => '-- Select Timezone --',
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($metadata['reset_time_zone']))? $metadata['reset_time_zone'] : ''
                ])
            ]
        ]);

        $submitLabel = (empty($metadata))? __('Add Funder') : __('Update Funder');
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
