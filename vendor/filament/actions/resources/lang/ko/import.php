<?php

return [

    'label' => ':label 가져오기',

    'modal' => [

        'heading' => ':label 가져오기',

        'form' => [

            'file' => [
                'label' => '파일',
                'placeholder' => 'CSV 파일 업로드',
                'rules' => [
                    'duplicate_columns' => '{0} 파일에 빈 열 헤더가 두 개 이상 있으면 안 됩니다.|{1,*} 파일에 중복된 열 헤더가 있으면 안 됩니다: :columns.',
                ],
            ],

            'columns' => [
                'label' => '열',
                'placeholder' => '열을 선택하세요',
            ],

        ],

        'actions' => [

            'download_example' => [
                'label' => '예시 CSV 파일 다운로드',
            ],

            'import' => [
                'label' => '가져오기',
            ],

        ],

    ],

    'notifications' => [

        'completed' => [

            'title' => '가져오기 완료',

            'actions' => [

                'download_failed_rows_csv' => [
                    'label' => '실패한 행에 대한 정보 다운로드|실패한 행들에 대한 정보 다운로드',
                ],

            ],

        ],

        'max_rows' => [
            'title' => '업로드된 CSV 파일이 너무 큽니다',
            'body' => '한 번에 1개의 행만 가져올 수 있습니다.|한 번에 :count개 이상의 행은 가져올 수 없습니다.',
        ],

        'started' => [
            'title' => '가져오기 시작됨',
            'body' => '가져오기가 시작되었으며 1개의 행이 백그라운드에서 처리됩니다.|가져오기가 시작되었으며 :count개의 행이 백그라운드에서 처리됩니다.',
        ],

    ],

    'example_csv' => [
        'file_name' => ':importer-example',
    ],

    'failure_csv' => [
        'file_name' => 'import-:import_id-:csv_name-failed-rows',
        'error_header' => '오류',
        'system_error' => '시스템 오류가 발생했습니다. 지원팀에 문의하세요.',
        'column_mapping_required_for_new_record' => '새 레코드를 생성하려면 :attribute 열이 파일의 열과 매핑되어야 합니다.',
    ],

];
