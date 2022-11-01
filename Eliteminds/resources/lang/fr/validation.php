<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Lignes de langage de validation
    |--------------------------------------------------------------------------
    |
    | Les lignes de langue suivantes contiennent les messages d'erreur par défaut utilisés par la class validateur
    | Certaines de ces règles ont plusieurs versions telles que les règles de taille.
    |  N'hésitez pas à modifier chacun de ces messages ici
    */

    'accepted'             => 'Le :Attribut doit être accepté.',
    'active_url'           => 'Le :Attribut n\'est pas valide URL.',
    'after'                => 'Le :Attribut doit être une date postérieure à :date.',
    'after_or_equal'       => 'Le :Attribut doit être une date postérieure ou égale à :date.',
    'alpha'                => 'Le :Attribut ne peut contenir que des lettres.',
    'alpha_dash'           => 'Le :Attribut ne peut contenir que des lettres, des chiffres et des tirets.',
    'alpha_num'            => 'Le :Attribut ne peut contenir que des lettres et des chiffres.',
    'array'                => 'Le :Attribut doit être un tableau.',
    'before'               => 'Le :Attribut doit être une date antérieure à :date.',
    'before_or_equal'      => 'Le :Attribut doit être une date antérieure ou égale à :date.',
    'between'              => [
        'numeric' => 'Le :Attribut doit être compris entre :min and :max.',
        'file'    => 'Le :Attribut doit être compris entre :min and :max kilo-octets.',
        'string'  => 'Le :Attribut doit être compris entre :min and :max caractères.',
        'array'   => 'Le :Attribut doit être compris entre :min and :max éléments.',
    ],
    'boolean'              => 'Le : champ dattribut doit être must be true or false.',
    'confirmed'            => 'La :la confirmation dattribut ne correspond pas.',
    'date'                 => 'Le :Attribut nest pas une date valide.',
    'date_format'          => 'Le :Attribut ne correspond pas au format :format.',
    'different'            => 'Le :Attribut and :les autre doit être différent.',
    'digits'               => 'Le :Attribut doit être :digits digits.',
    'digits_between'       => 'Le :Attribut doit être entre :min and :max digits.',
    'dimensions'           => 'Le :Attribut a des dimensions d\'image non valides.',
    'distinct'             => 'Le :champ d\'attribut a une valeur en double.',
    'email'                => 'Le :attribut doit être une adresse e-mail valide.',
    'exists'               => 'le sélectionné : l\'attribut n\'est pas valide.',
    'file'                 => 'Le :Attribut doit être un fichier.',
    'filled'               => 'Le :champ d\'attribut doit avoir une valeur.',
    'image'                => 'Le :Attribut doit être une image.',
    'in'                   => 'Le sélectionné : l\'attribut n\'est pas valide.',
    'in_array'             => 'Le :champ d\'attribut n\'existe pas dans :autre.',
    'integer'              => 'Le :Attribut doit être un entier.',
    'ip'                   => 'Le :Attribut doit être une adresse IP valide.',
    'ipv4'                 => 'Le :Attribut doit être une adresse IPv4 valide.',
    'ipv6'                 => 'Le :Attribut doit être une adresse IPv6 valide.',
    'json'                 => 'Le :attribut doit être une  JSON string valide.',
    'max'                  => [
        'numeric' => 'Le :Attribut ne peut pas être supérieur à:max.',
        'file'    => 'Le :Attribut ne peut pas être supérieur à :max kilo-octets.',
        'string'  => 'Le :Attribut ne peut pas être supérieur à :max caractères.',
        'array'   => 'Le:Attribut ne peut pas avoir plus de:max éléments.',
    ],
    'mimes'                => 'Le :Attribut doit être un fichier de type :valeurs.',
    'mimetypes'            => 'Le :Attribut doit être un fichier de type: :valeurs.',
    'min'                  => [
        'numeric' => 'Le :attribute must be at least :min.',
        'file'    => 'Le :attribute must be at least :min kilo-octets.',
        'string'  => 'Le :attribute must be at least :min caractères.',
        'array'   => 'Le :attribute must have at least :min éléments.',
    ],
    'not_in'               => 'Le selected :attribute is invalid.',
    'not_regex'            => 'Le :attribute format is invalid.',
    'numeric'              => 'Le :Attribut doit être un nombre.',
    'present'              => 'Le :champ d\'attribut doit être présent.',
    'regex'                => 'Le :format d\'attribut n\'est pas valide.',
    'required'             => 'Le :champ d\'attribut est obligatoire.',
    'required_if'          => 'Le :champ d\'attribut est obligatoire quand :autre est :valeurs.',
    'required_unless'      => 'Le :champ d\'attribut est obligatoire sauf si :autre est dans :valeurs.',
    'required_with'        => 'Le :champ d\'attribut est obligatoire quand :valeurs sont présentes.',
    'required_with_all'    => 'Le :champ d\'attribut est obligatoire quand :valeurs sont présentes.',
    'required_without'     => 'Le :champ d\'attribut est obligatoire quand :valeurs ne sont pas présentes.',
    'required_without_all' => 'Le :champ d\'attribut est obligatoire quand aucun de :valeurs sont présentes.',
    'same'                 => 'Le :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'Le :Attribut doit être :taille.',
        'file'    => 'Le :Attribut doit être :taille kilo-octets.',
        'string'  => 'Le :Attribut doit être :taille des caractères.',
        'array'   => 'Le :Attribut doit contenir : éléments de taille.',
    ],
    'string'               => 'Le :Attribut doit être un string.',
    'timezone'             => 'Le :Attribut doit être une zone valide.',
    'unique'               => 'Le :attribut a déjà été pris.',
    'uploaded'             => 'Le :attribut n\'a pas pu être téléchargé.',
    'url'                  => 'Le :format d\'attribut n\'est pas valid.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
