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

        $theme = [
            'background_color' => '',
            'text_color' => ''
        ];

        if (!empty($data['theme'])) {
            $theme = explode('|', $data['theme']);
            $theme = [
                'background_color' => $theme[0],
                'text_color' => $theme[1]
            ];
        }

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
                    'default_value' => (!empty($data['reset_time']))? $data['reset_time'] : ''
                ]),
                $this->makeField('reset_time_zone', 'select', [
                    'label' => __('Timezone'),
                    'choices' => getTimezonesWithOffsets(),
                    'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                    'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                    'empty_value' => '-- Select Timezone --',
                    'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                    'default_value' => (!empty($data['reset_time_zone']))? $data['reset_time_zone'] : ''
                ])
            ]
        ])
        ->add('funder_theme_wrapper', 'wrapper', [
            'label' => 'Alias Colors',
            'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            'wrapper_class' => '',
            'field_col_class' => 'mb-5',
            'fields' => [
                $this->makeField('funder_theme_wrapper', 'wrapper', [
                    'label_show' => false,
                    'label_attr' => ['class' => 'block mb-1 text-sm font-medium text-gray-900 dark:text-white'],
                    'wrapper_class' => '',
                    'field_col_class' => 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-5',
                    'fields' => [
                        $this->makeField('background_color', 'text', [
                            'label' => __('Background Color'),
                            'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                            'default_value' => $theme['background_color']
                        ]),
                        $this->makeField('text_color', 'text', [
                            'label' => __('Text Color'),
                            'label_attr' => ['class' => 'block mb-2 text-sm text-gray-500 dark:text-gray-400'],
                            'attr' => ['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full'],
                            'errors' => ['class' => 'mt-1 text-red-400 text-sm'],
                            'default_value' => $theme['text_color']
                        ]),
                    ]
                ])
            ]
        ]);

        $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName();
        $submitLabel = ($currentRouteName === 'funder.edit')? __('Update Funder') : __('Add Funder');

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
