<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

//    'accepted' => 'Вы должны принять :attribute.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
//    'active_url' => 'The :attribute is not a valid URL.',
//    'after' => 'The :attribute must be a date after :date.',
//    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
//    'alpha' => 'The :attribute must only contain letters.',
//    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
//    'alpha_num' => 'The :attribute must only contain letters and numbers.',
//    'array' => 'The :attribute must be an array.',
//    'before' => 'The :attribute must be a date before :date.',
//    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
//    'between' => [
//        'array' => 'The :attribute must have between :min and :max items.',
//        'file' => 'The :attribute must be between :min and :max kilobytes.',
//        'numeric' => 'The :attribute must be between :min and :max.',
//        'string' => 'The :attribute must be between :min and :max characters.',
//    ],
//    'boolean' => 'The :attribute field must be true or false.',
//    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
//    'date' => 'The :attribute is not a valid date.',
//    'date_equals' => 'The :attribute must be a date equal to :date.',
//    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
//    'different' => 'The :attribute and :other must be different.',
//    'digits' => 'The :attribute must be :digits digits.',
//    'digits_between' => 'The :attribute must be between :min and :max digits.',
//    'dimensions' => 'The :attribute has invalid image dimensions.',
//    'distinct' => 'The :attribute field has a duplicate value.',
    'doesnt_end_with' => 'The :attribute may not end with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute may not start with one of the following: :values.',
//    'email' => 'The :attribute must be a valid email address.',
//    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
//    'exists' => 'The selected :attribute is invalid.',
//    'file' => 'The :attribute must be a file.',
//    'filled' => 'The :attribute field must have a value.',
//    'gt' => [
//        'array' => 'The :attribute must have more than :value items.',
//        'file' => 'The :attribute must be greater than :value kilobytes.',
//        'numeric' => 'The :attribute must be greater than :value.',
//        'string' => 'The :attribute must be greater than :value characters.',
//    ],
//    'gte' => [
//        'array' => 'The :attribute must have :value items or more.',
//        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
//        'numeric' => 'The :attribute must be greater than or equal to :value.',
//        'string' => 'The :attribute must be greater than or equal to :value characters.',
//    ],
//    'image' => 'The :attribute must be an image.',
//    'in' => 'The selected :attribute is invalid.',
//    'in_array' => 'The :attribute field does not exist in :other.',
//    'integer' => 'The :attribute must be an integer.',
//    'ip' => 'The :attribute must be a valid IP address.',
//    'ipv4' => 'The :attribute must be a valid IPv4 address.',
//    'ipv6' => 'The :attribute must be a valid IPv6 address.',
//    'json' => 'The :attribute must be a valid JSON string.',
//    'lt' => [
//        'array' => 'The :attribute must have less than :value items.',
//        'file' => 'The :attribute must be less than :value kilobytes.',
//        'numeric' => 'The :attribute must be less than :value.',
//        'string' => 'The :attribute must be less than :value characters.',
//    ],
//    'lte' => [
//        'array' => 'The :attribute must not have more than :value items.',
//        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
//        'numeric' => 'The :attribute must be less than or equal to :value.',
//        'string' => 'The :attribute must be less than or equal to :value characters.',
//    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
//    'max' => [
//        'array' => 'The :attribute must not have more than :max items.',
//        'file' => 'The :attribute must not be greater than :max kilobytes.',
//        'numeric' => 'The :attribute must not be greater than :max.',
//        'string' => 'The :attribute must not be greater than :max characters.',
//    ],
    'max_digits' => 'The :attribute must not have more than :max digits.',
//    'mimes' => 'The :attribute must be a file of type: :values.',
//    'mimetypes' => 'The :attribute must be a file of type: :values.',
//    'min' => [
//        'array' => 'The :attribute must have at least :min items.',
//        'file' => 'The :attribute must be at least :min kilobytes.',
//        'numeric' => 'The :attribute must be at least :min.',
//        'string' => 'The :attribute must be at least :min characters.',
//    ],
    'min_digits' => 'The :attribute must have at least :min digits.',
//    'multiple_of' => 'The :attribute must be a multiple of :value.',
//    'not_in' => 'The selected :attribute is invalid.',
//    'not_regex' => 'The :attribute format is invalid.',
//    'numeric' => 'The :attribute must be a number.',
    'password' => [
        'letters' => 'The :attribute must contain at least one letter.',
        'mixed' => 'The :attribute must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute must contain at least one number.',
        'symbols' => 'The :attribute must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
//    'present' => 'The :attribute field must be present.',
//    'prohibited' => 'The :attribute field is prohibited.',
//    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
//    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
//    'regex' => 'The :attribute format is invalid.',
//    'required' => 'The :attribute field is required.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
//    'required_if' => 'The :attribute field is required when :other is :value.',
//    'required_unless' => 'The :attribute field is required unless :other is in :values.',
//    'required_with' => 'The :attribute field is required when :values is present.',
//    'required_with_all' => 'The :attribute field is required when :values are present.',
//    'required_without' => 'The :attribute field is required when :values is not present.',
//    'required_without_all' => 'The :attribute field is required when none of :values are present.',
//    'same' => 'The :attribute and :other must match.',
//    'size' => [
//        'array' => 'The :attribute must contain :size items.',
//        'file' => 'The :attribute must be :size kilobytes.',
//        'numeric' => 'The :attribute must be :size.',
//        'string' => 'The :attribute must be :size characters.',
//    ],
//    'starts_with' => 'The :attribute must start with one of the following: :values.',
//    'string' => 'The :attribute must be a string.',
//    'timezone' => 'The :attribute must be a valid timezone.',
//    'unique' => 'The :attribute has already been taken.',
//    'uploaded' => 'The :attribute failed to upload.',
//    'url' => 'The :attribute must be a valid URL.',
//    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

//    'attributes' => [],

    'accepted' => 'Вы должны принять :attribute.',
//    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'Поле :attribute содержит недействительный URL.',
    'after' => 'В поле :attribute должна быть дата больше :date.',
    'after_or_equal' => 'В поле :attribute должна быть дата больше или равняться :date.',
    'alpha' => 'Поле :attribute может содержать только буквы.',
    'alpha_dash' => 'Поле :attribute может содержать только буквы, цифры, дефис и нижнее подчеркивание.',
    'alpha_num' => 'Поле :attribute может содержать только буквы и цифры.',
    'array' => 'Поле :attribute должно быть массивом.',
//    'ascii' => 'The :attribute must only contain single-byte alphanumeric characters and symbols.',
    'before' => 'В поле :attribute должна быть дата раньше :date.',
    'before_or_equal' => 'В поле :attribute должна быть дата раньше или равняться :date.',
    'between' => [
        'array' => 'Количество элементов в поле :attribute должно быть между :min и :max.',
        'file' => 'Размер файла в поле :attribute должен быть между :min и :max Килобайт(а).',
        'numeric' => 'Поле :attribute должно быть между :min и :max.',
        'string' => 'Количество символов в поле :attribute должно быть между :min и :max.',
    ],
    'boolean' => 'Поле :attribute должно иметь значение логического типа.',
    'confirmed' => 'Поле :attribute не совпадает с подтверждением.',
//    'current_password' => 'The password is incorrect.',
    'date' => 'Поле :attribute не является датой.',
    'date_equals' => 'Поле :attribute должно быть датой равной :date.',
    'date_format' => 'Поле :attribute не соответствует формату :format.',
//    'decimal' => 'The :attribute must have :decimal decimal places.',
//    'declined' => 'The :attribute must be declined.',
//    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'Поля :attribute и :other должны различаться.',
    'digits' => 'Длина цифрового поля :attribute должна быть :digits.',
    'digits_between' => 'Длина цифрового поля :attribute должна быть между :min и :max.',
    'dimensions' => 'Поле :attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute содержит повторяющееся значение.',
//    'distinct' => 'The :attribute field has a duplicate value.',
//    'doesnt_end_with' => 'The :attribute may not end with one of the following: :values.',
//    'doesnt_start_with' => 'The :attribute may not start with one of the following: :values.',
    'email' => 'Поле :attribute должно быть действительным электронным адресом.',
    'ends_with' => 'Поле :attribute должно заканчиваться одним из следующих значений: :values',
//    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'Выбранное значение для :attribute некорректно.',
    'file' => 'Поле :attribute должно быть файлом.',
    'filled' => 'Поле :attribute обязательно для заполнения.',
    'gt' => [
        'array' => 'Количество элементов в поле :attribute должно быть больше :value.',
        'file' => 'Размер файла в поле :attribute должен быть больше :value Килобайт(а).',
        'numeric' => 'Поле :attribute должно быть больше :value.',
        'string' => 'Количество символов в поле :attribute должно быть больше :value.',
    ],
    'gte' => [
        'array' => 'Количество элементов в поле :attribute должно быть :value или больше.',
        'file' => 'Размер файла в поле :attribute должен быть :value Килобайт(а) или больше.',
        'numeric' => 'Поле :attribute должно быть :value или больше.',
        'string' => 'Количество символов в поле :attribute должно быть :value или больше.',
    ],
    'image' => 'Поле :attribute должно быть изображением.',
    'in' => 'Выбранное значение для :attribute ошибочно.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => 'Поле :attribute должно быть целым числом.',
    'ip' => 'Поле :attribute должно быть действительным IP-адресом.',
    'ipv4' => 'Поле :attribute должно быть действительным IPv4-адресом.',
    'ipv6' => 'Поле :attribute должно быть действительным IPv6-адресом.',
    'json' => 'Поле :attribute должно быть JSON строкой.',
//    'lowercase' => 'The :attribute must be lowercase.',
    'lt' => [
        'array' => 'Количество элементов в поле :attribute должно быть меньше :value.',
        'file' => 'Размер файла в поле :attribute должен быть меньше :value Килобайт(а).',
        'numeric' => 'Поле :attribute должно быть меньше :value.',
        'string' => 'Количество символов в поле :attribute должно быть меньше :value.',
    ],
    'lte' => [
        'array' => 'Количество элементов в поле :attribute должно быть :value или меньше.',
        'file' => 'Размер файла в поле :attribute должен быть :value Килобайт(а) или меньше.',
        'numeric' => 'Поле :attribute должно быть :value или меньше.',
        'string' => 'Количество символов в поле :attribute должно быть :value или меньше.',
    ],
//    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'array' => 'Количество элементов в поле :attribute не может превышать :max.',
        'file' => 'Размер файла в поле :attribute не может быть больше :max Килобайт(а).',
        'numeric' => 'Поле :attribute не может быть больше :max.',
        'string' => 'Количество символов в поле :attribute не может превышать :max.',
    ],
//    'max_digits' => 'The :attribute must not have more than :max digits.',
    'mimes' => 'Поле :attribute должно быть файлом одного из следующих типов: :values.',
    'mimetypes' => 'Поле :attribute должно быть файлом одного из следующих типов: :values.',
    'min' => [
        'array' => 'Количество элементов в поле :attribute должно быть не меньше :min.',
        'file' => 'Размер файла в поле :attribute должен быть не меньше :min Килобайт(а).',
        'numeric' => 'Поле :attribute должно быть не меньше :min.',
        'string' => 'Количество символов в поле :attribute должно быть не меньше :min.',
    ],
//    'min_digits' => 'The :attribute must have at least :min digits.',
//    'missing' => 'The :attribute field must be missing.',
//    'missing_if' => 'The :attribute field must be missing when :other is :value.',
//    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
//    'missing_with' => 'The :attribute field must be missing when :values is present.',
//    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    'multiple_of' => 'Значение поля :attribute должно быть кратным :value',
    'not_in' => 'Выбранное значение для :attribute ошибочно.',
    'not_regex' => 'Выбранный формат для :attribute ошибочный.',
    'numeric' => 'Поле :attribute должно быть числом.',
//    'password' => [
//        'letters' => 'The :attribute must contain at least one letter.',
//        'mixed' => 'The :attribute must contain at least one uppercase and one lowercase letter.',
//        'numbers' => 'The :attribute must contain at least one number.',
//        'symbols' => 'The :attribute must contain at least one symbol.',
//        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
//    ],
    'present' => 'Поле :attribute должно присутствовать.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено, когда :other равно :value.',
    'prohibited_unless' => 'Поле :attribute запрещено, если :other не входит в :values.',
//    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'Поле :attribute имеет ошибочный формат.',
    'required' => 'Поле :attribute обязательно для заполнения.',
//    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'Поле :attribute обязательно для заполнения, когда :other равно :value.',
//    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_unless' => 'Поле :attribute обязательно для заполнения, когда :other не равно :values.',
    'required_with' => 'Поле :attribute обязательно для заполнения, когда :values указано.',
    'required_with_all' => 'Поле :attribute обязательно для заполнения, когда :values указано.',
    'required_without' => 'Поле :attribute обязательно для заполнения, когда :values не указано.',
    'required_without_all' => 'Поле :attribute обязательно для заполнения, когда ни одно из :values не указано.',
    'same' => 'Значения полей :attribute и :other должны совпадать.',
    'size' => [
        'array' => 'Количество элементов в поле :attribute должно быть равным :size.',
        'file' => 'Размер файла в поле :attribute должен быть равен :size Килобайт(а).',
        'numeric' => 'Поле :attribute должно быть равным :size.',
        'string' => 'Количество символов в поле :attribute должно быть равным :size.',
    ],
    'starts_with' => 'Поле :attribute должно начинаться из одного из следующих значений: :values',
    'string' => 'Поле :attribute должно быть строкой.',
    'timezone' => 'Поле :attribute должно быть действительным часовым поясом.',
    'unique' => 'Такое значение поля :attribute уже существует.',
    'uploaded' => 'Загрузка поля :attribute не удалась.',
//    'uppercase' => 'The :attribute must be uppercase.',
    'url' => 'Поле :attribute имеет ошибочный формат URL.',
//    'ulid' => 'The :attribute must be a valid ULID.',
    'uuid' => 'Поле :attribute должно быть корректным UUID.',

    'attributes' => [
        'password' => 'Пароль',
        'email' => 'E-mail',
        'login' => 'Логин',
        'phone' => 'Номер телефона',
        'lang' => 'Язык'
    ],
];
