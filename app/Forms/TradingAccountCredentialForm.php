<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class TradingAccountCredentialForm extends Form
{
    public function buildForm()
    {
        $data = $this->getData('metadata');
        $tradingAccounts = requestApi('get', 'user/entities/individuals-and-funders');

        $individualsArr = [];
        $individuals = [];

        if (!empty($tradingAccounts['trading_individuals'])) {
            foreach ($tradingAccounts['trading_individuals'] as $individual) {
                foreach ($individual['metadata'] as $meta) {
                    $individualsArr[$individual['id']][$meta['key']] = $meta['value'];
                }
            }

            foreach ($individualsArr as $key => $val) {
                $individuals[$key] = $val['first_name'] .' '. $val['middle_name']. ' '. $val['last_name'];
            }
        }

        $funders = [];

        if (!empty($tradingAccounts['funders'])) {
            foreach ($tradingAccounts['funders'] as $funder) {
                foreach ($funder['metadata'] as $funderMeta) {
                    $funders[$funderMeta['funder_id']] = $funderMeta['value'];
                }
            }
        }

        $this
            ->add('trading_individual_id', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Account (Required)'),
                'rules' => ['required'],
                'choices' => $individuals,
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Unit --'),
                'default_value' => (!empty($data['trading_individual']))? $data['trading_individual'] : ''
            ])
            ->add('funder_id', 'select', [
                'wrapper' => ['class' => 'mb-5'],
                'label' => __('Funder (Required)'),
                'rules' => ['required'],
                'choices' => $funders,
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'empty_value' => __('-- Choose Unit --'),
                'default_value' => (!empty($data['funder']))? $data['funder'] : ''
            ])
            ->add('dashboard_login_wrapper', 'wrapper', [
                'label' => 'Dashboard Login',
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'wrapper_class' => '',
                'field_col_class' => 'mb-5',
                'fields' => [
                    $this->makeField('dashboard_login_url', 'url', [
                        'wrapper' => ['class' => 'mb-5'],
                        'label' => __('Login URL'),
                        'rules' => [],
                        'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                        'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                        'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                        'default_value' => (!empty($data['dashboard_login_url']))? $data['dashboard_login_url'] : ''
                    ]),
                    $this->makeField('dashboard_login_wrapper', 'wrapper', [
                        'label_show' => false,
                        'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
                        'wrapper_class' => '',
                        'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
                        'fields' => [
                            $this->makeField('dashboard_login_username', 'text', [
                                'label' => __('Username'),
                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                                'default_value' => (!empty($data['dashboard_login_username']))? $data['dashboard_login_username'] : ''
                            ]),
                            $this->makeField('dashboard_login_password', 'password', [
                                'label' => __('Password'),
                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                                'default_value' => (!empty($data['dashboard_login_password']))? $data['dashboard_login_password'] : ''
                            ]),
                        ]
                    ])
                ]
            ])
            ->add('platform_login_wrapper', 'wrapper', [
                'label' => 'Platform Login',
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'wrapper_class' => '',
                'field_col_class' => 'mb-5',
                'fields' => [
                    $this->makeField('platform_login_url', 'url', [
                        'wrapper' => ['class' => 'mb-5'],
                        'label' => __('Login URL'),
                        'rules' => [],
                        'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                        'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                        'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                        'default_value' => (!empty($data['platform_login_url']))? $data['platform_login_url'] : ''
                    ]),
                    $this->makeField('platform_login_wrapper', 'wrapper', [
                        'label_show' => false,
                        'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
                        'wrapper_class' => '',
                        'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
                        'fields' => [
                            $this->makeField('platform_login_username', 'text', [
                                'label' => __('Username'),
                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                                'default_value' => (!empty($data['platform_login_username']))? $data['platform_login_username'] : ''
                            ]),
                            $this->makeField('platform_login_password', 'password', [
                                'label' => __('Password'),
                                'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                                'default_value' => (!empty($data['platform_login_password']))? $data['platform_login_password'] : ''
                            ]),
                        ]
                    ])
                ]
            ]);

//
//            ->add('login_name', 'text', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Login Name (Required)'),
//                'rules' => ['required'],
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['login_name']))? $data['login_name'] : ''
//            ])
//            ->add('login_url', 'text', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Login URL (Required)'),
//                'rules' => ['required'],
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['login_url']))? $data['login_url'] : ''
//            ])
//            ->add('username', 'text', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Username (Required)'),
//                'rules' => ['required'],
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['username']))? $data['username'] : ''
//            ])
//            ->add('password', 'password', [
//                'wrapper' => ['class' => 'mb-5'],
//                'label' => __('Password (Required)'),
//                'rules' => ['required'],
//                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
//                'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
//                'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
//                'default_value' => (!empty($data['password']))? $data['password'] : ''
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
